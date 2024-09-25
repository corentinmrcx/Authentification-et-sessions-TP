<?php

declare(strict_types=1);

use Authentication\UserAuthentication;
use Html\AppWebPage;

// Création de l'authentification
$authentication = new UserAuthentication();

// Si on demande une déconnexion : des que le bouton deconnexion est cliquer
$authentication->logoutIfRequested();

$p = new AppWebPage('Authentification');

// Production du formulaire de connexion
$p->appendCSS(<<<CSS
    form input {
        width : 4em ;
    }
CSS
);
$form = $authentication->loginForm('auth.php');
if ($authentication->isUserConnected()){
    // Le action doit etre en corrélation avec le fichier dans lequel on est.
    $form = $authentication->logoutForm('form.php', "Deconnexion");
}

$p->appendContent(<<<HTML
    {$form}
    <p>Pour faire un test : essai/toto
HTML
);

echo $p->toHTML();
