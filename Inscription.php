
<?php
if(isset($_POST['valider'])) {
    if(!empty($_POST['CIN'])) {
        $CIN = htmlspecialchars($_POST['CIN']);
        $connexion = new PDO('mysql:host=127.0.0.1;port=3306;dbname=projet_memoire','root','');
        $requete = $connexion->prepare("SELECT * FROM utilisateur WHERE CIN = :CIN");
        $requete->bindParam(':CIN', $CIN);
        $requete->execute();
        $utilisateur = $requete->fetch(PDO::FETCH_ASSOC);
        
        if($utilisateur) {
            session_start();
            $_SESSION['utilisateur'] = $utilisateur;
            header("Location: traitement_Inscription.php");
            exit(); 
        } else {
            echo "<p class=\"user_not_found\">Aucun utilisateur trouvé avec ce CIN: $CIN.</p>";
        }
    } else {
        echo "<p>Le champ CIN est vide.</p>";  
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" type="text/css" href="../css.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css"> 
    <title>Project Management System</title>
    <style>
        :root {
            --color-primary: #0073ff;
            --color-white: #e9e9e9;
            --color-black: #141d28;
            --color-black-1: #212b38;
        }
        .user_not_found {
            text-align: center;
            position: absolute;
            top: 80px;
            left: 50%;
            transform: translateX(-50%);
            color: red;
            z-index: 999;
        }

    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        background: #f6f5f7;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        font-family: "Montserrat", sans-serif;
    }

    .container {
        position: relative;
        overflow: hidden;
        min-height: 400px;
        width: 600px;
        max-width: 100%;
        background-color: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 24px rgba(0, 32, 63, 0.45), 0 8px 8px rgba(0, 32, 63, 0.45);
        margin-top: 140px; /* Ajout de la marge supérieure */
    }

    .form-container {
        position: absolute;
        top: 0;
        height: 100%;
    }

    .sign-up-container {
        left: 0;
        width: 50%;
        opacity: 0;
        z-index: 1;
    }

    .container.panel-active.sign-up-container {
        transform: translateX(-100%);
        opacity: 1;
        z-index: 5;
        animation: show .6s;
    }

    .container.panel-active.login-container {
        transform: translateX(-100%);
    }

    .login-container {
        left: 0;
        width: 50%;
        z-index: 2;
    }

    form {
        background-color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        padding: 0 50px;
        height: 100%;
        text-align: center;
    }

    input {
            background-color: #fff;
            border-radius: 20px;
            padding: 12px 15px;
            margin: 8px 0;
            width: 100%;
        }
        button.ghost {
            background-color: transparent;
        }
        button {
            background-color:  #adf0d1;
            color: #00203f;
            border: 1px solid  #adf0d1;
            font-size: 16px;
            font-weight: bold;
            padding: 16px 32px;
            margin-top: 24px;
            letter-spacing: 1px;
            border-radius: 30px;
            border-color: rgba(0, 32, 63, 0.45);
            transition: .2s ease-in;
        }

    button:hover {
        background-color: var(--color-secondary);
        color: var(--color-primary);
    }

    button:active {
        transform: scale(.95);
    }

    .social-container {
        margin: 24px 0;
    }

    .social-container a {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        margin: 0 4px;
        height: 40px;
        width: 40px;
        border-radius: 50%;
        background-color: var(--color-primary);
        border: 1px solid rgba(0, 32, 63, 0.45);
    }

    h1 {
        margin: 0;
        font-size: 24px;
    }

    .overlay-container {
        position: absolute;
        top: 0;
        left: 50%;
        width: 50%;
        height: 100%;
        overflow: hidden;
        z-index: 100;
    }

    .overlay {
        background: linear-gradient(to right, var(--color-primary), #e7f0fd);
        color: var(--color-secondary);
        position: relative;
        left: -100%;
        height: 100%;
        width: 200%;
        transform: translateX(0);
    }

    .overlay-panel {
        position: absolute;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        padding: 0 40px;
        text-align: center;
        top: 0;
        height: 100%;
        width: 50%;
        transform: translateX(0);
    }

    .overlay-left {
        transform: translateX(-20%);
    }

    .overlay-right {
        right: 0;
        transform: translateX(0);
    }

    p {
        font-size: 16px; /* Réduction de la taille de la police */
        font-weight: 500;
        line-height: 24px; /* Réduction de la hauteur de ligne */
        letter-spacing: 1px;
        margin: 10px 0; /* Ajustement des marges */
        color: #555;
    }

    .menu__bar {
        background-color: var(--color-black);
        height: 60px; /* Réduction de la hauteur de la barre de menu */
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1000;
        padding: 0 20px;
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
        margin-right: 20px;
    }

    .menu__bar li {
        padding: 10px 20px;
    }

    .menu__bar ul li a {
        color: #fff;
        text-decoration: none;
        font-size: 18px; /* Réduction de la taille du texte du menu */
    }

    .menu__bar ul li a:hover {
        color: #ff7200;
    }

    footer {
            background-color: var(--color-black);
            color: var(--color-white);
            padding: 3px;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
</style>
</head>
<body>
    <div class="menu__bar">
        <div class="logo-container">
            <img src="./image/drapeau.png" alt="Logo" class="logo-image">
        </div>
        <h1 class="logo"><a href="/projet1">VoteElectronique</a></h1>
        <ul>
            <li><a class="active" href="index.php">Home</a></li>
            <li><a class="active" href="connection.php">Admin</a></li>
            <li><a class="active" href="results.php">Voir les Resultats</a></li>
            <li><a class="active" href="#contact">A propos</a></li>
        </ul>
    </div>
<div class="container" id="container">
    <div class="form-container sign-up-container">
        <form action="" method="POST"> 
            <h1>Connectez vous</h1>
            <span>Utiliser votre CIN</span>
            <input type="text" name="CIN" placeholder="CIN">
            <button type="submit">Submit</button>
        </form>
    </div>
    <div class="form-container login-container">
        <form action="" method="POST"> 
            <h1>Connectez vous</h1>
            <input type="text" name="CIN" placeholder="CIN">
            <input id="submitBtn" type="submit" name="valider" value="Submit" />
        </form>
    </div>
    <div class="overlay-container">
        <div class="overlay">
            <div class="overlay-panel overlay-right">
                <h1>Bienvenue sur le premier système de vote électronique</h1>
                <p>Connectez-vous avec votre numéro CIN pour pouvoir voter</p>
            </div>
        </div>
    </div>
</div>
    <script src="script.js" charset="utf-8"></script>
    <footer>
        <p>Tout droit est limites &copy; 2024</p>
    </footer>
</body>
</html>
