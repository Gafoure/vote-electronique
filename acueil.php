<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../css.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url(../background.png);
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 500px;
            margin: 120px auto 20px; /* Pour dégager de l'espace pour le menu en haut */
            background-color: #fff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.1);
        }
        .election-list {
            list-style: none;
            padding: 0;
        }
        .election-list li {
            margin-bottom: 40px;
        }
        .election-list a {
            display: block;
            padding: 25px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 15px;
            transition: background-color 0.3s ease;
            text-align: center;
        }
        .election-list a:hover {
            background-color: #0056b3;
        }
        footer {
            background-color: #141d28;
            color: #fff;
            padding: 0px;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        .menu__bar {
            background-color: #000;
            height: 80px;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }

        .logo-container {
            display: flex;
            align-items: center;
            margin-left: 20px;
        }

        .logo {
            color: #fff;
            font-size: 25px;
            margin-left: 20px;
        }

        .logo-image {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin-right: 20px;
            margin-right: 2px; /* Espace entre l'image et le texte */
            background-color: #fff;
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
            font-size: 20px;
        }

        .menu__bar ul li a:hover {
            color: #ff7200;
        }
    </style>
    <title>Systeme de vote electronique</title>
</head>
<body>
<div class="menu__bar">
    <div class="logo-container">
        <img src="./image/drapeau.png" alt="Logo" class="logo-image">
        <h1 class="logo">VoteElectronique</h1>
    </div>
    <ul>
        <li><a class="active" href="results.php">Voir les Resultats</a></li>
        <li><a class="active" href="#contact">À propos</a></li>
    </ul>
</div>
<div class="container">
    <ul class="election-list">
        <h2>Choisissez le type d'élection</h2>
        <li><a href="Presidentielle.php">Election Presidentielle</a></li>
        <li><a href="Legislative.php">Election Legislative</a></li>
        <li><a href="Minicipale.php" onclick="showCommuneOptions()">Election Municipale</a></li>
        <li><a href="Referendum.php">Election Referendum</a></li>
    </ul>
</div>
<footer>
    <p>Toutes Les droit sont limite &copy; 2024</p>
</footer>
</body>
</html>
