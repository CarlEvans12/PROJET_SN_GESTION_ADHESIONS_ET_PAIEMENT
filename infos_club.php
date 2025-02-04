<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "gestionabonnements";

// Connexion à la base de données
$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Échec de la connexion à la base de données : " . $conn->connect_error);
}

// Requête pour récupérer les données récapitulatives
$sql_membres = "SELECT COUNT(*) AS total_membres FROM membre";
$sql_abonnements = "SELECT COUNT(*) AS total_abonnements, 
                           SUM(CASE WHEN statut = 'actif' THEN 1 ELSE 0 END) AS abonnements_actifs,
                           SUM(CASE WHEN statut = 'inactif' THEN 1 ELSE 0 END) AS abonnements_inactifs
                    FROM abonnement";
$sql_paiements = "SELECT COUNT(*) AS total_paiements, 
                         SUM(CASE WHEN statut = 'valide' THEN 1 ELSE 0 END) AS paiements_valides,
                         SUM(CASE WHEN statut = 'en_attente' THEN 1 ELSE 0 END) AS paiements_en_attente
                  FROM paiement";
$sql_historique = "SELECT COUNT(*) AS total_historique FROM historique_paiement";

// Exécution des requêtes
$result_membres = $conn->query($sql_membres);
$result_abonnements = $conn->query($sql_abonnements);
$result_paiements = $conn->query($sql_paiements);
$result_historique = $conn->query($sql_historique);

// Récupération des résultats
$total_membres = $result_membres->fetch_assoc()['total_membres'];
$abonnements = $result_abonnements->fetch_assoc();
$paiements = $result_paiements->fetch_assoc();
$total_historique = $result_historique->fetch_assoc()['total_historique'];

// Fermer la connexion
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Récapitulatif des Données</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f4f4f9;
      color: #333;
    }

    .container {
      max-width: 1200px;
      margin: 50px auto;
      padding: 20px;
      background: #ffffff;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      border-radius: 10px;
    }

    h1 {
      text-align: center;
      color: #1a746f;
    }

    .stats {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      margin-top: 20px;
    }

    .stat-box {
      flex: 1;
      padding: 20px;
      background: #f9f9f9;
      border: 1px solid #ddd;
      border-radius: 8px;
      text-align: center;
    }

    .stat-box h2 {
      margin: 0;
      font-size: 1.5rem;
      color: #1a746f;
    }

    .stat-box p {
      margin: 10px 0 0;
      font-size: 1.2rem;
      color: #555;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Récapitulatif des Données</h1>
    <div class="stats">
      <!-- Membres -->
      <div class="stat-box">
        <h2>Total Membres :</h2>
        <p><?= $total_membres ?></p>
      </div>

      <!-- Abonnements -->
      <div class="stat-box">
        <h2>Abonnements :</h2>
        <p>Actifs : <?= $abonnements['abonnements_actifs'] ?></p>
        <p>Inactifs : <?= $abonnements['abonnements_inactifs'] ?></p>
        <p>Total : <?= $abonnements['total_abonnements'] ?></p>
      </div>

      <!-- Paiements -->
      <div class="stat-box">
        <h2>Paiements :</h2>
        <p>Validés : <?= $paiements['paiements_valides'] ?></p>
        <p>En attente : <?= $paiements['paiements_en_attente'] ?></p>
        <p>Total : <?= $paiements['total_paiements'] ?></p>
      </div>

      <!-- Historique des Paiements -->
      <div class="stat-box">
        <h2>Historique des Paiements :</h2>
        <p>Total : <?= $total_historique ?></p>
      </div>
    </div>
  </div>
</body>
</html>