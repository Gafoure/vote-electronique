<?php
include 'db_conn.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sécuriser l'ID en utilisant intval
    $sql = "DELETE FROM utilisateur WHERE utilisateurID=$id";

    if ($conn->query($sql) === TRUE) {
        $message = "electeur supprimé avec succès.";
    } else {
        $message = "Erreur : " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
} else {
    $message = "ID de candidat non spécifié.";
}

// Redirection après la suppression
header("Location: Liste_electeur.php?message=" . urlencode($message));
exit();
?>