<?php
session_start();

if(isset($_POST['valider'])) {
    if($_POST['valider'] === "Vote") {
        $connexion = new PDO('mysql:host=127.0.0.1;port=3306;dbname=projet_memoire','root','');
        $utilisateur = $_SESSION['utilisateur'];
        
        // Mettre à jour la colonne a_vote pour cet utilisateur
        $requete = $connexion->prepare("UPDATE utilisateur SET a_vote = 1 WHERE CIN = :CIN");
        $requete->bindParam(':CIN', $utilisateur['CIN']);
        $requete->execute();
        
        header("Location: acueil.php");
        exit();
    } elseif($_POST['valider'] === "Annule") {
        header("Location: Inscription.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informations de l'utilisateur</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/all.min.css">
    <style>
        :root {
            --color-primary: #0073ff;
            --color-white: #e9e9e9;
            --color-black: #141d28;
            --color-black-1: #212b38;
        }
        body {
            background-color: #f8f9fa; 
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .body_html {
            display: flex;
            flex-direction: column;
        }

        .container {
             width: 500px;
             background-color: #fff; /* Couleur de fond du conteneur */
             border-radius: 10px; /* Coins arrondis du conteneur */
             padding: 30px; /* Espace intérieur */
             box-shadow: 0 0 20px rgba(0, 0, 0, 0.1); /* Ombre douce */
             margin: 0 auto; /* Centrer horizontalement */
        }

        .form-control {
            border-radius: 20px; /* Coins arrondis des champs de formulaire */
            border: 1px solid #ced4da; /* Couleur de la bordure */
            padding: 10px 15px; /* Espace à l'intérieur du champ */
            margin-bottom: 20px; /* Espace entre les champs */
            width: 100%; /* Largeur pleine */
        }

        .btn-success {
            border-radius: 30px; 
            margin-top: 9px; 
            padding: 12px 20px; 
            background-color: #adf0d1; 
            border: none; 
            cursor: pointer; 
            transition: background-color 0.3s ease; 
            width: 80%; 
            display: block; 
        }

        .btn-success:hover {
            background-color: #0056b3; 
            cursor: pointer;
        }

        .heading_text {
            text-align: center;
        }

        .user-info {
            background-color: #f8f9fa; /* Couleur de fond */
            border-radius: 20px; /* Coins arrondis */
            padding: 20px; /* Espace intérieur */
            margin-top: 20px; /* Espace au-dessus */
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1); /* Ombre douce */
        }

        .user-info h3 {
            margin-top: 0; /* Supprimer la marge supérieure */
            margin-bottom: 20px; /* Espace en dessous */
        }

        .user-info ul {
            padding: 0;
            margin: 0;
        }

        .user-info li {
            list-style-type: none; 
            margin-bottom: 10px; 
        }

        .user-info li strong {
            display: inline-block;
            width: 180px;
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

        .form_cin {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            padding-inline: 160px;
        }

        .form_cin button {
            padding: 10px 20px;
            text-align: center;
            border-radius: 8px;
            border: none;
            color: #f8f9fa;
            transition: background-color 0.3s ease;
            cursor: pointer;
        }

        .btn-voter {
            background-color: #0056b3; /* Vert pour voter */
        }

        .btn-voter:hover {
            background-color: #218838; /* Vert plus foncé au survol */
        }

        .btn-annuler {
            background-color: #218838; /* Rouge pour annuler */
        }

        .btn-annuler:hover {
            background-color: #c82333; /* Rouge plus foncé au survol */
        }

        footer {
            background-color: #000;
            color: #fff;
            padding: 10px;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<div class="menu__bar">
    <div class="logo-container">
        <img src="./image/drapeau.png" alt="Logo" class="logo-image">
        <h1 class="logo">VoteElectronique</h1>
    </div>
    <ul>
        <li><a class="active" href="#contact">À propos</a></li>
    </ul>
</div>
<body class="body_html">
    <div>
        <div class="container">
            <h2 class="heading_text">Vos informations</h2>
            <div class="user-info">
                <?php
                if(isset($_SESSION['utilisateur'])) {
                    $utilisateur = $_SESSION['utilisateur'];
                    echo "<ul>";
                    echo "<li><strong>CIN :</strong> ".$utilisateur['CIN']."</li>";
                    echo "<li><strong>Nom :</strong> ".$utilisateur['Nom']."</li>";
                    echo "<li><strong>Prénom :</strong> ".$utilisateur['Prenom']."</li>";
                    echo "<li><strong>DateNaissance :</strong> ".date('d/m/Y', strtotime($utilisateur['DateNaissance']))."</li>";
                    echo "<li><strong>Genre :</strong> ".$utilisateur['Genre']."</li>";
                    echo "<li><strong>Commune :</strong> ".$utilisateur['Commune']."</li>";
                    echo "</ul>";
                } else {
                    echo "<p>Aucune information d'utilisateur disponible.</p>";
                }
                ?>
            </div>
            <!-- Boutons -->
            <form method="post" action="" class="form_cin">
                <button type="submit" name="valider" value="Vote" class="btn-voter">Voter</button>
                <button type="submit" name="valider" value="Annule" class="btn-annuler">Annuler</button>
            </form>
        </div>
    </div>

    <footer>
        <p>Tout droit est limites &copy; 2024</p>
    </footer>
</body>
</html>