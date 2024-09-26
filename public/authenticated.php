<?php
declare(strict_types=1);

use Authentication\UserAuthentication;
use Html\AppWebPage;

$authentication = new UserAuthentication();

// Un utilisateur est-il connecté ?
if (!$authentication->isUserConnected()) {
    header('Location: form.php');
    exit; // Fin du programme
}

$prenom = $authentication->getUser()->getFirstname();

$p = new AppWebPage();

$p->appendContent(<<<HTML
        <h2>Bonjour {$prenom}</h2>
HTML
);

echo $p->toHTML();
