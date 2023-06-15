<?php
require_once './classe/user.php';
require_once './classe/database.php';
require_once './html-element/footer.php';
require_once './html-element/header.php';

$db = new Database();

$errors = array();

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $login = htmlspecialchars($_POST["login"]);
    $password = htmlspecialchars($_POST["password"]);
    $confirmPassword = htmlspecialchars($_POST["confirm_password"]);

    // Vérifier si le mot de passe respecte les critères
    $passwordPattern = "/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/";
    if (!preg_match($passwordPattern, $password)) {
        $errors[] = "Le mot de passe doit contenir au moins 8 caractères, une majuscule, un chiffre et un caractère spécial.";
    }

    // Vérifier si les mots de passe correspondent
    if ($password !== $confirmPassword) {
        $errors[] = "Les mots de passe ne correspondent pas.";
    }

    // Vérifier si le login est déjà utilisé
    if ($db->validateLogin($login)) {
        $errors[] = "Ce login est déjà utilisé. Veuillez en choisir un autre.";
    }

    // Insérer les données dans la base de données si aucune erreur n'est survenue
    if (empty($errors)) {
        if ($db->register($login, $password)) {
            header("Location: login.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="icon" type="image/png" href="./assets/img/livre-or.png" />
        <link rel="stylesheet" href="./assets/css/register.css">

        <title>Livre d'Or | Inscription</title>
    </head>
    
    <body>
        <?php echo generateHeader(); ?>

        <section class="main-container">
            <div class="container">
                <h1>Inscription</h1>

                <form method="post" action="">
                    <label for="login">Login :</label>
                    <input type="text" name="login" required>

                    <label for="password">Mot de passe :</label>
                    <input type="password" name="password" required>

                    <label for="confirm_password">Confirmez le mot de passe :</label>
                    <input type="password" name="confirm_password" required>

                    <input type="submit" value="S'inscrire">

                    <?php if (!empty($errors)) : ?>
                        <div class="error">
                            <?php foreach ($errors as $error) : ?>
                                <p><?php echo $error; ?></p>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <p>Déjà inscrit ? <a href="login.php">Connectez-vous</a></p>
                </form>
            </div>
        </section>

        <?php echo generateFooter(); ?>
    </body>
</html>