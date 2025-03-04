<?php
namespace SmileTrunk\ValueObjects;

use Webmozart\Assert\Assert;

class User
{
    private string $id;

    private string $firstName;

    private string $lastName;

    private string $email;

    private string $username;

    public static function fromObject(object $object): self
    {
        Assert::object($object);
        Assert::string($object->id);
        Assert::string($object->username);
        Assert::string($object->first_name);
        Assert::string($object->last_name);
        Assert::email($object->email);
        return new self(
            $object->id,
            $object->username,
            $object->first_name,
            $object->last_name,
            $object->email
        );
    }
    private function __construct(
        string $id,
        string $username,
        string $firstName,
        string $lastName,
        string $email
    ) {
        $this->id = $id;
        $this->username = $username;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'email' => $this->email,
        ];
    }

    public function foreignId(): string
    {
        return $this->id;
    }

    public function username(): string
    {
        return $this->username;
    }

    public function firstName(): string
    {
        return $this->firstName;
    }

    public function lastName(): string
    {
        return $this->lastName;
    }

    public function email(): string
    {
        return $this->email;
    }
}