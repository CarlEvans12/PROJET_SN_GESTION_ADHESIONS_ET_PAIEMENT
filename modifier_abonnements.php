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

// Récupérer l'ID de l'abonnement à modifier
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    // Requête pour récupérer les données de l'abonnement
    $sql = "SELECT * FROM ABONNEMENT WHERE id_abonnement = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $abonnement = $result->fetch_assoc();
    } else {
        echo "Abonnement non trouvé.";
        exit;
    }
} else {
    echo "ID invalide.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Modifier un Abonnement</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f4f4f9;
    }

    .container {
      max-width: 600px;
      margin: 50px auto;
      padding: 20px;
      background: #ffffff;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      border-radius: 8px;
    }

    h1 {
      text-align: center;
      color: #1a746f;
    }

    form {
      display: flex;
      flex-direction: column;
    }

    label {
      margin: 10px 0 5px;
      font-weight: bold;
    }

    input[type="date"],
    input[type="text"],
    select {
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    button {
      padding: 10px;
      background: #1a746f;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-weight: bold;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    button:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
    }

    .message {
      margin-top: 20px;
      text-align: center;
      color: #333;
    }

    .error {
      color: red;
    }

    .success {
      color: green;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Modifier un Abonnement</h1>
    <form id="editAbonnementForm" method="post">
      <!-- Formulaire pour modifier un abonnement -->
      <label for="date_debut">Date de Début:</label>
      <input type="date" id="date_debut" name="date_debut" value="<?= htmlspecialchars($abonnement['date_debut']) ?>" required>

      <label for="date_fin">Date de Fin:</label>
      <input type="date" id="date_fin" name="date_fin" value="<?= htmlspecialchars($abonnement['date_fin']) ?>" required>

      <label for="description">Description:</label>
      <input type="text" id="description" name="description" value="<?= htmlspecialchars($abonnement['description']) ?>" required>

      <label for="type_abonnement">Type d'Abonnement:</label>
      <select id="type_abonnement" name="type_abonnement" required>
        <option value="mensuelle" <?= $abonnement['type_abonnement'] === 'mensuelle' ? 'selected' : '' ?>>Mensuelle</option>
        <option value="trimestrielle" <?= $abonnement['type_abonnement'] === 'trimestrielle' ? 'selected' : '' ?>>Trimestrielle</option>
        <option value="semestrielle" <?= $abonnement['type_abonnement'] === 'semestrielle' ? 'selected' : '' ?>>Semestrielle</option>
        <option value="annuelle" <?= $abonnement['type_abonnement'] === 'annuelle' ? 'selected' : '' ?>>Annuelle</option>
      </select>

      <label for="statut">Statut:</label>
      <select id="statut" name="statut" required>
        <option value="actif" <?= $abonnement['statut'] === 'actif' ? 'selected' : '' ?>>Actif</option>
        <option value="inactif" <?= $abonnement['statut'] === 'inactif' ? 'selected' : '' ?>>Inactif</option>
        <option value="annulé" <?= $abonnement['statut'] === 'annulé' ? 'selected' : '' ?>>Annulé</option>
      </select>

      <button type="submit">Modifier l'Abonnement</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // Récupérer les nouvelles valeurs du formulaire
      $date_debut = $_POST['date_debut'];
      $date_fin = $_POST['date_fin'];
      $description = $_POST['description'];
      $type_abonnement = $_POST['type_abonnement'];
      $statut = $_POST['statut'];

      // Requête pour mettre à jour les données de l'abonnement
      $update_sql = "UPDATE ABONNEMENT SET 
                      date_debut = ?, 
                      date_fin = ?, 
                      description = ?, 
                      type_abonnement = ?, 
                      statut = ? 
                    WHERE id_abonnement = ?";
      
      $stmt_update = $conn->prepare($update_sql);
      $stmt_update->bind_param("sssssi", $date_debut, $date_fin, $description, $type_abonnement, $statut, $id);

      if ($stmt_update->execute()) {
        echo "<script>alert('Modification réussie');</script>";
      } else {
        echo "<script>alert('Échec de la modification');</script>";
      }

      // Fermer la déclaration préparée
      $stmt_update->close();
    }
    ?>
  </div>
</body>
</html>
