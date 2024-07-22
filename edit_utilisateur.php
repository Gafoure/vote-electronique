<?php
include 'db_conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $utilisateurID = $conn->real_escape_string($_POST['utilisateurID']);
    $CIN = $conn->real_escape_string($_POST['CIN']);
    $Nom = $conn->real_escape_string($_POST['Nom']);
    $Prenom = $conn->real_escape_string($_POST['Prenom']);
    $DateNaissance = $conn->real_escape_string($_POST['DateNaissance']);
    $Genre = $conn->real_escape_string($_POST['Genre']);
    $Commune = $conn->real_escape_string($_POST['Commune']);

    // Requête pour mettre à jour l'utilisateur
    $sql = "UPDATE Utilisateur SET CIN='$CIN', Nom='$Nom', Prenom='$Prenom', DateNaissance='$DateNaissance', Genre='$Genre', Commune='$Commune' WHERE utilisateurID='$utilisateurID'";

    if ($conn->query($sql) === TRUE) {
        $message = "Electeur modifié avec succès";
    } else {
        $message = "Erreur : " . $sql . "<br>" . $conn->error;
    }

    header('Location: Liste_electeur.php?message=' . urlencode($message));
    exit();
}

// Récupérer l'utilisateur à modifier
$utilisateurID = $_GET['id'];
$sql = "SELECT * FROM Utilisateur WHERE utilisateurID=$utilisateurID";
$result = $conn->query($sql);
$utilisateur = $result->fetch_assoc();

$conn->close();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Modifier Electeur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            width: 400px;
            margin-top: 20px;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .form-label {
            font-weight: bold;
        }
        .form-control {
            border-radius: 5px;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 16px;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .alert {
            margin-top: 20px;
        }
        .form-container {
            max-width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<div class="container">
    <h1 class="mt-5">Modifier Electeur</h1>

    <?php if(isset($message)) { echo '<div class="alert alert-info">' . $message . '</div>'; } ?>

    <div class="form-container">
        <form action="" method="post" class="mt-3 mb-5">
            <input type="hidden" name="utilisateurID" value="<?php echo $utilisateur['utilisateurID']; ?>">
            <div class="mb-3">
                <label for="CIN" class="form-label">CIN:</label>
                <input type="text" class="form-control" id="CIN" name="CIN" value="<?php echo $utilisateur['CIN']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="Nom" class="form-label">Nom:</label>
                <input type="text" class="form-control" id="Nom" name="Nom" value="<?php echo $utilisateur['Nom']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="Prenom" class="form-label">Prenom:</label>
                <input type="text" class="form-control" id="Prenom" name="Prenom" value="<?php echo $utilisateur['Prenom']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="DateNaissance" class="form-label">DateNaissance:</label>
                <input type="text" class="form-control" id="DateNaissance" name="DateNaissance" value="<?php echo $utilisateur['DateNaissance']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="Genre" class="form-label">Genre:</label>
                <input type="text" class="form-control" id="Genre" name="Genre" value="<?php echo $utilisateur['Genre']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="Commune" class="form-label">Commune:</label>
                <input type="text" class="form-control" id="Commune" name="Commune" value="<?php echo $utilisateur['Commune']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Modifier</button>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
