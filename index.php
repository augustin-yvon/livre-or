<?php
// Les inclusion de fichier doivent se faire avant de lancer la session
require_once './classe/user.php';
require_once './html-element/footer.php';
require_once './html-element/header.php';
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="icon" type="image/png" href="./assets/img/livre-or.png" />
        <link rel="stylesheet" href="./assets/css/index.css">

        <title>Livre d'Or | Accueil</title>
    </head>
    
    <body>
        <?php echo generateHeader(); ?>

        <section class="hero">
            <h1>
                Bienvenue sur<br>
                <div>
                    <span class="space-before_le"></span>le<span class="space-after_le"></span><span class="gray">Livre d'</span><span class="gold">Or</span>
                </div>
            </h1>
        </section>

        <section class="content">
            <div class="container">
                <div onclick="location.href='golden-book.php';" class="button">Consulter le Livre d'Or</div>
                <div class="form">
                    <div onclick="location.href='register.php';" class="button">Inscription</div>
                    <div onclick="location.href='login.php';" class="button">Connexion</div>
                </div>
                <p>Voir le <a href="https://github.com/augustin-yvon/module-connexion" target="_blank" title="repository github">code</a></p>
            </div>
        </section>

        <?php echo generateFooter(); ?>
    </body>
</html>