<?php
session_start();

include 'db_conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $electionID = intval($_POST['electionID']);
    $candidatID = intval($_POST['candidatID']);
    
    $USER_ID = $_SESSION['utilisateur']["utilisateurID"];

    $sql_check = "SELECT * FROM electeur WHERE utilisateurID=? AND electionID=?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("ii", $USER_ID, $electionID);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        session_destroy();
        header("Location: confirmation_erreur.php");
        exit();
    } else {
        $sql_insert_electeur = "INSERT INTO electeur (electionID, utilisateurID) VALUES (?, ?)";
        $stmt_insert_electeur = $conn->prepare($sql_insert_electeur);
        $stmt_insert_electeur->bind_param("ii", $electionID, $USER_ID);

        if ($stmt_insert_electeur->execute()) {
            // Insérer le vote dans la table votes
            $sql_insert_vote = "INSERT INTO votes (electionID, candidatID) VALUES (?, ?)";
            $stmt_insert_vote = $conn->prepare($sql_insert_vote);
            $stmt_insert_vote->bind_param("ii", $electionID, $candidatID);

            if ($stmt_insert_vote->execute()) {
                // Rediriger vers la page de confirmation
                header("Location: confirmation.php");
                exit();
            } else {
                echo "Erreur: " . $stmt_insert_vote->error;
            }
        } else {
            echo "Erreur: " . $stmt_insert_electeur->error;
        }
        // $sql_1 = "INSERT INTO electeur (electionID, utilisateurID) VALUES ($electionID, $USER_ID)";
        // if ($conn->query($sql_1) === TRUE) {
        //     $sql = "INSERT INTO votes (electionID, candidatID) VALUES ($electionID, $candidatID)";
        //     if ($conn->query($sql) === TRUE) {
        //         // Rediriger vers la page de confirmation
        //         header("Location: confirmation.php");
        //         exit();
        //     } else {
        //         echo "Erreur: " . $sql . "<br>" . $conn->error;
        //     }
        // }
    }
    // Fermer la connexion
    $stmt_check->close();
    $stmt_insert_electeur->close();
    $stmt_insert_vote->close();
    $conn->close();
} else {
    echo "Méthode de requête invalide.";
}
?>
