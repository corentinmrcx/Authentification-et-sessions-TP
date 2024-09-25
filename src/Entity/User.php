<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;

class User
{
    private int $id;
    private string $firstName;
    private string $lastName;
    private string $login;
    private string $phone;

    public function getId(): int
    {
        return $this->id;
    }

    public function getFirstname(): string
    {
        return $this->firstName;
    }

    public function getLastname(): string
    {
        return $this->lastName;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @throws EntityNotFoundException
     */
    public static function findByCredentials(string $login, string $password): User
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<'SQL'
            SELECT id, lastName, firstName, login, phone FROM user WHERE login = :login AND sha512pass = SHA2(:password, 512)
SQL);
        $stmt->execute([':login' => $login, ':password' => $password]);

        $user = $stmt->fetchObject(User::class);
        if (false === $user) {
            throw new EntityNotFoundException("L'utilisateur n'existe pas !");
        }

        return $user;
    }
}
