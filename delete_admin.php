<?php
include 'db_conn.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sécuriser l'ID en utilisant intval
    $sql = "DELETE FROM admin WHERE adminID=$id";

    if ($conn->query($sql) === TRUE) {
        $message = "admin supprimé avec succès.";
    } else {
        $message = "Erreur : " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
} else {
    $message = "ID de admin non spécifié.";
}

// Redirection après la suppression
header("Location: Liste_Admin.php?message=" . urlencode($message));
exit();
?>