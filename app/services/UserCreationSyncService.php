<?php

namespace SmileTrunk\Services;

use SmileTrunk\Clients\Mattermost;
use SmileTrunk\exceptions\UnableToGetUsersException;
use SmileTrunk\Repositories\UserRepository;
use SmileTrunk\Repositories\UserRepositoryInterface;
use SmileTrunk\ValueObjects\User;

class UserCreationSyncService
{
    private Mattermost $mattermost;
    private UserRepository $userRepository;

    public function __construct(
        Mattermost $mattermost,
        UserRepositoryInterface $userRepository
    ) {
        $this->mattermost = $mattermost;
        $this->userRepository = $userRepository;
    }

    /**
     * @throws UnableToGetUsersException
     */
    public function sync(): void
    {
        $mattermostUsers = $this->mattermost->getUsers();
        $users = $this->userRepository->getUsers();
        $usersHashMap = $this->convertToHashMap($users);
        foreach ($mattermostUsers as $mattermostUser) {
            /**
             * @var User $mattermostUser
             */
            if(empty($usersHashMap) || !isset($usersHashMap[$user->foreignId])) {
                dump('Creating user');
                $createdUser = $this->userRepository->createUser($mattermostUser);
                dump($createdUser);
                continue;
            }
            if (!$usersHashMap[$mattermostUser->foreignId()]->compare($mattermostUser)) {
                dump('Updating user');
                $this->userRepository->updateUser($mattermostUser);
            }
        }
    }

    private function convertToHashMap(array $users): array
    {
        $hashMap = [];
        foreach ($users as $user) {
            $hashMap[$user->foreignId] = $user;
        }
        return $hashMap;
    }
}