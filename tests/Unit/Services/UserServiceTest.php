<?php

namespace Tests\Unit\Services;

use Mockery;
use Mockery\LegacyMockInterface;
use PHPUnit\Framework\TestCase;
use SmileTrunk\Clients\Mattermost;
use SmileTrunk\Services\UserRetrievalService;
use SmileTrunk\ValueObjects\User;

class UserServiceTest extends TestCase
{

    private Mockery\MockInterface|Mattermost $mockeryClientMock;
    private UserRetrievalService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockeryClientMock = Mockery::mock(Mattermost::class);
        $this->service = new UserRetrievalService($this->mockeryClientMock);
    }

    protected function tearDown(): void
    {
        parent::tearDown(); // TODO: Change the autogenerated stub
        Mockery::close();
    }

    public function testGetUsers()
    {
        $users = [
            User::fromObject((object)[
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => ''
            ]),
            User::fromObject((object)[
                'first_name' => '',
                'last_name' => 'Doe',
                'email' => 'test@example.com'
            ]),
            User::fromObject((object)[
                'first_name' => '',
                'last_name' => '',
                'email' => 'test@example.com'
            ]),
            User::fromObject((object)[
                'first_name' => '',
                'last_name' => 'Doe',
                'email' => ''
            ]),
            User::fromObject((object)[
                'first_name' => 'John',
                'last_name' => '',
                'email' => ''
            ]),
        ];
        $this->mockeryClientMock->shouldReceive('getUsers')
            ->once()
            ->andReturn($users);
        $this->assertCount(
            5,
            $this->service->getUsers()
        );
    }
}