<?php

declare(strict_types=1);

namespace Authentication;

use Authentication\Exception\AuthenticationException;
use Entity\Exception\EntityNotFoundException;
use Entity\User;

class UserAuthentication
{
    private const LOGIN_INPUT_NAME = 'login';
    private const PASSWORD_INPUT_NAME = 'password';

    public function loginForm(string $action, string $submitText = 'OK'): string
    {
        $login = self::LOGIN_INPUT_NAME;
        $password = self::PASSWORD_INPUT_NAME;

        return <<<HTML
        <form method="POST" action="{$action}">
            <input name="{$login}" required/>
            <input name="{$password}" type="password" required/>
            <button type="submit">{$submitText}</button>
        </form>
HTML;
    }

    public function getUserFromAuth(): User
    {
        $login = $_POST[self::LOGIN_INPUT_NAME];
        $password = $_POST[self::PASSWORD_INPUT_NAME];

        try {
            $user = User::findByCredentials($login, $password);
        } catch (EntityNotFoundException) {
            throw new AuthenticationException("Aucun utilisateur n'est trouvé !");
        }

        return $user;
    }
}
