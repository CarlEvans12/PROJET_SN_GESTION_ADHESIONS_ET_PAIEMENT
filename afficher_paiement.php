<?php
// Connexion à la base de données
$host = "localhost";
$user = "root";
$password = "";
$dbname = "gestionabonnements";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Échec de la connexion à la base de données : " . $conn->connect_error);
}

// Récupération du terme de recherche
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

// Requête SQL avec jointures et recherche
$sql = "SELECT p.id_paiement, p.montant, p.date_paiement, p.methode_paiement, p.reference_transaction, p.statut, 
               m.nom_membre, m.prenom_membre, 
               a.description AS description_abonnement
        FROM paiement p
        INNER JOIN membre m ON p.id_membre = m.id_membre
        INNER JOIN abonnement a ON p.id_abonnement = a.id_abonnement
        WHERE p.reference_transaction LIKE '%$search%' 
        OR p.methode_paiement LIKE '%$search%' 
        OR p.statut LIKE '%$search%' 
        OR m.nom_membre LIKE '%$search%' 
        OR m.prenom_membre LIKE '%$search%' 
        OR a.description LIKE '%$search%'";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestion des Paiements</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f4f4f9;
      color: #333;
    }

    .header {
      background: #1a746f;
      color: white;
      padding: 20px;
      text-align: center;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .container {
      max-width: 1200px;
      margin: 20px auto;
      padding: 20px;
      background: #ffffff;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      border-radius: 10px;
    }

    .filters {
      margin-bottom: 20px;
      display: flex;
      gap: 10px;
      flex-wrap: wrap;
      align-items: center;
    }

    .filters label {
      font-weight: bold;
      color: #555;
    }

    .filters input, .filters button {
      padding: 8px 12px;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 1rem;
    }

    .filters button {
      background-color: #1a746f;
      color: white;
      border: none;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .filters button:hover {
      background-color: #218838;
    }

    .add-payment-button {
      background-color: #004aad;
      color: white;
      padding: 8px 12px;
      border: none;
      border-radius: 5px;
      font-size: 1rem;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .add-payment-button:hover {
      background-color: #00387d;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th, td {
      padding: 12px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    th {
      background: linear-gradient(135deg, #1a746f, #8ee9e3);
      color: white;
      font-weight: bold;
    }

    tr:hover {
      background-color: #f1f1f1;
    }

    .actions {
      display: flex;
      gap: 10px;
    }

    .actions a {
      padding: 6px 12px;
      text-decoration: none;
      color: white;
      border-radius: 5px;
      font-size: 0.9rem;
      transition: background-color 0.3s ease;
    }
    .actions .delete {
      background-color: #c82333;
    }
    .actions .edit {
      background-color: #1a746f;
    }

    .actions .edit:hover, .actions .delete:hover {
      background-color: #8ee9e3;
    }

    .no-data {
      text-align: center;
      color: #777;
      padding: 20px;
    }
  </style>
</head>
<body>
  <div class="header">
    <h1>Gestion des Paiements</h1>
  </div>

  <div class="container">
    <!-- Formulaire de recherche -->
    <form method="GET" action="" class="filters">
      <label for="search">Rechercher :</label>
      <input type="text" id="search" name="search" placeholder="Référence, méthode, statut, nom, prénom, description..." value="<?= htmlspecialchars($search) ?>">
      <button type="submit">Rechercher</button>
      <button type="button" onclick="window.location.href='ajouter_paiement.php'" class="add-payment-button">
        Ajouter Paiement
      </button>
    </form>
    <!-- Tableau des paiements -->
    <table>
      <thead>
        <tr>
          <th>ID Paiement</th>
          <th>Nom Membre</th>
          <th>Prénom Membre</th>
          <th>Montant</th>
          <th>Date Paiement</th>
          <th>Méthode</th>
          <th>Référence</th>
          <th>Statut</th>
          <th>Description Abonnement</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result->num_rows > 0): ?>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= htmlspecialchars($row["id_paiement"]) ?></td>
              <td><?= htmlspecialchars($row["nom_membre"]) ?></td>
              <td><?= htmlspecialchars($row["prenom_membre"]) ?></td>
              <td><?= htmlspecialchars($row["montant"]) ?></td>
              <td><?= htmlspecialchars($row["date_paiement"]) ?></td>
              <td><?= htmlspecialchars($row["methode_paiement"]) ?></td>
              <td><?= htmlspecialchars($row["reference_transaction"]) ?></td>
              <td><?= htmlspecialchars($row["statut"]) ?></td>
              <td><?= htmlspecialchars($row["description_abonnement"]) ?></td>
              <td class="actions">
                <a href="modifier_paiement.php?id=<?= htmlspecialchars($row['id_paiement']) ?>" class="edit">Modifier</a>
                <a href="supprimer_paiement.php?id=<?= htmlspecialchars($row['id_paiement']) ?>" class="delete" onclick="return confirm('Voulez-vous vraiment supprimer ce paiement ?');">Supprimer</a>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="10" class="no-data">Aucun paiement trouvé</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <?php $conn->close(); ?>
</body>
</html>