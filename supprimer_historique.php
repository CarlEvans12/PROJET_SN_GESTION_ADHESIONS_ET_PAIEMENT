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

// Récupérer l'ID de l'historique à supprimer
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Supprimer l'historique de paiement de la base de données
$sql = "DELETE FROM historique_paiement WHERE id_historique = ?";

if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $id);  // Lier l'ID de l'historique à la requête
    if ($stmt->execute()) {
        echo "<script>alert('L\'historique de paiement a été supprimé avec succès.'); window.location.href = 'afficher_historique.php';</script>";
    } else {
        echo "<script>alert('Erreur lors de la suppression de l\'historique de paiement.'); window.location.href = 'afficher_historique.php';</script>";
    }
    $stmt->close();
} else {
    echo "<script>alert('Erreur dans la préparation de la requête.'); window.location.href = 'afficher_historique_paiement.php';</script>";
}

$conn->close();
?>