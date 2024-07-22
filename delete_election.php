<?php
include 'db_conn.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sécuriser l'ID en utilisant intval
    $sql = "DELETE FROM election WHERE electionID=$id";

    if ($conn->query($sql) === TRUE) {
        $message = "election supprimé avec succès.";
    } else {
        $message = "Erreur : " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
} else {
    $message = "ID de election non spécifié.";
}

// Redirection après la suppression
header("Location: Liste_election.php?message=" . urlencode($message));
exit();
?>