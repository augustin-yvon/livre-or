<?php
require_once './classe/user.php';
require_once './classe/database.php';
require_once './html-element/footer.php';
require_once './html-element/header.php';

if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
}

$userId = $user->getId();

$db = new Database();
// Requête pour récupérer les commentaires du plus récent au plus ancien
$sql = "SELECT coment.coment, coment.date, user.login FROM coment INNER JOIN user ON coment.id_user = user.id ORDER BY coment.date DESC";   
$result = $db->pdo->prepare($sql);
$result->execute();

// Traitement du formulaire d'ajout de commentaire
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupération du commentaire depuis le formulaire
    $coment = htmlspecialchars($_POST["coment"]);

    // Insertion du commentaire dans la base de données
    $sql = "INSERT INTO coment (coment, id_user, date) VALUES (?, ?, NOW())";
    $stmt = $db->pdo->prepare($sql);
    $stmt->execute([$coment, $userId]);

    // Permet de ne pas avoir besoin de rafraîchir la page
    header("Location: golden-book.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="icon" type="image/png" href="./assets/img/livre-or.png" />
        <link rel="stylesheet" href="./assets/css/golden-book.css">

        <title>Livre d'Or | Accueil</title>
    </head>
    
    <body>
        <?php echo generateHeader(); ?>

        <section class="main-container">
            <h1><span class="gray">Livre d'</span><span class="gold">Or</span></h1>

            <div class="container">
                <?php
                    // Vérification si l'utilisateur est connecté
                    if (isset($_SESSION["user"])) {
                        $user = $_SESSION['user'];

                        if ($user->getLogState() == true) {
                            echo '
                            <div class="add-coment">
                                <h2>Ajouter un commentaire :</h2>
                                <form id="add-coment-form" method="post" action="' . $_SERVER["PHP_SELF"] . '">
                                    <textarea id="coment" name="coment" rows="4" cols="50" required></textarea>
                                    <input type="submit" value="Ajouter le commentaire">
                                </form>
                            </div>
                            ';
                        }
                    }
                ?>

                <?php
                    if ($result->rowCount() > 0) {
                        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                            $comment = $row["coment"];
                            $datetime = strtotime($row["date"]);
                            $date = date("d/m/Y", $datetime);
                            $time = date("H:i", $datetime);
                            $user = $row["login"];
                            
                            echo '<div class="coment-container">';
                            echo "<h2>Posté le $date à $time par $user :</h2>";
                            echo '<p class="coment">' . $comment . '</p>';
                            echo '</div>';
                        }
                    } else {
                        echo "Aucun commentaire trouvé.";
                    }            
                ?>
            </div>
        </section>

        <?php echo generateFooter(); ?>
    </body>
</html>
