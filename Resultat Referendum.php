<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root"; 
$password = "";
$dbname = "projet";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Récupérer le nombre de votes "oui"
$sqlOui = "SELECT reponse_oui FROM election_referendum";
$resultOui = $conn->query($sqlOui);
$rowOui = $resultOui->fetch_assoc();
$ouiCount = $rowOui['reponse_oui'];
// Récupérer le nombre de votes "non"   
$sqlnon = "SELECT reponse_non FROM election_referendum";
$resultnon = $conn->query($sqlnon);
$rownon = $resultnon->fetch_assoc();
$nonCount = $rownon['reponse_non'];

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Résultats Election Referendum</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            max-width: 500px;
            width: 100%;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .result-container {
            margin-top: 20px;
        }

        .result {
            margin-bottom: 10px;
        }

        .result-label {
            font-weight: bold;
        }

        .result-value {
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Résultats Election Referendum</h2>
        <div class="result-container">
            <div class="result">
                <span class="result-label">Nombre de votes pour "OUI" :</span>
                <span class="result-value"><?php echo $ouiCount; ?></span>
            </div>
            <div class="result">
                <span class="result-label">Nombre de votes pour "NON" :</span>
                <span class="result-value"><?php echo $nonCount; ?></span>
            </div>
        </div>
    </div>
</body>
</html>
