<?php
declare(strict_types=1);
namespace SmileTrunk\Controllers;

use SmileTrunk\Services\UserService;
class UsersController extends ControllerBase
{
    private UserService $userService;

    public function onConstruct()
    {
        $this->userService = $this->di->get(UserService::class);
    }
    public function indexAction()
    {
        $users = $this->userService->getUsers();
        return $this->response->setJsonContent($users)->send();
    }

}

