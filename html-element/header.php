<?php
require_once './classe/user.php';

session_start();

function generateHeader() {
    $header = '<header>';
    $header .= '<div class="header-logo">';
    $header .= '<img onclick="location.href=\'index.php\';" src="./assets/img/logo_livre-or.png" alt="logo module de connexion" title="logo module de connexion">';
    $header .= '</div>';
    $header .= '<div class="header-profil">';
    $header .= '<div class="header-profil-container">';

    if (isset($_SESSION['user'])) {
        $user = $_SESSION['user'];
        if ($user instanceof User && $user->getLogState() == true) {
            if ($user->getLogin() !== 'admin') {
                $header .= '<img onclick="location.href=\'profile.php\';" src="./assets/img/icone-profil-blanc.png" alt="icone profil" title="Profil">';
            } else {
                $header .= '<img onclick="location.href=\'admin.php\';" src="./assets/img/icone-profil-blanc.png" alt="icone profil" title="Profil">';
            }
        } else {
            $header .= '<img onclick="location.href=\'login.php\';" src="./assets/img/icone-profil-blanc.png" alt="icone profil" title="Profil">';
        }
    } else {
        $header .= '<img onclick="location.href=\'login.php\';" src="./assets/img/icone-profil-blanc.png" alt="icone profil" title="Profil">';
    }

    if (isset($_SESSION['user'])) {
        $user = $_SESSION['user'];
        if ($user->getLogState() == true) {
            $header .= '<a href="logout.php" class="logout-button">Déconnexion</a>';
        }   
    }

    $header .= '</div>';
    $header .= '</div>';
    $header .= '</header>';

    return $header;
}

?>