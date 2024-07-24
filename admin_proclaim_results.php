<?php
include 'db_conn.php';

// Vérifiez si l'administrateur a proclamé les résultats
if (isset($_POST['proclaim'])) {
    $electionID = intval($_POST['electionID']);
    $sql_proclaim = "UPDATE election SET resultsProclaimed = TRUE WHERE electionID = $electionID";
    if ($conn->query($sql_proclaim) === TRUE) {
        echo "Les résultats ont été proclamés avec succès.";
    } else {
        echo "Erreur lors de la proclamation des résultats : " . $conn->error;
    }
}

// Récupérer la liste des élections
$sql_elections = "SELECT electionID, TypeElection FROM election";
$result_elections = $conn->query($sql_elections);
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1'>
    <title>Proclamer les résultats</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
           
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin-top: 50px;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .btn btn-primary{
            width: 50%;
            padding: 10px;
            border-radius: 3px;
        }
        .form-label {
            font-weight: bold;
        }
        .form-select,
        .btn-primary {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
        }
        .btn-primary {
            margin-top: 30px;
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .text-center {
            text-align: center;
        }
        .mt-5 {
            margin-top: 20px;
        }
        .mb-3 {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1 class="text-center mt-5">Proclamer les résultats</h1>
    <form method="post" class="mt-5">
        <div class="mb-3">
            <label for="electionID" class="form-label">Sélectionnez une élection</label>
            <select class="form-select" id="electionID" name="electionID">
                <?php while ($row = $result_elections->fetch_assoc()): ?>
                    <option value="<?php echo $row['electionID']; ?>"><?php echo htmlspecialchars($row['TypeElection']); ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <button type="submit" name="proclaim" class="btn btn-primary">Proclamer les résultats</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
