<?php

namespace Repositories;

use Models\Lawyer;
use PDO;
use PDOException;
use Repositories\Repository;

require_once("../models/lawyer.php");

class LawyerRepository extends Repository
{
    public function addLawyer($lawyer)
    {
        try {

            $stmt = $this->connection->prepare("INSERT INTO `employee` (`firstname`, `email`, `type`)
            VALUES (:firstname, :email, :type);");
            $stmt->bindParam(':firstname', $lawyer->firstname);
            $stmt->bindParam(':email', $lawyer->email);
            $stmt->bindParam(':type', $lawyer->type);
            $stmt->execute();

            $last_id = $this->connection->lastInsertId();
            return $this->getLawyerById($last_id);
        } catch (PDOException $e) {
            echo $e;
        }

    }


    public function getAllLawyers(){


        $stmt = $this->connection->prepare("select employee.*, type.description as area from employee inner join employee_type as type on employee.type = type.type_id");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $lawyers = array();
        while (($row = $stmt->fetch(PDO::FETCH_ASSOC)) !== false) {
            $lawyers[] = $this->rowToLawyer($row);
        }

        return $lawyers;
    }


    public function getLawyerById($id){

        try {
            $stmt = $this->connection->prepare("SELECT employee.*, type.description as area FROM employee inner join employee_type as type on employee.type = type.type_id WHERE employee_id=:id");
            $stmt->bindValue(':id', $id);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $row = $stmt->fetch();
            $lawyer = $this->rowToLawyer($row);

            return $lawyer;
        }catch (PDOException $e) {
            echo $e;
        }
    }

    private function rowToLawyer($row)
    {
        $lawyer = new Lawyer();
        $lawyer->employee_id = $row['employee_id'];
        $lawyer->firstname = $row['firstname'];
        $lawyer->email = $row['email'];
        $lawyer->type = $row['type'];
        $lawyer->area = $row['area'];
        return $lawyer;
    }

    public function getLawAreas(){
        require_once __DIR__ . '/../models/law_area.php';

        $stmt = $this->connection->prepare("select * from employee_type");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Models\\Law_area');
        return $stmt->fetchAll();
    }


}