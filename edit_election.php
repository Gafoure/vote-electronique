<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projet_memoire";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

// Récupération des données de l'élection à modifier
if (isset($_GET['electionID']) && is_numeric($_GET['electionID'])) {
    $electionID = intval($_GET['electionID']); 
    $sql = "SELECT * FROM election WHERE electionID=$electionID"; 
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        die("Aucune élection trouvée avec l'ID $electionID");
    }
} else {
    die("ID de l'élection non spécifié");
}
// Vérification si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Update'])) {
    $NB_Tour = $_POST['NB_Tour'];
    $StartDate = $_POST['StartDate'];
    $EndDate = $_POST['EndDate'];
    $TypeElection = $_POST['TypeElection'];
    $electionID = intval($_POST['electionID']);

    // Préparation de la requête SQL de mise à jour
    $sql = "UPDATE election SET NB_Tour='$NB_Tour', StartDate='$StartDate', EndDate='$EndDate', TypeElection='$TypeElection' WHERE electionID=$electionID";

    // Exécution de la requête
    if ($conn->query($sql) === TRUE) {
        $message = "Election mise à jour avec succès.";
        header('Location: Liste_election.php');
    } else {
        $message = "Erreur lors de la mise à jour : " . $conn->error;
    }
}
// Fermeture de la connexion
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification d'une élection</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 400px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="date"] {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        input[type="submit"] {
            padding: 12px 0;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .message {
            margin-top: 15px;
            padding: 10px;
            border-radius: 5px;
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Modification d'une élection</h1>
        <form method="POST" action="edit_election.php?electionID=<?php echo $row['electionID']; ?>">
            <input type="hidden" name="electionID" value="<?php echo $row['electionID']; ?>">
            <label for="NB_Tour">Nombre de tours</label>
            <input type="text" name="NB_Tour" value="<?php echo $row['NB_Tour']; ?>" required>
            <label for="StartDate">Date de début</label>
            <input type="date" name="StartDate" value="<?php echo $row['StartDate']; ?>" required>
            <label for="EndDate">Date de fin</label>
            <input type="date" name="EndDate" value="<?php echo $row['EndDate']; ?>" required>
            <label for="TypeElection">Type d'élection</label>
            <input type="text" name="TypeElection" value="<?php echo $row['TypeElection']; ?>" required>
            <input type="submit" name="Update" value="Mettre à jour l'élection">   
        </form>
        <?php if(isset($message)) { ?>
        <div class="message"><?php echo $message; ?></div>
        <?php } ?>
    </div>
</body>
</html>
