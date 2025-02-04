<?php

$host = "localhost";
$user = "root";
$password = "";
$dbname = "gestionabonnements";  // La base de données de gestion des abonnements

// Connexion à la base de données
$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Échec de la connexion à la base de données : " . $conn->connect_error);
}

// Récupérer l'ID de l'abonnement à supprimer
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Supprimer l'abonnement de la base de données
$sql = "DELETE FROM ABONNEMENT WHERE id_abonnement = ?";

if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $id);  // Lier l'ID de l'abonnement à la requête
    if ($stmt->execute()) {
        echo "<script>alert('L\'abonnement a été supprimé avec succès.'); window.location.href = 'afficher_abonnements.php';</script>";
    } else {
        echo "<script>alert('Erreur lors de la suppression de l\'abonnement.'); window.location.href = 'afficher_abonnements.php';</script>";
    }
    $stmt->close();
} else {
    echo "<script>alert('Erreur dans la préparation de la requête.'); window.location.href = 'afficher_abonnements.php';</script>";
}

$conn->close();
?>
