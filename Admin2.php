
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="../css.css">
	<meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device, initial-scale=1.0">
	<!-- Bootstrap -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
	rel="stylesheet" 
	integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<!-- Font Awesone -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/
	6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" 
	crossorigin="anonymous" referrerpolicy="no-referrer" />
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

        .container {
            width: 500px;
            margin: 100px auto 20px; /* Pour dégager de l'espace pour le menu en haut */
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
        }

        .election-list a:hover {
            background-color: #0056b3;
        }

        footer {
            background-color: #141d28;
            color: #fff;
            padding: 10px;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
    <title>Systeme de vote electronique</title>
</head>
<body>
     <!-- Bootstrap -->
	
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
	integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" 
	crossorigin="anonymous"></script>
	
    <!-- <nav class="navbar navbar-light justify-content-center fs-1 mb-3" 
	style="background-color: #00ff5573;">
	 Droit reserve au Administrateur
	</nav> -->
	<div class="menu__bar">
        <div class="logo-container">
            <img src="./image/drapeau.png" alt="Logo" class="logo-image">
        </div>
        <h1 class="logo">VoteElectronique</h1>
        <ul>
            <li><a class="active" href="inscription.php">Voter</a></li>
            <li><a class="active" href="results.php">Voir les Resultats</a></li>
            <li><a class="active" href="#contact">À propos</a></li>
        </ul>
    </div>
	<div class="container">
		<div class="text-center mb-4">
			<h1>Administrateur</h1>
		</div>
		<table width="100%" cellspacing="02" cellpadding="05"> 
		    <tr>
				<td align="center"><a href="Cree_une_election.php"><font size="5">cree une election</font></a></td>
            </tr>
            <tr>
				<td align="center"><a href="Tour.php"><font size="5">Creation des tours</font></a></td>
            </tr>
			<tr>
				<td align="center"><a href="liste_election.php"><font size="5">liste des elections</font></a></td>
            </tr>
			<tr>
				<td align="center"><a href="liste_Electeur.php"><font size="5">liste des electeurs</font></a></td>
            </tr>
            <tr>
				<td align="center"><a href="liste_candidat.php"><font size="5">liste des candidats</font></a></td>
            </tr>
            <tr>
				<td align="center"><a href="Liste_Admin.php"><font size="5">Liste des admins</font></a></td>
            </tr>
            <tr>
				<td align="center"><a href="Parti.php"><font size="5">Liste des Parties</font></a></td>
            </tr>
            <tr>
                <td align="center"><a href="admin_proclaim_results.php"><font size="5">Proclamer Resultats</font></a></td>
            </tr>
		</table>
	</div>
    <footer>
        <p>Tout droit est limites &copy; 2024</p>
    </footer>
</body>
</html>
