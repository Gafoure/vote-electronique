<?php
include "db_conn.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Récupération des données du formulaire
    $utilisateurID = $conn->real_escape_string($_POST['utilisateurID']);
    $Password = password_hash($conn->real_escape_string($_POST['Password']), PASSWORD_BCRYPT); // Hash du mot de passe
    $Email = $conn->real_escape_string($_POST['Email']);

    // Préparation de la requête
    $sql = "INSERT INTO admin (utilisateurID, Password, Email) VALUES ('$utilisateurID', '$Password', '$Email')";

    if ($conn->query($sql) === TRUE) {
        $message = "Admin ajouté avec succès";
    } else {
        $message = "Erreur : " . $sql . "<br>" . $conn->error;
    }
}
// Récupération des administrateurs dans la base de données
$sql = "SELECT * FROM admin";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestion des Admins</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --color-primary: #0073ff;
            --color-white: #e9e9e9;
            --color-black: #141d28;
            --color-black-1: #212b38;
        }
            .container {
            margin-top: 10px;
            background-color: #fff;
            padding: 80px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
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
        footer {
            background-color: var(--color-black);
            color: var(--color-white);
            padding: 10px;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        .btn-vert {
            background-color: #28a745; /* Vert */
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 16px;
            color: white; /* Couleur du texte */
        }

        .btn-vert:hover {
            background-color: #218838; /* Vert un peu plus foncé pour l'effet hover */
        }
    </style>
</head>
<body>
    <!-- <h1 class="logo"><a href="Admin2.php" style="color: var(--color-primary); text-decoration: none;">SVE</a></h1> -->
    <div class="menu__bar">
        <div class="logo-container">
            <img src="./image/drapeau.png" alt="Logo" class="logo-image">
            <h1 class="logo"><a href="Admin2.php">VoteElectronique</a></h1>
        </div>
        <ul>
            <li><a class="active" href="index.php">Home</a></li>
            <li><a class="active" href="inscription.php">Voter</a></li>
            <li><a class="active" href="Resultat.php">Resultats</a></li>
            <li><a class="active" href="#contact">À propos</a></li>
        </ul>
    </div>
<div class="container">
    <h1 class="mt-5">Gestion des Admins</h1>

    <?php if (isset($message)) { echo '<div class="alert alert-info">' . $message . '</div>'; } ?>
    <button class="btn btn-vert mt-3 mb-3" data-bs-toggle="modal" data-bs-target="#adminForm">Ajouter un administrateur</button>

    <!-- Formulaire pour ajouter un nouveau administrateur -->
    <div class="modal fade" id="adminForm" tabindex="-1" aria-labelledby="adminFormLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="adminFormLabel">Ajouter un Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="utilisateurID" class="form-label">UtilisateurID:</label>
                            <input type="text" class="form-control" id="utilisateurID" name="utilisateurID" required>
                        </div>
                        <div class="mb-3">
                            <label for="Password" class="form-label">Password:</label>
                            <input type="password" class="form-control" id="Password" name="Password" required>
                        </div>
                        <div class="mb-3">
                            <label for="Email" class="form-label">Email:</label>
                            <input type="email" class="form-control" id="Email" name="Email" required>
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

    <!-- Tableau pour afficher les administrateurs -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>AdminID</th>
                <th>UtilisateurID</th>
                <th>Password</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row["AdminID"] . "</td>
                            <td>" . $row["utilisateurID"] . "</td>
                            <td>" . $row["Password"] . "</td>
                            <td>" . $row["Email"] . "</td>
                            <td>
                                <a href='edit_admin.php?id=" . $row["AdminID"] . "' class='btn btn-warning'><i class='bi bi-pencil-square'></i></a>
                                <a href='delete_admin.php?id=" . $row["AdminID"] . "' class='btn btn-danger' onclick='return confirmDelete(" . $row["AdminID"] . ")'><i class='bi bi-trash'></i></a>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5' class='text-center'>Aucun administrateur trouvé</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function confirmDelete(id) {
        return confirm("Êtes-vous sûr de vouloir supprimer cet administrateur ?");
    }
</script>
<footer>
    <p> Tout droit est limites &copy; 2024</p>
</footer>
</body>
</html>
