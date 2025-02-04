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

// Récupération du terme de recherche
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

// Requête SQL avec jointures et recherche
$sql = "SELECT h.id_historique, h.montant, h.date_paiement, h.statut, h.date_modification, 
               p.id_paiement, 
               m.nom_membre, m.prenom_membre
        FROM historique_paiement h
        INNER JOIN paiement p ON h.id_paiement = p.id_paiement
        INNER JOIN membre m ON p.id_membre = m.id_membre
        WHERE h.id_historique LIKE '%$search%' 
        OR h.montant LIKE '%$search%' 
        OR h.date_paiement LIKE '%$search%' 
        OR h.statut LIKE '%$search%' 
        OR m.nom_membre LIKE '%$search%' 
        OR m.prenom_membre LIKE '%$search%'";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Historique des Paiements</title>
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
    <h1>Historique des Paiements</h1>
  </div>

  <div class="container">
    <!-- Formulaire de recherche -->
    <form method="GET" action="" class="filters">
      <label for="search">Rechercher :</label>
      <input type="text" id="search" name="search" placeholder="ID, montant, statut, nom, prénom..." value="<?= htmlspecialchars($search) ?>">
      <button type="submit">Rechercher</button>
    </form>
    <!-- Tableau des historiques de paiement -->
    <table>
      <thead>
        <tr>
          <th>ID Historique</th>
          <th>Nom Membre</th>
          <th>Prénom Membre</th>
          <th>Montant</th>
          <th>Date Paiement</th>
          <th>Statut</th>
          <th>Date Modification</th>
          <th>ID Paiement</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result->num_rows > 0): ?>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= htmlspecialchars($row["id_historique"]) ?></td>
              <td><?= htmlspecialchars($row["nom_membre"]) ?></td>
              <td><?= htmlspecialchars($row["prenom_membre"]) ?></td>
              <td><?= htmlspecialchars($row["montant"]) ?></td>
              <td><?= htmlspecialchars($row["date_paiement"]) ?></td>
              <td><?= htmlspecialchars($row["statut"]) ?></td>
              <td><?= htmlspecialchars($row["date_modification"]) ?></td>
              <td><?= htmlspecialchars($row["id_paiement"]) ?></td>
              <td class="actions">
                <a href="supprimer_historique.php?id=<?= htmlspecialchars($row['id_historique']) ?>" class="delete" onclick="return confirm('Voulez-vous vraiment supprimer cet historique ?');">Supprimer</a>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="9" class="no-data">Aucun historique trouvé</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <?php $conn->close(); ?>
</body>
</html>