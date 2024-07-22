<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projet_memoire";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}
// Suppression d'une élection via AJAX
if (isset($_POST['delete'])) {
    $ElectionID = intval($_POST['delete']);
    $sql = "DELETE FROM election WHERE ElectionID=$ElectionID";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => true, "message" => "Election supprimée avec succès."]);
    } else {
        echo json_encode(["success" => false, "message" => "Erreur lors de la suppression : " . $conn->error]);
    }
    exit;
}
// Récupération des données de la table election
$sql = "SELECT * FROM election";
$result = $conn->query($sql);

// Fermeture de la connexion
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestion des Élections</title>
    <link rel="stylesheet" href="style.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        body {
            background: url(background.png) center/cover no-repeat;
            height: 100vh;
            font-family: Arial, sans-serif;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: flex-start;
            width: 90%;
            max-width: 1200px;
            margin-top: 100px;
        }
        .connection {
            width: 500px;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        h1, h4 {
            text-align: center;
            margin: 0;
            padding: 10px 0;
        }

        form {
            width: 100%;
        }

        form label {
            display: block;
            margin-top: 20px;
            font-size: 18px;
        }

        form input, form select {
            width: calc(100% - 20px);
            margin-top: 5px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            outline: none;
            transition: border-color 0.3s ease;
        }

        form input:focus, form select:focus {
            border-color: #007bff;
        }

        input[type="submit"] {
            width: 100%;
            margin-top: 20px;
            background-color: #007bff;
            color: #fff;
            font-size: 18px;
            border: none;
            border-radius: 6px;
            padding: 12px 0;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: rgb(13, 211, 247);
        }

        p {
            text-align: center;
            margin-top: 20px;
            font-size: 15px;
        }

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

        .election-list {
            width: 90%;
            padding: 30px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .election-list table {
            width: 100%;
            border-collapse: collapse;
        }

        .election-list table, th, td {
            border: 1px solid #ddd;
        }

        .election-list th, .election-list td {
            padding: 12px;
            text-align: left;
        }

        .election-list th {
            background-color: #f2f2f2;
        }

        .message {
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid transparent;
            border-radius: 4px;
        }

        .message.success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }

        .message.error {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }

        .btn-delete {
            background-color: #ff0000;
            color: #fff;
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .edit-btn {
            background-color: #4CAF50;
            color: #fff;
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-delete:hover {
            background-color: #cc0000;
        }

        footer {
            background-color: var(--color-black);
            color: var(--color-white);
            padding: 0%;
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
        <h1 class="logo">VoteElectronique</h1>
        </div>
        <ul>
            <li><a class="active" href="index.php">Home</a></li>
            <li><a class="active" href="connection.php">Admin</a></li>
            <li><a class="active" href="Inscription.php">Vote</a></li>
            <li><a class="active" href="##">A Propos</a></li>
        </ul>
    </div>

    <div class="container">
        <div id="message"></div>
        <div class="election-list">
            <h2>Liste des élections</h2>
            <table>
                <thead>
                    <tr>
                        <th>electionID</th>
                        <th>Nombre de tours</th>
                        <th>Date de début</th>
                        <th>Date de fin</th>
                        <th>Type d'élection</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr id='election-row-" . $row["electionID"] . "'>";
                            echo "<td>" . $row["electionID"] . "</td>";
                            echo "<td>" . $row["TypeElection"] . "</td>";
                            echo "<td>" . $row["NB_Tour"] . "</td>";
                            echo "<td>" . $row["StartDate"] . "</td>";
                            echo "<td>" . $row["EndDate"] . "</td>";
                            echo "<td><a button class='edit-btn'  href='edit_election.php?electionID=" . $row["electionID"] . "'><i class='bi bi-pencil-square'></i></a>   <button class='btn-delete' onclick='confirmDelete(" . $row["electionID"] . ")'><i class='bi bi-trash'></i></button></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>Aucune élection trouvée</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        function confirmDelete(id) {
            if (confirm("Êtes-vous sûr de vouloir supprimer cette élection ?")) {
                const xhr = new XMLHttpRequest();
                xhr.open("POST", "Liste_election.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        const response = JSON.parse(xhr.responseText);
                        const messageBox = document.getElementById('message');
                        if (response.success) {
                            messageBox.className = 'message success';
                            messageBox.textContent = response.message;
                            document.getElementById('election-row-' + id).remove();
                        } else {
                            messageBox.className = 'message error';
                            messageBox.textContent = response.message;
                        }
                    }
                };
                xhr.send("delete=" + id);
            }
        }
    </script>
    <footer>
        <p> Tout droit est limiter &copy; 2024</p>
    </footer>
</body>
</html>
