<?php
// Connexion à la base de données
include 'db_conn.php';

// Vérification de la connexion
if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

// Vérification si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $StartDate = $_POST['StartDate'];
    $EndDate = $_POST['EndDate'];
    $NB_Tour = isset($_POST['NB_Tour']) ? $_POST['NB_Tour'] : NULL;
    $TypeElection = $_POST['TypeElection'];
    $Commune = isset($_POST['Commune']) ? $_POST['Commune'] : '';
    $ReferendumQuestion = isset($_POST['ReferendumQuestion']) ? $_POST['ReferendumQuestion'] : NULL;

    // Si l'élection est de type "Municipale", utiliser le type de commune sélectionné
    if ($TypeElection == 'Municipale' && !empty($Commune)) {
        $TypeElection = $Commune;
    }

    // Préparation de la requête SQL avec des paramètres
    $stmt = $conn->prepare("INSERT INTO election (StartDate, EndDate, NB_Tour, TypeElection, ReferendumQuestion) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiss", $StartDate, $EndDate, $NB_Tour, $TypeElection, $ReferendumQuestion);

    // Exécution de la requête
    if ($stmt->execute()) {
        $message = "Élection créée avec succès.";
        header('Location: Liste_election.php');
        exit();
    } else {
        $message = "Erreur : " . $stmt->error;
    }

    // Fermeture de la requête
    $stmt->close();
}
// Fermeture de la connexion
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion Administrateur</title>
    <link rel="stylesheet" href="style.css" />
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
        .container {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: flex-start;
            width: 90%;
            max-width: 600px;
            margin-top: 100px;
        }
        .connection {
            width: 500px;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-right: 10px;
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
        form input, form select {
            width: calc(100% - 20px);
            margin-top: 5px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            outline: none;
            transition: border-color 0.3s ease;
        }
        form input:focus, form select:focus {
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

        .test {
            display: flex;
        }
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
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 10px;
            background-color: #fff;
        }

        .logo {
            color: var(--color-white);
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
            padding-top: 100px;
        }

        .images {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 20px;
        }

        .images img {
            max-width: 560px;
            height: auto;
            margin-left: 100px;
            border-radius: 10px;
            background-color: #0073ff;
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
    </style>
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
            <li><a class="active" href="results.php">Voir les Resultats</a></li>
            <li><a class="active" href="#contact">À propos</a></li>
        </ul>
    </div>

    <div class="container">
        <div class="connection">
            <h1>Création d'élection</h1>
            <form method="POST">
                <label>Type d'élection</label>
                <select name="TypeElection" id="TypeElection" onchange="showElectionFields()" required>
                    <option value="">Sélectionnez le type d'élection</option>
                    <option value="Présidentielle">Présidentielle</option>
                    <option value="Legislative">Legislative</option>
                    <option value="Municipale">Municipale</option>
                    <option value="Referendum">Referendum</option>
                </select>
                
                <div id="communeSelection" style="display:none;">
                    <label>Choisissez la commune</label>
                    <select name="Commune">
                        <option value="Commune I">Commune I</option>
                        <option value="Commune II">Commune II</option>
                        <option value="Commune III">Commune III</option>
                        <option value="Commune IV">Commune IV</option>
                        <option value="Commune V">Commune V</option>
                    </select>
                </div>

                <div id="referendumQuestion" style="display:none;">
                    <label>Question pour le référendum</label>
                    <input type="text" name="ReferendumQuestion">
                </div>

                <div id="nbTours">
                    <label>Nombre de tours</label>
                    <input type="text" name="NB_Tour" required>
                </div>
                
                <label>Date de début</label>
                <input type="date" name="StartDate" required>
                <label>Date de fin</label>
                <input type="date" name="EndDate" required>
                <input type="submit" name="Submit" value="Créer l'élection">   
            </form>
            <?php if(isset($message)) { ?>
            <div class="message"><?php echo $message; ?></div>
            <?php } ?>
        </div>
    </div>
    <footer>
        <p>Tout droit est limites &copy; 2024</p>
    </footer>

    <script>
    function showElectionFields() {
        var typeElection = document.getElementById("TypeElection").value;
        var communeSelection = document.getElementById("communeSelection");
        var referendumQuestion = document.getElementById("referendumQuestion");
        var nbTours = document.getElementById("nbTours");

        if (typeElection === "Municipale") {
            communeSelection.style.display = "block";
        } else {
            communeSelection.style.display = "none";
        }

        if (typeElection === "Referendum") {
            referendumQuestion.style.display = "block";
            nbTours.style.display = "none";
        } else {
            referendumQuestion.style.display = "none";
            nbTours.style.display = "block";
        }
    }
    </script>
</body>
</html>
