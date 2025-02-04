<?php

$host = "localhost";
$user = "root";
$password = "";
$dbname = "gestionabonnements";  // Base de données

// Connexion à la base de données
$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Échec de la connexion à la base de données : " . $conn->connect_error);
}

// Récupérer l'ID de la notification à supprimer
$id_notif = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Supprimer la notification de la base de données
$sql = "DELETE FROM notification WHERE id_notif = ?";

if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $id_notif);  // Lier l'ID de la notification à la requête
    if ($stmt->execute()) {
        echo "<script>alert('La notification a été supprimée avec succès.'); window.location.href = 'afficher_notifs.php';</script>";
    } else {
        echo "<script>alert('Erreur lors de la suppression de la notification.'); window.location.href = 'afficher_notifs.php';</script>";
    }
    $stmt->close();
} else {
    echo "<script>alert('Erreur dans la préparation de la requête.'); window.location.href = 'afficher_notifs.php';</script>";
}

$conn->close();

?>
