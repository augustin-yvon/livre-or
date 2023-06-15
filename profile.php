<?php
require_once './classe/user.php';
require_once './classe/database.php';
require_once './html-element/footer.php';
require_once './html-element/header.php';

$db = new Database();

if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    $userID = $user->getId();
}else {
    header("Location: login.php");
    exit();
}

// Traitement de la requête de modification du profil
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données envoyées par le formulaire
    $newLogin = htmlspecialchars($_POST['login']);
    $newPassword = htmlspecialchars($_POST['password']);

    // Vérifier si le mot de passe respecte les critères
    $passwordPattern = "/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/";
    if (!preg_match($passwordPattern, $newPassword)) {
        $error = "Le mot de passe doit contenir au moins 8 caractères, une majuscule, un chiffre et un caractère spécial.";
    }

    // Mettre à jour les données dans la base de données
    $updateQuery = "UPDATE user SET login = ?, password = ? WHERE id = ?";

    $stmt = $db->pdo->prepare($updateQuery);

    $stmt->bindParam(1, $newLogin);
    $stmt->bindParam(2, $newPassword);
    $stmt->bindParam(3, $userID);

    $stmt->execute();

    exit;
}

// Récupérer les informations de l'utilisateur actuel à partir de la base de données
$getLoginByIdQuery = "SELECT login, password FROM user WHERE id = ?";
$stmt = $db->pdo->prepare($getLoginByIdQuery);
$stmt->bindParam(1, $userID);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result) {
    $currentLogin = $result['login'];
    $currentPassword = $result['password'];
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="icon" type="image/png" href="./assets/img/livre-or.png" />
        <link rel="stylesheet" href="./assets/css/profile.css">

        <title>Livre d'Or | Profil</title>
    </head>

    <body>
        <?php echo generateHeader(); ?>

        <section class="main-container">
            <div class="container">
                <h1>Modifier vos informations</h1>

                <form id="profile-form">
                    <label for="login">Login :</label>
                    <input type="text" id="login" name="login" value="<?php echo $currentLogin; ?>" required><br>

                    <label for="password">Mot de passe :</label>
                    <input type="password" id="password" name="password" value="<?php echo $currentPassword; ?>" required><br>
                    <button type="button" id="toggle-password">Afficher</button><br>

                    <input type="submit" value="Modifier">

                    <?php if (isset($error)) : ?>
                        <p class="error"><?php echo $error; ?></p>
                    <?php endif; ?>
                </form>
            </div>
        </section>

        <?php echo generateFooter(); ?>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="./assets/js/profile.js"></script>
    </body>
</html>