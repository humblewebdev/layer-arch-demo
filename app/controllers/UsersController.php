<?php
declare(strict_types=1);
namespace SmileTrunk\Controllers;

use SmileTrunk\Services\UserRetrievalService;
class UsersController extends ControllerBase
{
    private UserRetrievalService $userService;

    public function onConstruct()
    {
        $this->userService = $this->di->get(UserRetrievalService::class);
    }
    public function indexAction()
    {
        $users = $this->userService->getUsers();
        return $this->response->setJsonContent($users)->send();
    }

}

