<?php

namespace Services;
use Repositories\LawyerRepository;
class LawyerService
{
    private $repository;

    function __construct()
    {
        $this->repository = new LawyerRepository();
    }

    public function getAll($offset = NULL, $limit = NULL) {
        return $this->repository->getAllLawyers($offset, $limit);
    }

    public function getOne($id) {
        return $this->repository->getLawyerById($id);
    }

    public function insert($item) {
        return $this->repository->addLawyer($item);
    }


}