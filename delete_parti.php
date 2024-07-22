<?php
include 'db_conn.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sécuriser l'ID en utilisant intval
    $sql = "DELETE FROM parti WHERE partiID=$id";

    if ($conn->query($sql) === TRUE) {
        $message = "parti supprimé avec succès.";
    } else {
        $message = "Erreur : " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
} else {
    $message = "ID de parti non spécifié.";
}

// Redirection après la suppression
header("Location: Parti.php?message=" . urlencode($message));
exit();
?>
