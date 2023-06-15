<?php
require_once './classe/user.php';
function generateFooter() {
    $footer = '<footer>';
    $footer .= '<p>';
    $footer .= '2023 © Réalisé par ';
    $footer .= '<a href="https://augustin-yvon.github.io/portfolio/" target="_blank" title="Mon Porfolio">Augustin Yvon</a>';
    $footer .= '</p>';
    $footer .= '</footer>';

    return $footer;
}
?>