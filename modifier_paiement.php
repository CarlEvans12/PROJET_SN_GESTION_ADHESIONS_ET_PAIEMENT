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

// Récupérer l'ID du paiement à modifier
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    // Requête pour récupérer les données du paiement
    $sql = "SELECT * FROM paiement WHERE id_paiement = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $paiement = $result->fetch_assoc();
    } else {
        echo "Paiement non trouvé.";
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
  <title>Modifier un Paiement</title>
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

    input[type="text"],
    input[type="number"],
    input[type="date"],
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
    <h1>Modifier un Paiement</h1>
    <form id="editPaiementForm" method="post">
      <!-- Formulaire pour modifier un paiement -->
      <label for="montant">Montant :</label>
      <input type="number" id="montant" name="montant" step="0.01" value="<?= htmlspecialchars($paiement['montant']) ?>" required>

      <label for="date_paiement">Date de Paiement :</label>
      <input type="date" id="date_paiement" name="date_paiement" value="<?= htmlspecialchars($paiement['date_paiement']) ?>" required>

      <label for="methode_paiement">Méthode de Paiement :</label>
      <select id="methode_paiement" name="methode_paiement" required>
        <option value="Carte" <?= $paiement['methode_paiement'] === 'Carte' ? 'selected' : '' ?>>Carte</option>
        <option value="Virement" <?= $paiement['methode_paiement'] === 'Virement' ? 'selected' : '' ?>>Virement</option>
        <option value="Espèces" <?= $paiement['methode_paiement'] === 'Espèces' ? 'selected' : '' ?>>Espèces</option>
      </select>

      <label for="reference_transaction">Référence de Transaction :</label>
      <input type="text" id="reference_transaction" name="reference_transaction" value="<?= htmlspecialchars($paiement['reference_transaction']) ?>" required>

      <label for="statut">Statut :</label>
      <select id="statut" name="statut" required>
        <option value="en_attente" <?= $paiement['statut'] === 'en_attente' ? 'selected' : '' ?>>En attente</option>
        <option value="valide" <?= $paiement['statut'] === 'valide' ? 'selected' : '' ?>>Validé</option>
        <option value="refus" <?= $paiement['statut'] === 'refus' ? 'selected' : '' ?>>Refusé</option>
      </select>

      <label for="id_abonnement">ID Abonnement :</label>
      <input type="number" id="id_abonnement" name="id_abonnement" value="<?= htmlspecialchars($paiement['id_abonnement']) ?>" required>

      <label for="id_membre">ID Membre :</label>
      <input type="number" id="id_membre" name="id_membre" value="<?= htmlspecialchars($paiement['id_membre']) ?>" required>

      <button type="submit">Modifier le Paiement</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // Récupérer les nouvelles valeurs du formulaire
      $montant = $_POST['montant'];
      $date_paiement = $_POST['date_paiement'];
      $methode_paiement = $_POST['methode_paiement'];
      $reference_transaction = $_POST['reference_transaction'];
      $statut = $_POST['statut'];
      $id_abonnement = $_POST['id_abonnement'];
      $id_membre = $_POST['id_membre'];

      // Requête pour mettre à jour les données du paiement
      $update_sql = "UPDATE paiement SET 
                      montant = ?, 
                      date_paiement = ?, 
                      methode_paiement = ?, 
                      reference_transaction = ?, 
                      statut = ?, 
                      id_abonnement = ?, 
                      id_membre = ? 
                    WHERE id_paiement = ?";
      
      $stmt_update = $conn->prepare($update_sql);
      $stmt_update->bind_param("dssssiii", $montant, $date_paiement, $methode_paiement, $reference_transaction, $statut, $id_abonnement, $id_membre, $id);

      if ($stmt_update->execute()) {
        echo "<script>alert('Paiement modifié avec succès');</script>";
      } else {
        echo "<script>alert('Erreur lors de la modification du paiement');</script>";
      }

      // Fermer la déclaration préparée
      $stmt_update->close();
    }
    ?>
  </div>
</body>
</html>