<?php
session_start();
if(isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    // Suppression du message de la session après l'avoir récupéré
    unset($_SESSION['message']);
} else {
    $message = "Aucun message disponible.";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/all.min.css">
    <style>
        :root {
            --color-primary: #0073ff;
            --color-white: #e9e9e9;
            --color-black: #141d28;
            --color-black-1: #212b38;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: sans-serif;
            background-color: #f8f9fa;
            background-color: #fff;
        }

        .menu__bar {
            background-color: var(--color-black);
            height: 80px;
            width: 100%;
            display: flex;
            align-items: center;
            padding: 0 20px;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }

        .logo-container {
            display: flex;
            align-items: center;
        }

        .logo-image {
            width: 50px; /* Taille du logo */
            height: 50px; /* Taille du logo */
            border-radius: 50%; /* Rendre le cadre circulaire */
            object-fit: cover;
            margin-right: 10px; /* Espace entre l'image et le texte */
            background-color: #fff;
        }

        .logo {
            color: var(--color-white);
            font-size: 24px; /* Taille du texte du logo */
        }

        .menu__bar ul {
            list-style: none;
            display: flex;
            margin-left: auto;
        }

        .menu__bar li {
            padding: 10px 20px;
        }

        .menu__bar ul li a {
            color: var(--color-white);
            text-decoration: none;
            font-size: 18px;
        }

        .menu__bar ul li a:hover {
            color: var(--color-primary);
        }
    </style>
</head>
<body>
<div class="menu__bar">
    <h1 class="logo"><a href="/projet1">SVE</a></h1>
    <ul>
        <li><a class="active" href="#contact">A propos</a></li>
    </ul>
</div>
<div style="width:50%;background-color:#adf0d1;margin-left:24%;margin-top:100px;border:1px solid black;">
    <br><br>
    <div class="container">
        <h2 class="text-center">Message</h2>
        <div class="message-info">
            <p><?php echo htmlspecialchars($message); ?></p>
        </div>
        <a href="inscription.php" class="btn btn-primary">Retour</a>
    </div>
</div>
<footer>
    <p>Tout droit est limites &copy; 2024</p>
</footer>
</body>
</html>
