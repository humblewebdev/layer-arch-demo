<?php

namespace SmileTrunk\Services;

use League\Fractal\Manager;
use SmileTrunk\Models\UserInterface;
use SmileTrunk\Repositories\UserRepositoryInterface;
use League\Fractal\Resource\Collection;

class UserRetrievalService
{
    private UserRepositoryInterface $userRepository;
    private Manager $manager;

    public function __construct(
        UserRepositoryInterface $userRepository,
        Manager $manager
    ) {
        $this->userRepository = $userRepository;
        $this->manager = $manager;
    }

    public function getUsers(): array
    {
        $users = $this->userRepository->getUsers();
        $resource = new Collection($users, function(UserInterface $user) {
            return [
                'id'    => (int) $user->id(),
                'first_name' => $user->firstName(),
                'last_name' => $user->lastName(),
                'username' => $user->username(),
                'email' => $user->email(),
                'links' => [
                    'self' => '/api/v1/users/'.$user->id,
                ]
            ];
        });
        return $this->manager->createData($resource)->toArray();
    }
}