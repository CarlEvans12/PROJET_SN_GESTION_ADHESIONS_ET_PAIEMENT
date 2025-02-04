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

// Récupérer l'ID du membre à supprimer
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Supprimer le membre de la base de données
$sql = "DELETE FROM MEMBRE WHERE id_membre = ?";

if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $id);  // Lier l'ID du membre à la requête
    if ($stmt->execute()) {
        echo "<script>alert('Le membre a été supprimé avec succès.'); window.location.href = 'afficher_adherents.php';</script>";
    } else {
        echo "<script>alert('Erreur lors de la suppression du membre.'); window.location.href = 'afficher_adherents.php';</script>";
    }
    $stmt->close();
} else {
    echo "<script>alert('Erreur dans la préparation de la requête.'); window.location.href = 'afficher_membres.php';</script>";
}

$conn->close();
?>
