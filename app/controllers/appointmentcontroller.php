<?php

namespace Controllers;
use Exception;
use Services\AppointmentService;

class AppointmentController extends Controller
{
    private $service;

    // initialize services
    function __construct()
    {
        $this->service = new AppointmentService();
    }

    public function getAll()
    {
        $token = $this->checkForJwt();
        if (!$token)
            return;

        $offset = NULL;
        $limit = NULL;

        if (isset($_GET["offset"]) && is_numeric($_GET["offset"])) {
            $offset = $_GET["offset"];
        }
        if (isset($_GET["limit"]) && is_numeric($_GET["limit"])) {
            $limit = $_GET["limit"];
        }

        $appointments = $this->service->getAll($offset, $limit);

        $this->respond($appointments);
    }

    public function getOne($id)
    {
        $token = $this->checkForJwt();
        if (!$token) {
            return;
        }
        $appointment = $this->service->getOne($id);

        // we might need some kind of error checking that returns a 404 if the product is not found in the DB
        if (!$appointment) {
            $this->respondWithError(404, "Appointment not found");
            return;
        }

        $this->respond($appointment);
    }

    public function create()
    {

        $data = $this->createObjectFromPostedJson("Models\\Appointment");

        $appointment = $this->service->insert($data);

        $this->respond($appointment);
    }

    public function update($id)
    {
        $token = $this->checkForJwt();
        if (!$token) {
            return;
        }
        $data = $this->createObjectFromPostedJson("Models\\Appointment");

        $appointment = $this->service->update($data, $id);

        $this->respond($appointment);
    }

    public function delete($id)
    {
        $token = $this->checkForJwt();
        if (!$token) {
            return;
        }
        $appointment = $this->service->delete($id);

        $this->respond($appointment);
    }

}