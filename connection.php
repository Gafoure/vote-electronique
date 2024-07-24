<?php
    session_start();

    include("db_conn.php");

    if($_SERVER['REQUEST_METHOD'] == "POST") {
        $Email = $_POST['Email'];
        $Password = $_POST['pass'];

        if(!empty($Email) && !empty($Password) && !is_numeric($Email)) { // Correction de la variable $Password

            $query = "SELECT * FROM admin WHERE Email = '$Email'"; //AND is_admin=1 LIMIT 1";
            $result = mysqli_query($conn, $query);

            if($result) {
                if(mysqli_num_rows($result) > 0) {
                    $user_data = mysqli_fetch_assoc($result);
                    if($user_data['Password'] == $Password) {
                        header("location: Admin2.php");
                        exit; // Ajout de cette ligne pour arrêter l'exécution du script après la redirection
                    } else {
                        echo "<script>alert('Mot de passe incorrect')</script>";
                    }
                } else {
                    echo "<script>alert('Utilisateur non trouvé')</script>";
                }
            } else {
                echo "<script>alert('Erreur de requête MySQL')</script>";
            }
        } else {
            echo "<script>alert('Veuillez entrer des informations valides')</script>";
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion Administrateur</title>
    <link rel="stylesheet" href="style.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
       body {
            background: url(background.png) center/cover no-repeat;
            height: 100vh;
            font-family: Arial, sans-serif;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .connection {
            width: 300px; /* Réduction de la largeur du formulaire */
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1, h4 {
            text-align: center;
            margin: 0;
            padding: 10px 0;
        }

        form {
            width: 100%;
        }

        form label {
            display: block;
            margin-top: 20px;
            font-size: 18px;
        }

        .input-container {
            display: flex;
            align-items: center;
            border: 1px solid #ccc;
            border-radius: 6px;
            padding: 3px;
            margin-top: 3px;
            margin-bottom: 15px;
        }

        .input-container i {
            margin-right: 20px;
            color: #007bff;
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translate(-50%);
            font-size: 20px;
        }

        .input-container input {
            border: none;
            outline: none;
            width: 100%;
            font-size: 16px;
            padding: 10px;
        }

        input[type="submit"] {
            width: 100%;
            margin-top: 20px;
            background-color: #007bff;
            color: #fff;
            font-size: 18px;
            border: none;
            border-radius: 6px;
            padding: 12px 0;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: rgb(13, 211, 247);
        }

        .forgot-password {
            text-align: center;
            margin-top: 20px;
        }

        .forgot-password a {
            color: #007bff;
            text-decoration: none;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }

        p {
            text-align: center;
            margin-top: 20px;
            font-size: 15px;
        }

        .menu__bar {
            background-color: #141d28;
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
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 10px;
            background-color: #fff;
        }

        .logo {
            color: #e9e9e9;
            font-size: 24px;
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
            color: #e9e9e9;
            text-decoration: none;
            font-size: 18px;
        }

        .menu__bar ul li a:hover {
            color: #007bff;
        }

        footer {
            background-color: #141d28;
            color: #e9e9e9;
            padding: 10px;
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
        <h1 class="logo">VoteElectronique</h1>
    </div>
    <ul>
        <li><a class="active" href="index.php">Home</a></li>
        <li><a class="active" href="inscription.php">Voter</a></li>
        <li><a class="active" href="results.php">Voir les Resultats</a></li>
        <li><a class="active" href="#contact">À propos</a></li>
    </ul>
</div>

<div class="connection">
    <h1>Connexion</h1>
    <form method="POST">
        <label>Email</label>
        <div class="input-container">
            <input type="text" name="Email" required>
        </div>
        <label>Mot de passe</label>
        <div class="input-container">
            <input type="password" name="pass" required>
        </div>
        <input type="submit" name="Submit" value="Submit">
    </form>
    <div class="forgot-password">
        <a href="Email_password.php">Mot de passe oublié ?</a>
    </div>
</div>

<footer>
    <p>Tout droit est limites &copy; 2024</p>
</footer>
</body>
</html>
