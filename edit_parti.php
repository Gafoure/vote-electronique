<?php
include 'db_conn.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = isset($_POST['partiID']) ? $_POST['partiID'] : null;
    $codeParti = isset($_POST['CodeParti']) ? $conn->real_escape_string($_POST['CodeParti']) : '';
    $nomParti = isset($_POST['NomParti']) ? $conn->real_escape_string($_POST['NomParti']) : '';
    $description = isset($_POST['Description']) ? $conn->real_escape_string($_POST['Description']) : '';
    $photo = isset($_FILES['Photo']['name']) ? $_FILES['Photo']['name'] : '';

    // Vérifiez si une nouvelle photo a été téléchargée
    if (!empty($photo)) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($photo);

        // Vérifiez si le téléchargement de l'image a réussi
        if (move_uploaded_file($_FILES["Photo"]["tmp_name"], $target_file)) {
            $stmt = $conn->prepare("UPDATE parti SET Photo=?, codeParti=?, NomParti=?, Description=? WHERE partiID=?");
            $stmt->bind_param('ssssi', $target_file, $codeParti, $nomParti, $description, $id);
        } else {
            $message = "Erreur lors du téléchargement de l'image.";
        }
    } else {
        $stmt = $conn->prepare("UPDATE parti SET codeParti=?, NomParti=?, Description=? WHERE partiID=?");
        $stmt->bind_param('sssi', $codeParti, $nomParti, $description, $id);
    }

    if (isset($stmt) && $stmt->execute()) {
        $message = "Parti modifié avec succès.";
    } else {
        $message = "Erreur lors de la modification du parti : " . $conn->error;
    }

    if (isset($stmt)) {
        $stmt->close();
    }
    $conn->close();
    header('Location: Parti.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM parti WHERE partiID=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $parti = $result->fetch_assoc();
    $stmt->close();
    $conn->close();
} else {
    echo "Aucun ID de parti fourni.";
    exit();
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Modifier Parti</title>
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
            width: 500px;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .form-label {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .form-control {
            border-radius: 5px;
            padding: 10px;
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
    <h1 class="mt-5">Modifier Parti</h1>

    <?php if (!empty($message)) { echo '<div class="alert alert-info">' . $message . '</div>'; } ?>

    <form action="edit_parti.php" method="post" enctype="multipart/form-data" class="mt-3 mb-5">
        <input type="hidden" name="partiID" value="<?php echo htmlspecialchars($parti['partiID']); ?>">
        <div class="mb-3">
            <label for="Photo" class="form-label">Photo:</label>
            <input type="file" class="form-control" id="Photo" name="Photo">
            <?php if (!empty($parti['Photo'])): ?>
                <img src="<?php echo htmlspecialchars($parti['Photo']); ?>" width="100" height="100" class="mt-3">
            <?php endif; ?>
        </div>
        <div class="mb-3">
            <label for="CodeParti" class="form-label">Code du Parti:</label>
            <input type="text" class="form-control" id="CodeParti" name="CodeParti" value="<?php echo htmlspecialchars($parti['CodeParti']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="NomParti" class="form-label">Nom du parti:</label>
            <input type="text" class="form-control" id="NomParti" name="NomParti" value="<?php echo htmlspecialchars($parti['NomParti']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="Description" class="form-label">Description:</label>
            <input type="text" class="form-control" id="Description" name="Description" value="<?php echo htmlspecialchars($parti['Description']); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Modifier</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
