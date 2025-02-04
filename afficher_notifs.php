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

// Définition du charset UTF-8 pour l'encodage des accents
$conn->set_charset("utf8mb4");

// Récupération du terme de recherche
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

// Requête SQL avec recherche
$sql = "SELECT n.id_notif, n.titre, n.message, n.date_envoie, n.type, n.statut, 
               m.nom_membre, m.prenom_membre
        FROM notification n
        INNER JOIN membre m ON n.id_membre = m.id_membre
        WHERE n.titre LIKE '%$search%' 
        OR n.message LIKE '%$search%' 
        OR n.type LIKE '%$search%' 
        OR n.statut LIKE '%$search%' 
        OR m.nom_membre LIKE '%$search%' 
        OR m.prenom_membre LIKE '%$search%'";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestion des Notifications</title>
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
    }
    .filters label {
      font-weight: bold;
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
    }
    tr:hover {
      background-color: #f1f1f1;
    }
    .status-icon {
      font-size: 1.2rem;
      font-weight: bold;
    }
    .status-sent {
      color: green;
    }
    .status-read {
      color: blue;
    }
    .actions a {
      padding: 6px 12px;
      text-decoration: none;
      color: white;
      border-radius: 5px;
      font-size: 0.9rem;
    }
    .actions .mark-read {
      background-color: #218838;
    }
    .actions .delete {
      background-color: #c82333;
    }
    .actions .mark-read:hover, .actions .delete:hover {
      opacity: 0.8;
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
    <h1>Gestion des Notifications</h1>
  </div>

  <div class="container">
    <!-- Formulaire de recherche -->
    <form method="GET" action="" class="filters">
      <label for="search">Rechercher :</label>
      <input type="text" id="search" name="search" placeholder="Titre, message, type, statut..." value="<?= htmlspecialchars($search) ?>">
      <button type="submit">Rechercher</button>
      <button type="button" onclick="window.location.href='ajouter_notifs.php'" class="add-student-button">
        Ajouter
      </button>
    </form>
    <!-- Tableau des notifications -->
    <table>
      <thead>
        <tr>
          <th>ID Notification</th>
          <th>Nom Membre</th>
          <th>Prénom Membre</th>
          <th>Titre</th>
          <th>Message</th>
          <th>Date</th>
          <th>Type</th>
          <th>Statut</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result->num_rows > 0): ?>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= htmlspecialchars($row["id_notif"]) ?></td>
              <td><?= htmlspecialchars($row["nom_membre"]) ?></td>
              <td><?= htmlspecialchars($row["prenom_membre"]) ?></td>
              <td><?= htmlspecialchars($row["titre"]) ?></td>
              <td><?= htmlspecialchars($row["message"]) ?></td>
              <td><?= htmlspecialchars($row["date_envoie"]) ?></td>
              <td><?= htmlspecialchars($row["type"]) ?></td>
              <td>
                <?php if ($row["statut"] == "envoyee"): ?>
                  <span class="status-icon status-sent">⬆️</span> Envoyée
                <?php else: ?>
                  <span class="status-icon status-read">⬇️</span> Lue
                <?php endif; ?>
              </td>
              <td class="actions">
                <a href="supprimer_notifs.php?id=<?= htmlspecialchars($row['id_notif']) ?>" class="delete" onclick="return confirm('Voulez-vous vraiment supprimer cette notification ?');">Supprimer</a>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="9" class="no-data">Aucune notification trouvée</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <?php $conn->close(); ?>
</body>
</html>
