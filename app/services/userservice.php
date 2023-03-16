<?php
namespace Services;

use Repositories\UserRepository;

class UserService {

    private $repository;

    function __construct()
    {
        $this->repository = new UserRepository();
    }

    public function checkUsernamePassword($email, $password) {
        return $this->repository->checkUsernamePassword($email, $password);
    }

    public function create($user)
    {
        $user->password = $this->repository->hashPassword($user->password);
        return $this->repository->create($user);
    }
}

?>