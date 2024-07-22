<?php
include 'db_conn.php';

// Récupérer l'electionID de l'élection municipale pour la Commune I
$sql_election = "SELECT electionID FROM election WHERE TypeElection='Commune I'";
$result_election = $conn->query($sql_election);

$validElection = false;  // Initialisation du drapeau de validation

if ($result_election->num_rows > 0) {
    $row_election = $result_election->fetch_assoc();
    $electionID = $row_election['electionID'];

    // Récupérer les dates de l'élection dans la table tour
    $sql_tour = "SELECT StartDate, EndDate FROM tour WHERE electionID=$electionID";
    $result_tour = $conn->query($sql_tour);

    if ($result_tour->num_rows > 0) {
        $row_tour = $result_tour->fetch_assoc();
        $startDate = $row_tour['StartDate'];
        $endDate = $row_tour['EndDate'];
        $currentDate = date('Y-m-d');

        // Vérifier si l'élection est en cours
        if ($currentDate >= $startDate && $currentDate <= $endDate) {
            $validElection = true;
        }
    }

    if ($validElection) {
        // Récupérer les candidatID assignés à cette élection municipale
        $sql_candidates = "SELECT candidatID FROM election_candidat WHERE electionID=$electionID";
        $result_candidates = $conn->query($sql_candidates);

        if ($result_candidates->num_rows > 0) {
            // Créer un tableau de candidatID
            $candidatIDs = [];
            while ($row_candidate = $result_candidates->fetch_assoc()) {
                $candidatIDs[] = $row_candidate['candidatID'];
            }
            // Convertir le tableau en une chaîne de caractères séparés par des virgules
            $candidatIDs_str = implode(",", $candidatIDs);

            // Récupérer les informations des candidats et de leurs partis
            $sql = "SELECT c.*, p.NomParti, p.photo AS photoParti, p.description AS descriptionParti
                    FROM candidat c
                    LEFT JOIN candidat_parti cp ON c.candidatID = cp.candidatID
                    LEFT JOIN parti p ON cp.partiID = p.partiID
                    WHERE c.candidatID IN ($candidatIDs_str)";
            $result = $conn->query($sql);
        } else {
            $result = null; // Pas de candidats assignés à cette élection municipale
        }
    }
} else {
    $result = null; // Pas d'élection de type "municipale" pour la Commune I trouvée
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vote</title>
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
        .candidate-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .candidate {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #ccc;
            padding: 10px 0;
            width: 100%;
            max-width: 500px;
            cursor: pointer;
        }
        .candidate:hover {
            background-color: #f1f1f1;
        }
        .candidate img {
            border-radius: 5px;
            margin-right: 20px;
        }
        .candidate-details {
            display: flex;
            align-items: center;
        }
        .candidate-info {
            margin-right: 20px;
        }
        .parti-details {
            margin-top: 10px;
        }
        .modal-dialog {
            max-width: 400px; /* Réduire la largeur du modal */
        }
    </style>
</head>
<body>
<div class="container">
    <h1 class="mt-5 text-center">Vote Municipale pour la Commune I</h1>
    <form action="submit_vote.php" method="post" id="voteForm">
        <input type="hidden" name="electionID" value="<?php echo isset($electionID) ? $electionID : ''; ?>">
        <input type="hidden" name="candidatID" id="candidatID">
        <?php if ($validElection): ?>
            <?php if ($result && $result->num_rows > 0): ?>
                <div class="mb-3 candidate-container">
                    <label class="form-label">Choisissez un candidat:</label>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <div class="candidate" data-candidatid="<?php echo $row['candidatID']; ?>">
                            <div class="candidate-details">
                                <img src="<?php echo $row['photo']; ?>" width="100" height="100" alt="Photo de <?php echo $row['Nom'] . ' ' . $row['Prenom']; ?>">
                                <div class="candidate-info">
                                    <h5><?php echo $row['Prenom']; ?></h5>
                                    <h5><?php echo $row['Nom']; ?></h5>
                                </div>
                            </div>
                            <div class="parti-details">
                                <?php if ($row['NomParti']): ?>
                                    <img src="<?php echo $row['photoParti']; ?>" width="50" height="50" alt="Logo de <?php echo $row['NomParti']; ?>">
                                    <p><?php echo $row['NomParti']; ?></p>
                                    <p><?php echo $row['descriptionParti']; ?></p>
                                <?php else: ?>
                                    <p>Indépendant</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div class="alert alert-info text-center">Aucun candidat trouvé pour l'élection de la Commune I.</div>
            <?php endif; ?>
        <?php else: ?>
            <div class="alert alert-danger text-center">
                <?php
                if ($result_tour->num_rows > 0) {
                    if ($currentDate < $startDate) {
                        echo "L'élection n'a pas encore commencé.";
                    } else if ($currentDate > $endDate) {
                        echo "L'élection est terminée.";
                    }
                } else {
                    echo "Aucune date de tour trouvée pour cette élection.";
                }
                ?>
            </div>
        <?php endif; ?>
    </form>
</div>

<!-- Modal de confirmation -->
<div class="modal fade" id="confirmVoteModal" tabindex="-1" aria-labelledby="confirmVoteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmVoteModalLabel">Confirmer votre vote</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir voter pour ce candidat ?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" id="confirmVoteButton">Confirmer</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var voteForm = document.getElementById('voteForm');
    var confirmVoteModal = new bootstrap.Modal(document.getElementById('confirmVoteModal'));
    var confirmVoteButton = document.getElementById('confirmVoteButton');
    var candidatIDInput = document.getElementById('candidatID');
    
    document.querySelectorAll('.candidate').forEach(function (candidate) {
        candidate.addEventListener('click', function () {
            var candidatID = this.getAttribute('data-candidatid');
            candidatIDInput.value = candidatID;
            confirmVoteModal.show();
        });
    });

    confirmVoteButton.addEventListener('click', function () {
        voteForm.submit();
    });
});
</script>
</body>
</html>
