<?php
    session_start();
    include("db_conn.php");

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_POST['email'];

        if (!empty($email) && !is_numeric($email)) {
            $query = "SELECT * FROM admin WHERE Email = '$email'";
            $result = mysqli_query($conn, $query);

            if ($result) {
                if (mysqli_num_rows($result) > 0) {
                    $_SESSION['reset_email'] = $email;
                    header("Location: reset_password.php");
                    exit;
                } else {
                    echo "<script>alert('Utilisateur non trouvé')</script>";
                }
            } else {
                echo "<script>alert('Erreur de requête MySQL')</script>";
            }
        } else {
            echo "<script>alert('Veuillez entrer une adresse e-mail valide')</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialiser le mot de passe</title>
    <link rel="stylesheet" href="style.css">
    <style> 
        .body {
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
        <h1>Réinitialiser le mot de passe</h1>
        <form method="POST">
            <label>Email</label>
            <input type="text" name="email" required>
            <input type="submit" value="Envoyer">
        </form>
    </div>
    <footer> 
        <p> Tout droit est limites &copy; 2024</p>
    </footer>
</body>
</html>
