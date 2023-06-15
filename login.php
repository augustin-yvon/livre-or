<?php
require_once './classe/user.php';
require_once './classe/database.php';
require_once './html-element/footer.php';
require_once './html-element/header.php';

$db = new Database();

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $login = htmlspecialchars($_POST["login"]);
    $password = htmlspecialchars($_POST["password"]);

    // Vérifier les informations de connexion dans la base de données
    $checkInfoQuery = "SELECT id FROM user WHERE login = ? AND password = ?";
    $stmt = $db->pdo->prepare($checkInfoQuery);
    $stmt->bindParam(1, $login);
    $stmt->bindParam(2, $password);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // Créer l'objet utilisateur
        $user = new User($login, $password);

        $id = $db->getId($login);

        // Ajouter l'id à l'objet utilisateur
        if ($id !== false) {
            $user->setId($id);
        }

        // Mettre l'utilisateur à l'état connecté
        $user->login();
        
        $_SESSION["user"] = $user;

        if ($user->getLogin() == 'admin') {
            header("Location: admin.php");
            exit();
        }else {
            header("Location: profile.php");
            exit();
        }
    } else {
        $error = "Login ou mot de passe incorrect.";
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
        <link rel="stylesheet" href="./assets/css/login.css">

        <title>Livre d'Or | Connexion</title>
    </head>

    <body>
        <?php echo generateHeader(); ?>
        
        <section class="main-container">
            <div class="container">
                <h1>Connexion</h1>

                <form method="post" action="">
                    <label for="login">Login :</label>
                    <input type="text" name="login" required>

                    <label for="password">Mot de passe :</label>
                    <input type="password" name="password" required>

                    <input type="submit" value="Se connecter">

                    <?php if (isset($error)) : ?>
                        <p class="error"><?php echo $error; ?></p>
                    <?php endif; ?>

                    <p>Pas encore inscrit ? <a href="register.php">Inscrivez-vous</a></p>
                </form> 
            </div>
        </section> 

        <?php echo generateFooter(); ?>
    </body>
</html>