<?php
include 'db_conn.php';

// Récupérer l'electionID et la question de l'élection de type "Referendum"
$sql_election = "SELECT electionID, ReferendumQuestion FROM election WHERE TypeElection = 'Referendum'";
$result_election = $conn->query($sql_election);

$validElection = false; // Initialisation du drapeau de validation

if ($result_election->num_rows > 0) {
    $row_election = $result_election->fetch_assoc();
    $electionID = $row_election['electionID'];
    $referendumQuestion = $row_election['ReferendumQuestion'];

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
        } else {
            $validElection = false;
            $message = ($currentDate < $startDate) ? "L'élection n'a pas encore commencé." : "L'élection est terminée.";
        }
    } else {
        $validElection = false;
        $message = "Pas de tour trouvé pour cette élection Referendum.";
    }
} else {
    $validElection = false;
    $message = "Pas d'élection de type 'Referendum' trouvée.";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vote Referendum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            width: 500px;
            margin-top: 50px;
            background-color: #fff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        h1, .question {
            text-align: center;
        }
        .btn {
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 16px;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-secondary {
            background-color: #F7230C;
            border: none;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
        }
        .alert {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Vote Referendum</h1>
        <?php if (isset($message)): ?>
            <div class="alert alert-info text-center"><?php echo $message; ?></div>
        <?php elseif ($validElection): ?>
            <p class="question"><?php echo $referendumQuestion; ?></p>
            <form action="submit_vote.php" method="post" id="voteForm">
                <input type="hidden" name="electionID" value="<?php echo $electionID; ?>">
                <input type="hidden" name="vote" id="vote">
                <div class="text-center">
                    <button type="button" class="btn btn-primary mx-2" data-vote="oui">Oui</button>
                    <button type="button" class="btn btn-secondary mx-2" data-vote="non">Non</button>
                </div>
            </form>
        <?php endif; ?>
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
                    <p>Êtes-vous sûr de vouloir voter <span id="voteChoice"></span> ?</p>
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
            var voteInput = document.getElementById('vote');
            var voteChoice = document.getElementById('voteChoice');

            document.querySelectorAll('button[data-vote]').forEach(function (button) {
                button.addEventListener('click', function () {
                    var vote = this.getAttribute('data-vote');
                    voteInput.value = vote;
                    voteChoice.textContent = vote;
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
