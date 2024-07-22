<?php
include 'db_conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $utilisateurID = $conn->real_escape_string($_POST['utilisateurID']);
    $Password = $conn->real_escape_string($_POST['Password']);
    $Email = $conn->real_escape_string($_POST['Email']);
    // Requête pour mettre à jour l'utilisateur
    $sql = "UPDATE admin SET utilisateurID='$utilisateurID', Password='$Password', Email='$Email' WHERE AdminID='$AdminID'";

    if ($conn->query($sql) === TRUE) {
        $message = "Admin modifié avec succès";
    } else {
        $message = "Erreur : " . $sql . "<br>" . $conn->error;
    }

    header('Location: Liste_Admin.php?message=' . urlencode($message));
    exit();
}

// Récupérer l'utilisateur à modifier
$AdminID = $_GET['id'];
$sql = "SELECT * FROM admin WHERE AdminID=$AdminID";
$result = $conn->query($sql);
$admin = $result->fetch_assoc();

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
            <input type="hidden" name="AdminID" value="<?php echo $admin['AdminID']; ?>">
            <div class="mb-3">
                <label for="utilisateurID" class="form-label">utilisateurID:</label>
                <input type="text" class="form-control" id="utilisateurID" name="utilisateurID" value="<?php echo $admin['utilisateurID']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="Password" class="form-label">Password:</label>
                <input type="text" class="form-control" id="Password" name="Password" value="<?php echo $admin['Password']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="Email" class="form-label">Email:</label>
                <input type="text" class="form-control" id="Email" name="Email" value="<?php echo $admin['Email']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Modifier</button>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
