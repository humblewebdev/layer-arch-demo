<?php
namespace SmileTrunk\Repositories;

use SmileTrunk\exceptions\UnableToCreateUserException;
use SmileTrunk\exceptions\UnableToUpdateUserException;
use SmileTrunk\Models\UserInterface;
use SmileTrunk\Models\Users;
use SmileTrunk\ValueObjects\User as UserValueObject;

class UserRepository implements UserRepositoryInterface
{

    /**
     * @return UserInterface[]
     */
    public function getUsers()
    {
        return Users::find();
    }

    /**
     * @throws UnableToCreateUserException
     */
    public function createUser(UserValueObject $userValueObject): UserInterface
    {
        $user = new Users();
        $user->foreignId = $userValueObject->foreignId();
        $user->username = $userValueObject->username();
        $user->firstName = $userValueObject->firstName();
        $user->lastName = $userValueObject->lastName();
        $user->email = $userValueObject->email();
        $result = $user->save();
        if (!$result) {
            throw new UnableToCreateUserException(
                implode(", ", $user->getMessages())
            );
        }
        return $user;
    }

    public function updateUser(UserValueObject $userValueObject): ?UserInterface
    {
        $user = Users::findFirst(['foreignId' => $userValueObject->foreignId()]);
        if ($user) {
            $user->username = $userValueObject->username();
            $user->firstName = $userValueObject->firstName();
            $user->lastName = $userValueObject->lastName();
            $user->email = $userValueObject->email();
            $result = $user->save();
            if (!$result) {
                throw new UnableToUpdateUserException(
                    implode(", ", $user->getMessages())
                );
            }
            return $user;
        }
        return null;
    }
}