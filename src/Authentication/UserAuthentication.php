<?php

declare(strict_types=1);

namespace Authentication;

use Entity\Exception\EntityNotFoundException;
use Entity\User;
use Authentication\Exception\AuthenticationException;

class UserAuthentication
{
    private const LOGIN_INPUT_NAME = 'login';
    private const PASSWORD_INPUT_NAME = 'password';

    public function loginForm(string $action, string $submitText = 'OK'): string
    {
        $login = $this::LOGIN_INPUT_NAME;
        $password = $this::PASSWORD_INPUT_NAME;

        return <<<HTML
        <form method="POST" action="{$action}">
            <input name="login" placeholder="{$login}"/>
            <input name="paswword" type="password" placeholder="{$password}"/>
            <button type="submit">{$submitText}</button>
        </form>
HTML;
    }

    public function getUserFromAuth(): User{
        $login = $this::LOGIN_INPUT_NAME;
        $password = $this::PASSWORD_INPUT_NAME;

        try {
            return User::findByCredentials($login, $password);
        }catch(EntityNotFoundException){
            throw new AuthenticationException();
        }
    }
}
