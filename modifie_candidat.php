<!-- <?php
// Connexion à la base de données
// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "projet mémoire"; // Correction du nom de la base de données

// // Vérifie si l'ID du candidat à modifi=er est présent dans l'URL
// if (isset($_GET['candidatID'])) {
//     $id = $_GET['candidatID'];

//     $conn = mysqli_connect($servername, $username, $password, $dbname);

//     if (!$conn) {
//         die("Connection failed: " . mysqli_connect_error());
//     }

//     // Requête pour récupérer les informations du candidat avec l'ID spécifié
//     $sql = "SELECT * FROM candidat WHERE candidatID=?";
    
//     $stmt = mysqli_prepare($conn, $sql);
//     mysqli_stmt_bind_param($stmt, "i", $id);
//     mysqli_stmt_execute($stmt);
    
//     $result = mysqli_stmt_get_result($stmt);

//     if (mysqli_num_rows($result) > 0) {
//         $row = mysqli_fetch_assoc($result);
//     } else {
//         echo "Aucun candidat trouvé avec cet identifiant.";
//     }

//     mysqli_stmt_close($stmt);
//     mysqli_close($conn);
// } else {
//     echo "Identifiant du candidat non spécifié.";
// }

// // Vérifie si le formulaire a été soumis et si les champs requis sont définis
// if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
//     // Récupération des données du formulaire
//     $id = $_POST['id'];
//     $nom = $_POST['Infos'];
//     $photo = $_POST['Photo']; // Correction du nom de la variable
//     $programme = $_POST['programme'];

//     $conn = mysqli_connect($servername, $username, $password, $dbname);

//     if (!$conn) {
//         die("Connection failed: " . mysqli_connect_error());
//     }

//     // Mise à jour des informations du candidat dans la base de données
//     $sql = "UPDATE candidat SET Infos=?, Photo=?, programme=? WHERE candidatID=?";
    
//     $stmt = mysqli_prepare($conn, $sql);
//     mysqli_stmt_bind_param($stmt, "sssi", $nom, $photo, $programme, $id); // Correction du nom de la variable
//     mysqli_stmt_execute($stmt);
    
//     mysqli_stmt_close($stmt);
//     mysqli_close($conn);

//     // Redirection vers la liste des candidats après l'enregistrement des modifications
//     header("Location: liste_candidat.php");
//     exit();
// }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Candidat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }
        form {
            width: 50%;
            margin: auto;
            text-align: left;
        }
        label {
            display: block;
            margin-bottom: 2px;
        }
        input[type="text"], textarea {
            width: calc(50% - 8px);
            padding: 4px;
            margin-bottom: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            border: none;
            border-radius: 2px;
            cursor: pointer;
            margin-top: 9px;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    
</html> -->




<?php
   session_start();

   include("db_conn.php"); // Assurez-vous que le chemin vers session.php est correct

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Vérifie si le formulaire a été soumis avec les données requises
        if (isset($_POST['id']) && isset($_POST['infos']) && isset($_POST['photo']) && isset($_POST['programme'])) {
            // Récupère les données du formulaire
            $id = $_POST['id'];
            $infos = $_POST['infos'];
            $photo = $_POST['photo'];
            $programme = $_POST['programme'];

            // Prépare la requête SQL pour mettre à jour les informations du candidat
            $sql = "UPDATE candidats SET infos = '$infos', photo = '$photo', programme = '$programme' WHERE id = '$id'";

            // Exécute la requête SQL
            if ($conn->query($sql) === TRUE) {
                $_SESSION['success'] = 'Les informations du candidat ont été mises à jour avec succès';
            } else {
                $_SESSION['error'] = 'Erreur lors de la mise à jour des informations du candidat : ' . $conn->error;
            }
        } else {
            $_SESSION['error'] = 'Tous les champs du formulaire de modification sont requis';
        }
    } else {
        $_SESSION['error'] = 'La méthode de requête HTTP n\'est pas prise en charge';
    }

    // Redirige l'utilisateur vers la page de liste des candidats
    header('Location: liste_candidat.php');
    exit();
?>

