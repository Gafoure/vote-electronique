<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
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

        #caroussel {
            display: flex;
            justify-content: center;
            align-items: center;
            padding-top: 100px; /* Pour éviter le chevauchement avec la barre de menu */
        }

        .images {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 20px;
        }

        .images img {
            max-width: 560px; /* Ajustez cette valeur pour réduire la taille de l'image */
            height: auto;;
            margin-left: 100px; /* Espacement entre l'image et le texte */
            border-radius: 10px; /* Optionnel : pour arrondir les coins de l'image */
            background-color: #0073ff;
        }

        .welcome-text {
            /*background-color: #ffffff;*/
            padding: 20px;
            max-width: 700px; 
            text-align: center;

        }

        .welcome-text h1 {
            color: #333333;
            margin-bottom: 20px;
            font-size: 36px; /* Taille de la police */
            text-decoration-line: underline;
            text-decoration-style: solid;
            animation-duration: 3s;
            animation-name: slidein;
            animation-iteration-count: infinite;
        }

        .welcome-text p {
            color: #666666;
            font-size: 20px;
            animation-duration: 3s;
            animation-name: slidein;
            animation-iteration-count: infinite;
        }

        footer {
            background-color: var(--color-black);
            color: var(--color-white);
            padding: 10px;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        @keyframes slidein {
            from {
                margin-left: 60%;
                width: 220%; 
            }
            to {
                margin-left: 0%;
                width: 100%;
            }
        }
    </style>
    <title>Vote Électronique</title>
</head>
<body>
    <div class="menu__bar">
        <div class="logo-container">
            <img src="./image/drapeau.png" alt="Logo" class="logo-image">
            <h1 class="logo">VoteElectronique</h1>
        </div>
        <ul>
            <li><a class="active" href="connection.php">Admin</a></li>
            <li><a class="active" href="inscription.php">Voter</a></li>
            <li><a class="active" href="Results.php">Resultats</a></li>
            <li><a class="active" href="#contact">À propos</a></li>
        </ul>
    </div>
    <div id="caroussel">
        <div class="images">
            <div class="welcome-text">
                <h1>Bienvenue</h1>
                <strong>
                <p>sur notre système de vote électronique au Mali.</p>
                </strong>
            </div>
            <img src="./image/logo site2.png" alt="Logo du site">
        </div>
    </div>
    <footer>
        <p>Tout droit est limites &copy; 2024</p>
    </footer>
</body>
</html>
