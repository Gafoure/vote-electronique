<?php
include 'db_conn.php';

// Vérification si le formulaire d'assignation a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['assign'])) {
    $candidatID = $conn->real_escape_string($_POST['candidatID']);
    $electionIDs = $_POST['electionID'];

    // Supprimer les anciennes associations pour ce candidat
    $sql_delete = "DELETE FROM election_candidat WHERE candidatID='$candidatID'";
    $conn->query($sql_delete);

    // Insérer les nouvelles associations
    foreach ($electionIDs as $electionID) {
        $electionID = $conn->real_escape_string($electionID);
        $sql_insert = "INSERT INTO election_candidat (candidatID, electionID) VALUES ('$candidatID', '$electionID')";
        if ($conn->query($sql_insert) !== TRUE) {
            $message = "Erreur : " . $conn->error;
            break;
        }
    }

    if (!isset($message)) {
        $message = "Candidat assigné aux élections avec succès.";
    }
}

// Vérification si le formulaire d'ajout de candidat a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['assign'])) {
    $photo = $_FILES['photo']['name'];
    $Nom = $conn->real_escape_string($_POST['nom']);
    $Prenom = $conn->real_escape_string($_POST['prenom']);
    $Age = $conn->real_escape_string($_POST['age']);
    $Adresse = $conn->real_escape_string($_POST['adresse']);

    if ($photo) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($photo);

        // Vérifiez si le téléchargement de l'image a réussi
        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
            $sql = "INSERT INTO candidat (photo, Nom, Prenom, Age, Adresse) VALUES ('$target_file', '$Nom', '$Prenom', '$Age', '$Adresse')";
        } else {
            $message = "Erreur lors du téléchargement de l'image.";
        }
    } else {
        $sql = "INSERT INTO candidat (Nom, Prenom, Age, Adresse) VALUES ('$Nom', '$Prenom', '$Age', '$Adresse')";
    }

    if (isset($sql) && $conn->query($sql) === TRUE) {
        $message = "Nouveau candidat ajouté avec succès.";
    } else {
        $message = "Erreur lors de l'ajout du candidat : " . $conn->error;
    }
}
// Récupération des candidats de la base de données
$sql = "SELECT * FROM candidat";
$result = $conn->query($sql);

// Récupération des élections de la base de données
$sql_elections = "SELECT * FROM election";
$result_elections = $conn->query($sql_elections);


$conn->close();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestion des Candidats</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 20px;
            background-color: #fff;
            padding: 10px;
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
    </style>
</head>
<body>
<div class="container">
    <h1 class="mt-5">Gestion des Candidats</h1>

    <?php if(isset($message)) { echo '<div class="alert alert-info">' . $message . '</div>'; } ?>

    <button class="btn btn-primary mt-3 mb-3" data-bs-toggle="modal" data-bs-target="#userForm">New User</button>
    <!-- Formulaire pour ajouter un nouveau candidat -->
    <div class="modal fade" id="userForm">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter un nouveau candidat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="photo" class="form-label">Photo:</label>
                            <input type="file" class="form-control" id="photo" name="photo">
                        </div>
                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom:</label>
                            <input type="text" class="form-control" id="nom" name="nom" required>
                        </div>
                        <div class="mb-3">
                            <label for="prenom" class="form-label">Prenom:</label>
                            <input type="text" class="form-control" id="prenom" name="prenom" required>
                        </div>
                        <div class="mb-3">
                            <label for="age" class="form-label">Age:</label>
                            <input type="number" class="form-control" id="age" name="age" required>
                        </div>
                        <div class="mb-3">
                            <label for="adresse" class="form-label">Adresse:</label>
                            <input type="text" class="form-control" id="adresse" name="adresse" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Ajouter</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Photo</th>
                <th>Nom</th>
                <th>Prenom</th>
                <th>Age</th>
                <th>Adresse</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["candidatID"] . "</td>
                        <td><img src='" . $row["photo"] . "' width='50' height='50'></td>
                        <td>" . $row["Nom"] . "</td>
                        <td>" . $row["Prenom"] . "</td>
                        <td>" . $row["Age"] . "</td>
                        <td>" . $row["Adresse"] . "</td>
                        <td>
                            <a href='edite_candidat.php?id=" . $row["candidatID"] . "' class='btn btn-warning'>Modifier</a>
                            <button class='btn btn-info' data-bs-toggle='modal' data-bs-target='#assignElectionModal' data-candidatid='" . $row["candidatID"] . "'>Assigner à une élection</button>
                            <a href='Delete_candidat.php?id=" . $row["candidatID"] . "' class='btn btn-danger'>Supprimer</a>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='7' class='text-center'>Aucun candidat trouvé</td></tr>";
        }
        ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Récupérer les données du candidat pour l'assignation
    document.querySelectorAll('.btn-info').forEach(button => {
        button.addEventListener('click', function() {
            const candidatID = this.getAttribute('data-candidatid');
            document.getElementById('candidatID').value = candidatID;
        });
    });
</script>
</body>
</html>
