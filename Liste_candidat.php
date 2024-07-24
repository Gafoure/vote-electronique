<?php
include 'db_conn.php';

$message = '';

// Vérification si le formulaire d'assignation à une élection a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['assignElection'])) {
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

// Vérification si le formulaire d'assignation à un parti a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['assignParti'])) {
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
        $message = "Candidat assigné aux partis avec succès.";
    }
}

// Vérification si le formulaire d'ajout de candidat a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['assignElection']) && !isset($_POST['assignParti'])) {
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

// Récupération des partis de la base de données
$sql_partis = "SELECT * FROM parti";
$result_partis = $conn->query($sql_partis);

$conn->close();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestion des Candidats</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --color-primary: #0073ff;
            --color-white: #e9e9e9;
            --color-black: #141d28;
            --color-black-1: #212b38;
        }
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
        .modal-body {
            max-height: 400px;
            overflow-y: auto;
        }
        /* Bouton Modifier (vert) */
        .btn-success {
            background-color: green;
            border-color: green;
        }

        /* Bouton Assigner à une élection (jaune) */
        .btn-warning {
            background-color: yellow;
            border-color: yellow;
        }

        /* Bouton Supprimer (rouge) */
        .btn-danger {
            background-color: red;
            border-color: red;
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

        footer {
            background-color: var(--color-black);
            color: var(--color-white);
            padding: 3px;
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
            <h1 class="logo"><a href="Admin2.php">VoteElectronique</a></h1>
        </div>
        <ul>
            <li><a class="active" href="index.php">Home</a></li>
            <li><a class="active" href="connection.php">Voter</a></li>
            <li><a class="active" href="connection.php">A Propos</a></li>
        </ul>
    </div>
<div class="container">
    <h1 class="mt-5">Gestion des Candidats</h1>

    <?php if(isset($message)) { echo '<div class="alert alert-info">' . $message . '</div>'; } ?>

    <button class="btn btn-primary mt-3 mb-3" data-bs-toggle="modal" data-bs-target="#userForm">Ajouter un candidat</button>

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
                            <a href='edite_candidat.php?id=" . $row["candidatID"] . "' class='btn btn-success'><i class='bi bi-pencil-square'></i></a>
                            <button class='btn btn-warning' data-bs-toggle='modal' data-bs-target='#assignElectionModal' data-candidatid='" . $row["candidatID"] . "'>Assigne à une élection</button>
                            <a href='Delete_candidat.php?id=" . $row["candidatID"] . "' class='btn btn-danger'><i class='bi bi-trash'></i></a>
                            <button class='btn btn-warning' data-bs-toggle='modal' data-bs-target='#assignPartiModal' data-candidatid='" . $row["candidatID"] . "'>Assigne à un parti</button>
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

<!-- Modal d'assignation à une élection -->
<div class="modal fade" id="assignElectionModal" tabindex="-1" aria-labelledby="assignElectionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignElectionModalLabel">Assigner le candidat à une élection</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <input type="hidden" id="candidatID" name="candidatID">
                    <div class="mb-3">
                        <label for="electionID" class="form-label">Élections:</label>
                        <select class="form-control" id="electionID" name="electionID[]" multiple>
                        <?php
                            if ($result_elections->num_rows > 0) {
                                while($row = $result_elections->fetch_assoc()) {
                                    echo "<option value='" . $row["electionID"] . "'>" . $row["TypeElection"] . "</option>";
                                }
                            } else {
                                echo "<option value=''>Aucune élection disponible</option>";
                            }
                        ?>
                        </select>
                    </div>
                    <button type="submit" name="assignElection" class="btn btn-primary">Assigner</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal d'assignation à un parti -->
<div class="modal fade" id="assignPartiModal" tabindex="-1" aria-labelledby="assignPartiModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignPartiModalLabel">Assigner le candidat à un parti</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <input type="hidden" id="candidatID" name="candidatID">
                    <div class="mb-3">
                        <label for="partiID" class="form-label">Partis:</label>
                        <select class="form-control" id="partiID" name="partiID[]" multiple>
                        <?php
                            if ($result_partis->num_rows > 0) {
                                while($row = $result_partis->fetch_assoc()) {
                                    echo "<option value='" . $row["partiID"] . "'>" . $row["NomParti"] . "</option>";
                                }
                            } else {
                                echo "<option value=''>Aucun parti disponible</option>";
                            }
                        ?>
                        </select>
                    </div>
                    <button type="submit" name="assignParti" class="btn btn-primary">Assigner</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Récupérer les données du candidat pour l'assignation à une élection
    document.querySelectorAll('.btn-warning[data-bs-target="#assignElectionModal"]').forEach(button => {
        button.addEventListener('click', function() {
            const candidatID = this.getAttribute('data-candidatid');
            document.getElementById('assignElectionModal').querySelector('input[name="candidatID"]').value = candidatID;
        });
    });

    // Récupérer les données du candidat pour l'assignation à un parti
    document.querySelectorAll('.btn-warning[data-bs-target="#assignPartiModal"]').forEach(button => {
        button.addEventListener('click', function() {
            const candidatID = this.getAttribute('data-candidatid');
            document.getElementById('assignPartiModal').querySelector('input[name="candidatID"]').value = candidatID;
        });
    });
</script>

<footer>
   <p> Tout droit est limite &copy 2024</p> 
</footer>
</body>
</html>
