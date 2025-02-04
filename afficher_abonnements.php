<?php
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

// Requête SQL avec recherche
$sql = "SELECT a.id_abonnement, a.date_debut, a.date_fin, a.description, a.type_abonnement, a.statut, m.nom_membre, m.prenom_membre
        FROM ABONNEMENT a
        JOIN MEMBRE m ON a.id_membre = m.id_membre
        WHERE a.date_debut LIKE '%$search%' 
        OR a.date_fin LIKE '%$search%' 
        OR a.description LIKE '%$search%' 
        OR a.type_abonnement LIKE '%$search%' 
        OR a.statut LIKE '%$search%'
        OR m.nom_membre LIKE '%$search%' 
        OR m.prenom_membre LIKE '%$search%'";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestion des Abonnements</title>
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

    .add-subscription-button {
      background-color: #004aad;
      color: white;
      padding: 8px 12px;
      border: none;
      border-radius: 5px;
      font-size: 1rem;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .add-subscription-button:hover {
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
    <h1>Gestion des Abonnements</h1>
  </div>

  <div class="container">
    <!-- Formulaire de recherche -->
    <form method="GET" action="" class="filters">
      <label for="search">Rechercher :</label>
      <input type="text" id="search" name="search" placeholder="Date début, Date fin, Description..." value="<?= htmlspecialchars($search) ?>">
      <button type="submit">Rechercher</button>
      <button type="button" onclick="window.location.href='ajouter_abonnement.php'" class="add-subscription-button">
        Ajouter Abonnement
      </button>
    </form>

    <!-- Tableau des abonnements -->
    <table>
      <thead>
        <tr>
        <th>Id abonnement</th>
          <th>Nom du Membre</th>
          <th>Prénom du Membre</th>
          <th>Date de Début</th>
          <th>Date de Fin</th>
          <th>Description</th>
          <th>Type</th>
          <th>Statut</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result->num_rows > 0): ?>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= htmlspecialchars($row["id_abonnement"]) ?></td>
              <td><?= htmlspecialchars($row["nom_membre"]) ?></td>
              <td><?= htmlspecialchars($row["prenom_membre"]) ?></td>
              <td><?= htmlspecialchars($row["date_debut"]) ?></td>
              <td><?= htmlspecialchars($row["date_fin"]) ?></td>
              <td><?= htmlspecialchars($row["description"]) ?></td>
              <td><?= htmlspecialchars($row["type_abonnement"]) ?></td>
              <td><?= htmlspecialchars($row["statut"]) ?></td>
              <td class="actions">
                <a href="modifier_abonnements.php?id=<?= htmlspecialchars($row['id_abonnement']) ?>" class="edit">Modifier</a>
                <a href="supprimer_abonnement.php?id=<?= htmlspecialchars($row['id_abonnement']) ?>" class="delete" onclick="return confirm('Voulez-vous vraiment supprimer cet abonnement ?');">Supprimer</a>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="8" class="no-data">Aucun abonnement trouvé</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <?php $conn->close(); ?>
</body>
</html>
