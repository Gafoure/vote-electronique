<?php
include 'db_conn.php';

if (!isset($_GET['electionID'])) {
    // Si aucun electionID n'est fourni, afficher une liste des élections
    $sql_elections = "SELECT electionID, TypeElection FROM election";
    $result_elections = $conn->query($sql_elections);

    echo "<!doctype html>
    <html lang='fr'>
    <head>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <title>Sélectionnez une élection</title>
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css' rel='stylesheet'>
        <style>
            body {
                background-color: #f8f9fa;
            }
            .container {
                width: 500px;
                margin-top: 20px;
                background-color: #fff;
                padding: 40px;   
                border-radius: 20px;
                box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.1);
            }
            .election-list {
                list-style: none;
                padding: 0;
            }
            .election-list li {
                margin-bottom: 20px;  /*espace entre les colonnes*/
            }
            .election-list a {
                display: block;
                padding: 15px;
                background-color: #007bff;
                color: #fff;
                text-decoration: none;
                border-radius: 15px;
                transition: background-color 0.3s ease;
            }
            .election-list a:hover {
                background-color: #0056b3;
            }
        </style>
    </head>
    <body>
    <div class='container'>
        <h1 class='mt-5 text-center'>Sélectionnez une élection</h1>
        <ul class='election-list'>";
    while ($row = $result_elections->fetch_assoc()) {
        echo "<li><a href='results.php?electionID=" . $row['electionID'] . "'>" . htmlspecialchars($row['TypeElection']) . "</a></li>";
    }
    echo "</ul>
    </div>
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js'></script>
    </body>
    </html>";
    exit();
}

$electionID = intval($_GET['electionID']);

// Récupérer le type d'élection et si les résultats ont été proclamés
$sql_election = "SELECT TypeElection, resultsProclaimed FROM election WHERE electionID = $electionID";
$result_election = $conn->query($sql_election);

if ($result_election->num_rows > 0) {
    $row_election = $result_election->fetch_assoc();
    $typeElection = $row_election['TypeElection'];
    $resultsProclaimed = $row_election['resultsProclaimed'];
} else {
    echo "<p>Élection non trouvée. ElectionID: $electionID</p>";
    exit();
}

// Si c'est un référendum, afficher les résultats du référendum
if ($typeElection === 'Referendum') {
    // Récupérer le nombre de votes pour "Oui" et "Non"
    $sql_referendum_results = "
        SELECT voteOption, COUNT(voteID) AS votes
        FROM votes
        WHERE electionID = $electionID
        GROUP BY voteOption";
    $result_referendum = $conn->query($sql_referendum_results);

    if ($result_referendum->num_rows > 0) {
        $results = [];
        while ($row = $result_referendum->fetch_assoc()) {
            $results[$row['voteOption']] = $row['votes'];
        }
        $votesOui = isset($results['oui']) ? $results['oui'] : 0;
        $votesNon = isset($results['non']) ? $results['non'] : 0;
        $totalVotes = $votesOui + $votesNon;
        $percentOui = $totalVotes > 0 ? round(($votesOui / $totalVotes) * 100, 2) : 0;
        $percentNon = $totalVotes > 0 ? round(($votesNon / $totalVotes) * 100, 2) : 0;
    } else {
        $votesOui = $votesNon = $percentOui = $percentNon = 0;
    }

    echo "<!doctype html>
    <html lang='fr'>
    <head>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <title>Résultats du référendum</title>
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css' rel='stylesheet'>
        <style>
            body {
                background-color: #f8f9fa;
            }
            .container {
                margin-top: 20px;
                background-color: #fff;
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            }
            .progress {
                height: 30px;
                border-radius: 15px;
                overflow: hidden;
                background-color: #e9ecef;
            }
            .progress-bar {
                height: 100%;
                text-align: center;
                line-height: 30px;
                color: #fff;
            }
            .progress-bar-oui {
                background-color: #007bff;
            }
            .progress-bar-non {
                background-color: #dc3545;
            }
        </style>
    </head>
    <body>
    <div class='container'>
        <h1 class='mt-5 text-center'>Résultats du référendum</h1>
        <div class='mt-5'>
            <h3>Oui: $votesOui voix ($percentOui%)</h3>
            <div class='progress'>
                <div class='progress-bar progress-bar-oui' role='progressbar' style='width: $percentOui%;' aria-valuenow='$percentOui' aria-valuemin='0' aria-valuemax='100'>$percentOui%</div>
            </div>
        </div>
        <div class='mt-5'>
            <h3>Non: $votesNon voix ($percentNon%)</h3>
            <div class='progress'>
                <div class='progress-bar progress-bar-non' role='progressbar' style='width: $percentNon%;' aria-valuenow='$percentNon' aria-valuemin='0' aria-valuemax='100'>$percentNon%</div>
            </div>
        </div>
    </div>
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js'></script>
    </body>
    </html>";
    exit();
}

