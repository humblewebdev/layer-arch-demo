<?php

namespace SmileTrunk\Services;

use SmileTrunk\Clients\Mattermost as MattermostClient;

class UserService
{
    private MattermostClient $mattermostClient;

    public function __construct(MattermostClient $mattermostClient)
    {
        $this->mattermostClient = $mattermostClient;
    }

    public function getUsers(): array
    {
        $users = $this->mattermostClient->getUsers();
        $usersResponse = [];
        foreach ($users as $user) {
            $usersResponse[] = $user->toArray();
        }
        return $usersResponse;
    }
}