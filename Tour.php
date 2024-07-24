<?php
include 'db_conn.php';

// Vérification si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $electionID = $conn->real_escape_string($_POST['electionID']);
    $StartDate = $conn->real_escape_string($_POST['StartDate']);
    $EndDate = $conn->real_escape_string($_POST['EndDate']);

    // Préparation de la requête SQL
    $sql = "INSERT INTO tour (electionID, StartDate, EndDate) VALUES ('$electionID', '$StartDate', '$EndDate')";

    // Exécution de la requête
    if ($conn->query($sql) === TRUE) {
        $message = "Tour ajouté avec succès.";
    } else {
        $message = "Erreur : " . $sql . "<br>" . $conn->error;
    }
}
$sql_election = "SELECT * FROM election";
$sql_election_result = $conn->query($sql_election);

// Récupération des tours de la base de données
$sql = "SELECT * FROM tour";
$result = $conn->query($sql);

$elections = [];
if ($sql_election_result->num_rows > 0) {
    while ($row = $sql_election_result->fetch_assoc()) {
        $elections[$row['electionID']] = $row;
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestion des Tours</title>
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

        .btn-vert {
        background-color: #28a745; /* Vert */
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
        font-size: 16px;
        color: white; /* Couleur du texte */
        }
        .container {
            margin-top: 8px;
            background-color: #fff;
            padding: 70px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .btn-vert:hover {
        background-color: #218838; /* Vert un peu plus foncé pour l'effet hover */
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
            <h1 class="logo"><a href="Admin2.php">VoteElectronique</a></h1>
        </div>
        <ul>
            <li><a class="active" href="connection.php">Admin</a></li>
            <li><a class="active" href="inscription.php">Voter</a></li>
            <li><a class="active" href="results.php">Voir les Resultats</a></li>
            <li><a class="active" href="#contact">À propos</a></li>
        </ul>
    </div>
<div class="container">
    <h1 class="mt-5">Gestion des Tours</h1>

    <?php if(isset($message)) { echo '<div class="alert alert-info">' . $message . '</div>'; } ?>

    <button class="btn btn-vert mt-3 mb-3" data-bs-toggle="modal" data-bs-target="#tourForm">Ajouter un tour</button>

    <!-- Formulaire pour ajouter un nouveau tour -->
    <div class="modal fade" id="tourForm">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter un tour</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="electionID" class="form-label">Election ID:</label>
                            <!-- <input type="number" class="form-control" id="electionID" name="electionID" required> -->
                            <select class="form-control" id="electionID" name="electionID" required>
                            <?php
                                foreach ($elections as $electionID => $row) {
                                    echo '<option value="' . $row["electionID"] . '">Élection ' . htmlspecialchars($row["TypeElection"]) . ': Date du ' . htmlspecialchars($row["StartDate"]) . ' au ' . htmlspecialchars($row["EndDate"]) . '</option>';
                                }
                            ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="StartDate" class="form-label">Start Date:</label>
                            <input type="date" class="form-control" id="StartDate" name="StartDate" required>
                        </div>
                        <div class="mb-3">
                            <label for="EndDate" class="form-label">End Date:</label>
                            <input type="date" class="form-control" id="EndDate" name="EndDate" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Ajouter</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Tableau pour afficher les tours -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tour ID</th>
                <th>Election</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $election = $elections[$row["electionID"]] ?? ['TypeElection' => 'Inconnu', 'StartDate' => 'Inconnu', 'EndDate' => 'Inconnu'];
                echo "<tr>
                        <td>" . $row["tourID"] . "</td>
                        <td> Election " . $election["TypeElection"] . ". Du: ". $election["StartDate"] ." au ". $election["StartDate"]. "</td>
                        <td>" . $row["StartDate"] . "</td>
                        <td>" . $row["EndDate"] . "</td>
                        <td>
                            <a href='edite_tour.php?id=" . $row["tourID"] . "' class='btn btn-warning'><i class='bi bi-pencil-square'></i></a>
                            <a href='Delete_tour.php?id=" . $row["tourID"] . "' class='btn btn-danger' onclick='return confirmDelete(" . $row["tourID"] . ")'><i class='bi bi-trash'></i></a>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='5' class='text-center'>Aucun tour trouvé</td></tr>";
        }
        ?>
        </tbody>
    </table>
    <?php
    
    ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function confirmDelete(id) {
        return confirm("Êtes-vous sûr de vouloir supprimer ce tour ?");
        header("Location: Tour.php?message=" . urlencode($message));
    }
</script>
<footer>
    <p> Tout droit est limite &copy; 2024</p>
</footer>
</body>
</html>
