<?php
require_once './classe/user.php';
require_once './classe/database.php';
require_once './html-element/footer.php';
require_once './html-element/header.php';

$db = new Database();
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="icon" type="image/png" href="./assets/img/livre-or.png" />
        <link rel="stylesheet" href="./assets/css/admin.css">

        <title>Livre d'Or | Profil</title>
    </head>
    
    <body>
        <?php echo generateHeader(); ?>

        <section class="main-container">
            <?php
                // Préparation de la requête
                $query = "SELECT * FROM user";
                $stmt = $db->pdo->prepare($query);

                // Exécution de la requête
                $stmt->execute();

                // Récupération des résultats
                $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Affichage des utilisateurs dans un tableau HTML
                echo '<table>';
                    echo '<tr>';
                        echo '<th>ID</th>';
                        echo '<th>Login</th>';
                        echo '<th>Mot de passe</th>';
                    echo '</tr>';

                foreach ($users as $user) {
                    echo '<tr>';
                        echo '<td>' . $user['id'] . '</td>';
                        echo '<td>' . $user['login'] . '</td>';
                        echo '<td>' . $user['password'] . '</td>';
                    echo '</tr>';
                }

                echo '</table>';
            ?>
        </section>

        <?php echo generateFooter(); ?>
    </body>
</html>