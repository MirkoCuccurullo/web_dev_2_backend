<?php

namespace Repositories;
use Models\Appointment;
use PDO;
use PDOException;
use Repositories\Repository;

require_once("../models/appointment.php");

class AppointmentRepository extends Repository
{
    public function getAppointmentById($id){
        $sqlQ = "SELECT * FROM event WHERE id = :id";
        $stmt = $this->connection->prepare($sqlQ);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $row = $stmt->fetch();
        $appointment = $this->rowToAppointment($row);

        return $appointment;
    }
    public function addAppointment($appointment){

        $sqlQ = "INSERT INTO event (client_name,lawyer_id,date,time_from,time_to,created, google_calendar_event_id) VALUES 
                                                                                  (:client_name,:lawyer_id,:date,:time_from,:time_to,NOW(),:googleId)";
        $stmt = $this->connection->prepare($sqlQ);
        $stmt->bindParam(':client_name', $appointment->client_name);
        $stmt->bindParam(':lawyer_id', $appointment->lawyer_id);
        $stmt->bindParam(':date', $appointment->date);
        $stmt->bindParam(':time_from', $appointment->time_from);
        $stmt->bindParam(':time_to', $appointment->time_to);
        $emptyString = "";
        $stmt->bindParam(':googleId', $emptyString);

        $stmt->execute();
        $last_id = $this->connection->lastInsertId();
        return $this->getAppointmentById($last_id);


    }

    public function getAllAppointments(){

        $stmt = $this->connection->prepare("select * from event");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $appointments = array();
        while (($row = $stmt->fetch(PDO::FETCH_ASSOC)) !== false) {
            $appointments[] = $this->rowToAppointment($row);
        }

        return $appointments;
    }

    function rowToAppointment($row) {
        $appointment = new Appointment();
        $appointment->id = $row['id'];
        $appointment->client_name = $row['client_name'];
        $appointment->lawyer_id = $row['lawyer_id'];
        $appointment->date = $row['date'];
        $appointment->time_from = $row['time_from'];
        $appointment->time_to = $row['time_to'];
        $appointment->created = $row['created'];
        $appointment->google_calendar_event_id = $row['google_calendar_event_id'];
        $lawyer_repo = new LawyerRepository();
        $lawyer = $lawyer_repo->getLawyerById($appointment->lawyer_id);

        $appointment->lawyer = $lawyer;
        $appointment->lawyer_name = $lawyer->firstname;

        return $appointment;
    }

    public function deleteAppointment($appointmentId){

        $stmt = $this->connection->prepare("delete from event where id=$appointmentId");
        $appointment = $this->getAppointmentById($appointmentId);
        $stmt->execute();
        return $appointment;
    }

    public function updateAppointment($newAppointment, $id)
    {

        $sqlQ = "UPDATE event SET client_name=:client_name,date=:date,time_from=:timef,time_to=:timet WHERE id=:id";
        $stmt = $this->connection->prepare($sqlQ);
        $stmt->bindParam(':client_name', $newAppointment->client_name);
        $stmt->bindParam(':date', $newAppointment->date);
        $stmt->bindParam(':timef', $newAppointment->time_from);
        $stmt->bindParam(':timet', $newAppointment->time_to);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $this->getAppointmentById($id);
    }

}