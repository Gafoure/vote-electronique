<?php
include 'db_conn.php';

$message = '';

// Vérification si le formulaire d'assignation au parti a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['assign_parti'])) {
    $candidatID = $conn->real_escape_string($_POST['candidatID']);
    $partiIDs = $_POST['partiID'];

    // Supprimer les anciennes associations pour ce candidat
    $sql_delete = "DELETE FROM candidat_parti WHERE candidatID='$candidatID'";
    $conn->query($sql_delete);

    // Insérer les nouvelles associations
    foreach ($partiIDs as $partiID) {
        $partiID = $conn->real_escape_string($partiID);
        $sql_insert = "INSERT INTO candidat_parti (candidatID, partiID) VALUES ('$candidatID', '$partiID')";
        if ($conn->query($sql_insert) !== TRUE) {
            $message = "Erreur : " . $conn->error;
            break;
        }
    }

    if (!isset($message)) {
        $message = "Candidat assigné au(x) parti(s) avec succès.";
    }
}

// Récupération des candidats de la base de données
$sql = "SELECT * FROM candidat";
$result = $conn->query($sql);

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
                            <label for="nomParti" class="form-label">NomParti:</label>
                            <input type="text" class="form-control" id="nomParti" name="nomParti" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">description:</label>
                            <input type="text" class="form-control" id="description" name="description" required>
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
