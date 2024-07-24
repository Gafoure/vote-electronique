<?php
include "db_conn.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Récupération des données du formulaire
    $CIN = $conn->real_escape_string($_POST['CIN']);
    $Nom = $conn->real_escape_string($_POST['Nom']);
    $Prenom = $conn->real_escape_string($_POST['Prenom']);
    $DateNaissance = $conn->real_escape_string($_POST['DateNaissance']);
    $Genre = $conn->real_escape_string($_POST['Genre']);
    $Commune = $conn->real_escape_string($_POST['Commune']);

    // Préparation de la requête
    $sql = "INSERT INTO Utilisateur (CIN, Nom, Prenom, DateNaissance, Genre, Commune) VALUES ('$CIN', '$Nom', '$Prenom', '$DateNaissance', '$Genre', '$Commune')";

    if ($conn->query($sql) === TRUE) {
        $message = "Electeur ajouté avec succès";
    } else {
        $message = "Erreur : " . $sql . "<br>" . $conn->error;
    }
}
// Récupération des électeurs dans la base de données
$sql = "SELECT * FROM Utilisateur";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestion des Utilisateurs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --color-primary: #0073ff;
            --color-white: #e9e9e9;
            --color-black: #141d28;
            --color-black-1: #212b38;
        }

        .menu__bar {
            background-color: var(--color-black);
            height: 80px;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 5%;
        }
        .container {
            margin-top: 20px;
            background-color: #fff;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
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
            margin: 0;
            padding: 0;
        }

        .menu__bar li {
            padding: 10px 30px;
            position: relative;
        }

        .menu__bar ul li a {
            color: var(--color-white);
            text-decoration: none;
            font-size: 20px;
        }

        .menu__bar ul li a:hover {
            color: var(--color-primary);
        }

        .menu__bar ul li ul.dropdown {
            background: var(--color-primary);
            position: absolute;
            top: 100%;
            left: 0;
            width: 150px;
            display: none;
            z-index: 999;
        }

        .menu__bar ul li:hover ul.dropdown {
            display: block;
        }

        .menu__bar ul li ul.dropdown li {
            padding: 10px;
        }

        .menu__bar ul li ul.dropdown li a {
            color: var(--color-black);
            text-decoration: none;
            font-size: 16px;
        }
        .btn-vert {
        background-color: #28a745; /* Vert */
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
        font-size: 16px;
        color: white; /* Couleur du texte */
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

    .btn-vert:hover {
        background-color: #218838; /* Vert un peu plus foncé pour l'effet hover */
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
        <li><a class="active" href="connection.php">Admin</a></li>
        <li><a class="active" href="inscription.php">Vote</a></li>
        <li><a class="active" href="#contact">A propos</a></li>
    </ul>
</div>
<div class="container">
    <h1 class="mt-5">Gestion des Utilisateurs</h1>

    <?php if (isset($message)) { echo '<div class="alert alert-info">' . $message . '</div>'; } ?>
    <button class="btn btn-vert mt-3 mb-3" data-bs-toggle="modal" data-bs-target="#utilisateurForm">Ajouter un utilisateur</button>

    <!-- Formulaire pour ajouter un nouveau électeur -->
    <div class="modal fade" id="utilisateurForm" tabindex="-1" aria-labelledby="utilisateurFormLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="utilisateurFormLabel">Ajouter un utilisateur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="CIN" class="form-label">CIN:</label>
                            <input type="text" class="form-control" id="CIN" name="CIN" required>
                        </div>
                        <div class="mb-3">
                            <label for="Nom" class="form-label">Nom:</label>
                            <input type="text" class="form-control" id="Nom" name="Nom" required>
                        </div>
                        <div class="mb-3">
                            <label for="Prenom" class="form-label">Prenom:</label>
                            <input type="text" class="form-control" id="Prenom" name="Prenom" required>
                        </div>
                        <div class="mb-3">
                            <label for="DateNaissance" class="form-label">Date de Naissance:</label>
                            <input type="date" class="form-control" id="DateNaissance" name="DateNaissance" required>
                        </div>
                        <div class="mb-3">
                            <label for="Genre" class="form-label">Genre:</label>
                            <input type="text" class="form-control" id="Genre" name="Genre" required>
                        </div>
                        <div class="mb-3">
                            <label for="Commune" class="form-label">Commune:</label>
                            <input type="text" class="form-control" id="Commune" name="Commune" required>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Ajouter</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Tableau pour afficher les utilisateurs -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>UtilisateurID</th>
                <th>CIN</th>
                <th>Nom</th>
                <th>Prenom</th>
                <th>Date de Naissance</th>
                <th>Genre</th>
                <th>Commune</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row["utilisateurID"] . "</td>
                            <td>" . $row["CIN"] . "</td>
                            <td>" . $row["Nom"] . "</td>
                            <td>" . $row["Prenom"] . "</td>
                            <td>" . $row["DateNaissance"] . "</td>
                            <td>" . $row["Genre"] . "</td>
                            <td>" . $row["Commune"] . "</td>
                            <td>
                                <a href='edit_utilisateur.php?id=" . $row["utilisateurID"] . "' class='btn btn-warning'><i class='bi bi-pencil-square'></i></a>
                                <a href='delete_utilisateur.php?id=" . $row["utilisateurID"] . "' class='btn btn-danger' onclick='return confirmDelete(" . $row["utilisateurID"] . ")'><i class='bi bi-trash'></i></a>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='8' class='text-center'>Aucun utilisateur trouvé</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function confirmDelete(id) {
        return confirm("Êtes-vous sûr de vouloir supprimer cet utilisateur ?");
    }
</script>
<footer> 
    <p> Tout droit est limite &COPY;2024</p>
</footer>
</body>
</html>
