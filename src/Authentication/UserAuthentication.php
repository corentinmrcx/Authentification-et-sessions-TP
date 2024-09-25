<?php

declare(strict_types=1);

namespace Authentication;

use Authentication\Exception\AuthenticationException;
use Entity\Exception\EntityNotFoundException;
use Entity\User;
use Service\Exception\SessionException;
use Service\Session;

class UserAuthentication
{
    private const LOGIN_INPUT_NAME = 'login';
    private const PASSWORD_INPUT_NAME = 'password';
    private const SESSION_KEY = '__UserAuthentication__';
    private const SESSION_USER_KEY = 'user';
    private const LOGOUT_INPUT_NAME = 'logout';
    private ?User $user = null;

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

    public function logoutForm(string $action, string $text): string{
        $logout = self::LOGOUT_INPUT_NAME;

        return <<<HTML
        <form method="POST" action="{$action}">
            <button type="submit" name="{$logout}">{$text}</button>
        </form>
HTML;
    }

    public function logoutIfRequested(): void{
        try{
            if (isset($_POST[self::LOGOUT_INPUT_NAME])) {
                Session::start();
                unset($_SESSION[self::SESSION_KEY][self::SESSION_USER_KEY]);
            }
        }catch (SessionException $e){
        }
    }

    /**
     * @throws AuthenticationException
     */
    public function getUserFromAuth(): User
    {
        $login = $_POST[self::LOGIN_INPUT_NAME];
        $password = $_POST[self::PASSWORD_INPUT_NAME];

        try {
            $user = User::findByCredentials($login, $password);

            $this -> setUser($user);
        } catch (EntityNotFoundException) {
            throw new AuthenticationException("Aucun utilisateur n'est trouvé !");
        }

        return $user;
    }

    /**
     * @throws SessionException
     */
    public function setUser(User $user): void{
        $this->user = $user;
        Session::start();
        $_SESSION[self::SESSION_KEY][self::SESSION_USER_KEY] = $user;
    }

    public function isUserConnected(): bool{
        Session::start();
        return isset($_SESSION[self::SESSION_KEY][self::SESSION_USER_KEY]) && $_SESSION[self::SESSION_KEY][self::SESSION_USER_KEY] instanceof User;
    }
}
