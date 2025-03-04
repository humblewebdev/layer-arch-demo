<?php

namespace SmileTrunk\Tasks;

use Phalcon\Cli\Task;
use SmileTrunk\exceptions\UnableToGetUsersException;
use SmileTrunk\Services\UserCreationSyncService;

class MainTask extends Task
{
    private UserCreationSyncService $userCreationSyncService;

    public function onConstruct(): void
    {
        $this->userCreationSyncService = $this->di->get(UserCreationSyncService::class);
    }

    /**
     * @throws UnableToGetUsersException
     */
    public function mainAction()
    {
        $this->userCreationSyncService->sync();
    }
}