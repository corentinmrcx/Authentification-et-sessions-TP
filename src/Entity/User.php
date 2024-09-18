<?php
declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;

class User
{
    private int $id;
    private string $firstname;
    private string $lastname;
    private string $login;
    private string $phone;

    public function getId(): int
    {
        return $this->id;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function findByCredentials(string $login, string $password): self{
        $stmt = MyPdo::getInstance()-> prepare(
            <<<'SQL'
            SELECT id FROM users WHERE login = :login AND sha512pass = SHA2(:password, 512)
SQL);
        $stmt -> execute([":login" => $login, ":password" => $password]);

        $res = $stmt->fetchObject();

        if ($res)
            return $res;
        else
            throw new EntityNotFoundException();
    }
}