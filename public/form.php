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
try{
    $utilisateur = $authentication->getUser();
    $profil_utilisateur = new \Html\UserProfile($utilisateur);
    $p -> appendContent($profil_utilisateur->toHtml());
    $form = $authentication->logoutForm('form.php', "Deconnexion");
}
catch (\Authentication\Exception\NotLoggedInException $e){
    $form = $authentication->loginForm('auth.php');
}

$p->appendContent(<<<HTML
    {$form}
    <p>Pour faire un test : essai/toto
HTML
);

echo $p->toHTML();
