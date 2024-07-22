<?php
include 'db_conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['candidatID'];
    $photo = $_FILES['photo']['name'];
    $Nom = $conn->real_escape_string($_POST['nom']);
    $Prenom = $conn->real_escape_string($_POST['prenom']);
    $Age = $conn->real_escape_string($_POST['age']);
    $Adresse = $conn->real_escape_string($_POST['adresse']);

    // Vérifiez si une nouvelle photo a été téléchargée
    if ($photo) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($photo);

        // Vérifiez si le téléchargement de l'image a réussi
        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
            $stmt = $conn->prepare("UPDATE candidat SET photo=?, Nom=?, Prenom=?, Age=?, Adresse=? WHERE candidatID=?");
            $stmt->bind_param('sssisi', $target_file, $Nom, $Prenom, $Age, $Adresse, $id);
        } else {
            $message = "Erreur lors du téléchargement de l'image.";
        }
    } else {
        $stmt = $conn->prepare("UPDATE candidat SET Nom=?, Prenom=?, Age=?, Adresse=? WHERE candidatID=?");
        $stmt->bind_param('ssisi', $Nom, $Prenom, $Age, $Adresse, $id);
    }

    if (isset($stmt) && $stmt->execute()) {
        $message = "Candidat modifié avec succès.";
    } else {
        $message = "Erreur lors de la modification du candidat : " . $conn->error;
    }

    $stmt->close();
    $conn->close();
    header('Location: Liste_candidat.php');
    exit();
}

$id = $_GET['id'];
$sql = "SELECT * FROM candidat WHERE candidatID=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$candidat = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Modifier Candidat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
        background-color: #f8f9fa;
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .container {
        width: 500px; /* Ajustez cette valeur pour définir la largeur du formulaire */
        background-color: #fff;
        padding: 20px; /* Réduisez cette valeur pour moins de padding à l'intérieur du formulaire */
        border-radius: 10px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }

    .form-label {
        font-weight: bold;
        margin-bottom: 5px;
    }

    .form-control {
        border-radius: 5px; /* Réduisez cette valeur pour des coins moins arrondis */
        padding: 10px; /* Ajustez cette valeur pour moins de padding à l'intérieur des champs de saisie */
        margin-bottom: 15px;
        border: 1px solid #ccc;
        font-size: 16px;
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .alert {
        margin-top: 20px;
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
    <h1 class="mt-5">Modifier Candidat</h1>

    <?php if(isset($message)) { echo '<div class="alert alert-info">' . $message . '</div>'; } ?>

    <form action="edite_candidat.php" method="post" enctype="multipart/form-data" class="mt-3 mb-5">
        <input type="hidden" name="candidatID" value="<?php echo $candidat['candidatID']; ?>">
        <div class="mb-3">
            <label for="photo" class="form-label">Photo:</label>
            <input type="file" class="form-control" id="photo" name="photo">
            <img src="<?php echo $candidat['photo']; ?>" width="100" height="100" class="mt-3">
        </div>

        <div class="mb-3">
            <label for="nom" class="form-label">Nom:</label>
            <input type="text" class="form-control" id="nom" name="nom" value="<?php echo $candidat['Nom']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="prenom" class="form-label">Prenom:</label>
            <input type="text" class="form-control" id="prenom" name="prenom" value="<?php echo $candidat['Prenom']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="age" class="form-label">Age:</label>
            <input type="number" class="form-control" id="age" name="age" value="<?php echo $candidat['Age']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="adresse" class="form-label">Adresse:</label>
            <input type="text" class="form-control" id="adresse" name="adresse" value="<?php echo $candidat['Adresse']; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Modifier</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
