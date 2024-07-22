<?php
    session_start();
    include("db_conn.php");

    if (!isset($_SESSION['reset_email'])) {
        header("Location: Email_password.php");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        if (!empty($new_password) && !empty($confirm_password)) {
            if ($new_password == $confirm_password) {
                $email = $_SESSION['reset_email'];
                $query = "UPDATE admin SET Password = '$new_password' WHERE Email = '$email'";
                if (mysqli_query($conn, $query)) {
                    echo "<script>alert('Mot de passe mis à jour avec succès'); window.location.href='connection.php';</script>";
                } else {
                    echo "<script>alert('Erreur de mise à jour du mot de passe')</script>";
                }
            } else {
                echo "<script>alert('Les mots de passe ne correspondent pas')</script>";
            }
        } else {
            echo "<script>alert('Veuillez remplir tous les champs')</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveau mot de passe</title>
    <link rel="stylesheet" href="style.css">
    <style> body {
    background: url(background.png) center/cover no-repeat;
    height: 100vh;
    font-family: Arial, sans-serif;
    margin: 0;
    display: flex;
    justify-content: center;
    align-items: center;
}

.connection {
    width: 300px;
    padding: 20px;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h1 {
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

form input {
    width: calc(100% - 20px);
    margin-top: 5px;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 6px;
    outline: none;
    transition: border-color 0.3s ease;
}

form input:focus {
    border-color: #007bff;
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

p {
    text-align: center;
    margin-top: 20px;
    font-size: 15px;
}
:root {
            --color-primary: #0073ff;
            --color-white: #e9e9e9;
            --color-black: #141d28;
            --color-black-1: #212b38;
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
        <h1 class="logo">VoteElectronique</h1>
        </div>
        <ul>
            <li><a class="active" href="#contact">À propos</a></li>
        </ul>
    </div>
    <div class="connection">
        <h1>Nouveau mot de passe</h1>
        <form method="POST">
            <label>Nouveau mot de passe</label>
            <input type="password" name="new_password" required>
            <label>Confirmer le mot de passe</label>
            <input type="password" name="confirm_password" required>
            <input type="submit" value="Réinitialiser">
        </form>
    </div>
    <footer>
        <p> Tout droit est limites &copy; 2024s</p>
    </footer>
</body>
</html>
