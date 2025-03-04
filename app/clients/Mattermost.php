<?php
namespace SmileTrunk\Clients;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use SmileTrunk\exceptions\UnableToGetUsersException;
use SmileTrunk\ValueObjects\User;
use Webmozart\Assert\InvalidArgumentException;

class Mattermost
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return User[]
     * @throws UnableToGetUsersException
     */
    public function getUsers(): array
    {
        try {
        $users = json_decode(
            $this->client->get(
                $_ENV['MATTERMOST_BASE_URL'] . '/api/v4/users',
            )->getBody()->getContents()
        );
        $userObjects = [];
        foreach ($users as $user) {
            try {
                $userObjects[] = User::fromObject($user);
            } catch (InvalidArgumentException $e) {
                continue;
            }
        }
        return $userObjects;
        } catch (GuzzleException $e) {
            throw new UnableToGetUsersException($e);
        }
    }
}