<?php

namespace SmileTrunk\Repositories;

use SmileTrunk\exceptions\UnableToCreateUserException;
use SmileTrunk\Models\UserInterface;
use SmileTrunk\ValueObjects\User as UserValueObject;

interface UserRepositoryInterface
{
    /**
     * @return UserInterface[]
     */
    public function getUsers();

    /**
     * @throws UnableToCreateUserException
     */
    public function createUser(UserValueObject $userValueObject): UserInterface;

    public function updateUser(UserValueObject $userValueObject): ?UserInterface;
}