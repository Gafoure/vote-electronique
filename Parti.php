<?php
include 'db_conn.php';

$message = '';

// Vérification si le formulaire d'ajout de parti a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $photo = isset($_FILES['Photo']['name']) ? $_FILES['Photo']['name'] : '';
    $codeParti = $conn->real_escape_string($_POST['CodeParti']);
    $nomParti = $conn->real_escape_string($_POST['nomParti']);
    $description = $conn->real_escape_string($_POST['description']);

    if (!empty($photo)) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($photo);

        // Vérifiez si le téléchargement de l'image a réussi
        if (move_uploaded_file($_FILES["Photo"]["tmp_name"], $target_file)) {
            $sql = "INSERT INTO parti (Photo, CodeParti, NomParti, Description) VALUES ('$target_file', '$codeParti', '$nomParti', '$description')";
        } else {
            $message = "Erreur lors du téléchargement de l'image.";
        }
    } else {
        $sql = "INSERT INTO parti (CodeParti, NomParti, Description) VALUES ('$codeParti', '$nomParti', '$description')";
    }

    if (isset($sql) && $conn->query($sql) === TRUE) {
        $message = "Nouveau parti ajouté avec succès.";
    } else {
        $message = "Erreur lors de l'ajout du parti : " . $conn->error;
    }
}

// Récupération des partis de la base de données
$sql = "SELECT * FROM parti";
$result = $conn->query($sql);
$conn->close();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestion des Partis</title>
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
            margin-top: 9px;
            background-color: #fff;
            padding: 50px;
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
            <img src="./image/drapeau.png" alt=Logo class="logo-image">
            <h1 class="logo">VoteElectronique</h1>
        </div>
        <ul> 
            <li><a class="active" href="connection.php">Admin</a></li>
            <li><a class="active" href="inscription.php">Voter</a></li>
            <li><a class="active" href="results.php">A propos</a></li>
        </ul>
    </div>
<div class="container">
    <h1 class="mt-5">Gestion des Partis</h1>

    <?php if(isset($_GET['message'])) { echo '<div class="alert alert-info">' . htmlspecialchars($_GET['message']) . '</div>'; } ?>

    <button class="btn btn-primary mt-3 mb-3" data-bs-toggle="modal" data-bs-target="#userForm">Ajouter un parti</button>

    <!-- Formulaire pour ajouter un nouveau parti -->
    <div class="modal fade" id="userForm">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter un nouveau parti</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="Photo" class="form-label">Photo:</label>
                            <input type="file" class="form-control" id="Photo" name="Photo">
                        </div>
                        <div class="mb-3">
                            <label for="CodeParti" class="form-label">Code Parti:</label>
                            <input type="text" class="form-control" id="CodeParti" name="CodeParti" required>
                        </div>
                        <div class="mb-3">
                            <label for="nomParti" class="form-label">Nom du Parti:</label>
                            <input type="text" class="form-control" id="nomParti" name="nomParti" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description:</label>
                            <textarea class="form-control" id="description" name="description" required></textarea>
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
                <th>Code Parti</th>
                <th>Photo</th>
                <th>Nom du Parti</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . htmlspecialchars($row["CodeParti"]) . "</td>
                        <td><img src='" . htmlspecialchars($row["Photo"]) . "' width='50' height='50'></td>
                        <td>" . htmlspecialchars($row["NomParti"]) . "</td>
                        <td>" . htmlspecialchars($row["Description"]) . "</td>
                        <td>
                            <a href='edit_parti.php?id=" . intval($row["partiID"]) . "' class='btn btn-success'><i class='bi bi-pencil-square'></i></a>
                            <button class='btn btn-danger' onclick='confirmDelete(" . intval($row["partiID"]) . ")'><i class='bi bi-trash'></i></button>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='5' class='text-center'>Aucun parti trouvé</td></tr>";
        }
        ?>
        </tbody>
    </table>
</div>

<!-- Modal de confirmation de suppression -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteLabel">Confirmer la suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Êtes-vous sûr de vouloir supprimer ce parti ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Supprimer</button>
            </div>
        </div>
    </div>
</div>

<script>
    let deleteId = null;
    function confirmDelete(id) {
        deleteId = id;
        const deleteModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'), {});
        deleteModal.show();
    }

    document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
        if (deleteId !== null) {
            window.location.href = 'delete_parti.php?id=' + deleteId;
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>

    <footer>
        <p>Tout droit est limites &copy; 2024</p>
    </footer>

</body>
</html>
