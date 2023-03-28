<?php

namespace Controllers;
use Exception;
use Services\LawyerService;

class LawyerController extends Controller{
    private $service;

    // initialize services
    function __construct()
    {
        $this->service = new LawyerService();
    }

    public function getAll()
    {
        $token = $this->checkForJwt();
        if (!$token)
            return;

        if (isset($_GET["offset"]) && is_numeric($_GET["offset"])) {
            $offset = $_GET["offset"];
        }
        if (isset($_GET["limit"]) && is_numeric($_GET["limit"])) {
            $limit = $_GET["limit"];
        }

        $lawyers = $this->service->getAll();

        $this->respond($lawyers);
    }

    public function getOne($id)
    {
        $token = $this->checkForJwt();
        if (!$token) {
            return;
        }
        $lawyer = $this->service->getOne($id);

        // we might need some kind of error checking that returns a 404 if the product is not found in the DB
        if (!$lawyer) {
            $this->respondWithError(404, "Lawyer not found");
            return;
        }

        $this->respond($lawyer);
    }

    public function create()
    {
        $token = $this->checkForJwt();
        if (!$token) {
            return;
        }
        $data = $this->createObjectFromPostedJson("Models\\Lawyer");
        $lawyer = $this->service->insert($data);
        $this->respond($lawyer);
    }

    public function getLawAreas(){
//        $token = $this->checkForJwt();
//        if (!$token) {
//            return;
//        }
        $lawAreas = $this->service->getLawAreas();
        $this->respond($lawAreas);
    }

}