// Récupérer les informations des candidats et le nombre de votes qu'ils ont reçus
$sql = "
    SELECT c.candidatID, c.Nom, c.Prenom, c.photo, COUNT(v.voteID) AS votes
    FROM candidat c
    LEFT JOIN votes v ON c.candidatID = v.candidatID AND v.electionID = $electionID
    WHERE c.candidatID IN (SELECT candidatID FROM election_candidat WHERE electionID = $electionID)
    GROUP BY c.candidatID, c.Nom, c.Prenom, c.photo
    ORDER BY votes DESC";

$result = $conn->query($sql);

if (!$result) {
    echo "<p>Erreur de requête : " . $conn->error . "</p>";
    exit();
}

// Récupérer le nombre total de votes pour l'élection
$sql_total_votes = "SELECT COUNT(voteID) AS totalVotes FROM votes WHERE electionID = $electionID";
$result_total_votes = $conn->query($sql_total_votes);
$totalVotes = $result_total_votes->fetch_assoc()['totalVotes'];

if ($totalVotes === null) {
    $totalVotes = 0;
}

$conn->close();
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1'>
    <title>Résultats de l'élection</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 20px;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);   
        }
        .candidate-card {
            display: flex;
            align-items: center;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .candidate-photo {
            width: 100px;
            height: 100px;
            margin-right: 20px;
        }
        .candidate-info {
            flex: 1;
        }
        .candidate-info h4 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }
        .candidate-info p {
            margin: 5px 0;
            font-size: 20px;
        }
        .progress {
            height: 30px;
            border-radius: 15px;
            overflow: hidden;
            background-color: #e9ecef;
        }
        .progress-bar {
            height: 100%;
            text-align: center;
            line-height: 30px;
            color: #fff;
            background-color: #007bff;
        }
        
    </style>
</head>
<body>
<div class="container">
    <h1 class="mt-5 text-center">Résultats de l'élection <?php echo htmlspecialchars($typeElection); ?></h1>
    <?php if ($result->num_rows > 0): ?>
        <?php 
        $candidates = [];
        while ($row = $result->fetch_assoc()) {
            $candidates[] = $row;
        }

        if ($resultsProclaimed): ?>
            <h2 class="text-center">Les gagnants</h2>
            <?php 
            usort($candidates, function ($a, $b) {
                return $b['votes'] - $a['votes'];
            });
            for ($i = 0; $i < min(2, count($candidates)); $i++): ?>
                <div class="candidate-card">
                    <img src="<?php echo htmlspecialchars($candidates[$i]['photo']); ?>" class="candidate-photo" alt="Photo de <?php echo htmlspecialchars($candidates[$i]['Nom'] . ' ' . $candidates[$i]['Prenom']); ?>">
                    <div class="candidate-info">
                        <h4><?php echo htmlspecialchars($candidates[$i]['Nom']) . ' ' . htmlspecialchars($candidates[$i]['Prenom']); ?></h4>
                        <p><?php echo $candidates[$i]['votes']; ?> voix</p>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: <?php echo $totalVotes > 0 ? round(($candidates[$i]['votes'] / $totalVotes) * 100, 2) : 0; ?>%;" aria-valuenow="<?php echo $totalVotes > 0 ? round(($candidates[$i]['votes'] / $totalVotes) * 100, 2) : 0; ?>" aria-valuemin="0" aria-valuemax="100">
                                <?php echo $totalVotes > 0 ? round(($candidates[$i]['votes'] / $totalVotes) * 100, 2) : 0; ?>%
                            </div>
                        </div>
                    </div>
                </div>
            <?php endfor; ?>
        <?php else: ?>
            <?php foreach ($candidates as $candidate): ?>
                <div class="candidate-card">
                    <img src="<?php echo htmlspecialchars($candidate['photo']); ?>" class="candidate-photo" alt="Photo de <?php echo htmlspecialchars($candidate['Nom'] . ' ' . $candidate['Prenom']); ?>">
                    <div class="candidate-info">
                        <h4><?php echo htmlspecialchars($candidate['Nom']) . ' ' . htmlspecialchars($candidate['Prenom']); ?></h4>
                        <p><?php echo $candidate['votes']; ?> voix</p>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: <?php echo $totalVotes > 0 ? round(($candidate['votes'] / $totalVotes) * 100, 2) : 0; ?>%;" aria-valuenow="<?php echo $totalVotes > 0 ? round(($candidate['votes'] / $totalVotes) * 100, 2) : 0; ?>" aria-valuemin="0" aria-valuemax="100">
                                <?php echo $totalVotes > 0 ? round(($candidate['votes'] / $totalVotes) * 100, 2) : 0; ?>%
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    <?php else: ?>
        <p class="text-center">Aucun résultat disponible.</p>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js'></script>
</body>
</html>
