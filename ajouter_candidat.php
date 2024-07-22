<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Premier Site Web avec Chahrazed | Accueil</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
        }
        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }
        nav ul li {
            display: inline;
            margin-right: 20px;
        }
        nav ul li a {
            color: #fff; /* Correction de la couleur des liens du menu */
            text-decoration: none;
        }
        nav ul li a:hover {
            color: #f00; /* Couleur au survol */
        }
        main {
            padding: 20px;
        }
        footer {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        section {
            margin-bottom: 20px;
        }
        section#banner {
            background-image: url('https://c8.alamy.com/compfr/2g41fdj/concept-de-vote-et-d-election-isometrique-en-ligne-vote-electronique-systeme-d-election-internet-smartphone-avec-vote-a-l-ecran-2g41fdj.jpg');
            background-size: cover;
            height: 300px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
            text-align: center;
        }
        section#features div {
            text-align: center;
            margin: 0 auto;
            max-width: 300px;
        }
        section#features img {
            width: 100px;
            height: 100px;
        }
        button {
            background-color: #0073ff; /* Couleur du bouton */
            color: #fff; /* Couleur du texte */
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease; /* Transition fluide */
        }
        button:hover {
            background-color: #0056b3; /* Couleur au survol */
        }
        button a{
          color: #fff;
        }
    </style>
</head>
<body>
    <header>
        <h1> Systeme de Vote Electronique</h1>
        <nav>
            <ul>
                <li><a class="active" href="connection.php">Admin</a></li>
                <li><a class="active" href="inscription.php">Voter</a></li>
                <li><a class="active" href="#contact">À propos</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section id="banner">
            <h1>Premier Systeme de vote Electronique</h1>
        </section>
        <section id="features">
            <div>
                <!-- <img src="https://www.editions-legislatives.fr/media/news-npa/resized/650/430679-vote.jpeg" alt="HTML5"> -->
                <h2>Bienvenue</h2>
                <p>Sur notre Premier Systeme L'objectif principal de ce Systeme est de moderniser et de simplifier le processus de vote</p>
                <button type="submit"><a href="results.php">Voir Resultats</a></button>
            </div>
        </section>
    </main>
    <footer>
        <p>Bas de page - Les droit sont limite &copy; 2024</p>
    </footer>
</body>
</html>
