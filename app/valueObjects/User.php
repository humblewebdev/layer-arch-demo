<?php
namespace SmileTrunk\ValueObjects;

use Webmozart\Assert\Assert;

class User
{
    private string $firstName;
    private string $lastName;
    private string $email;
    public static function fromObject(object $object): self
    {
        Assert::object($object);
        Assert::string($object->first_name);
        Assert::string($object->last_name);
        Assert::string($object->email);
        return new self(
            $object->first_name,
            $object->last_name,
            $object->email
        );
    }
    private function __construct(string $firstName, string $lastName, string $email)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
    }

    public function toArray(): array
    {
        return [
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'email' => $this->email,
        ];
    }
}