<?php

declare(strict_types=1);

namespace Html;

use Entity\User;

class UserProfile
{
    use StringEscaper;
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function toHtml(): string
    {
        return
            <<<HTML
            <p>Nom<br>&nbsp;&nbsp;&nbsp;&nbsp;{$this->escapeString($this->user->getLastname())}</p>
            <p>Prénom<br>&nbsp;&nbsp;&nbsp;&nbsp;{$this->escapeString($this->user->getFirstname())}</p>
            <p>Login<br>&nbsp;&nbsp;&nbsp;&nbsp;{$this->escapeString($this->user->getLogin())}[{$this->user->getId()}]</p>
            <p>Téléphone<br>&nbsp;&nbsp;&nbsp;&nbsp;{$this->escapeString($this->user->getPhone())}</p>
HTML;
    }
}
