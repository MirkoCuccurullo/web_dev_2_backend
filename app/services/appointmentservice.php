<?php

namespace Services;
use Repositories\AppointmentRepository;

class AppointmentService
{
    private $repository;

    function __construct()
    {
        $this->repository = new AppointmentRepository();
    }

    public function getAll($offset = NULL, $limit = NULL) {
        return $this->repository->getAllAppointments($offset, $limit);
    }

    public function getOne($id) {
        return $this->repository->getAppointmentById($id);
    }

    public function insert($item) {
        return $this->repository->addAppointment($item);
    }

    public function update($item, $id) {
        return $this->repository->updateAppointment($item, $id);
    }

    public function delete($item) {
        return $this->repository->deleteAppointment($item);
    }

}