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

// Récupérer l'ID du membre à modifier
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    // Requête pour récupérer les données du membre
    $sql = "SELECT * FROM MEMBRE WHERE id_membre = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $membre = $result->fetch_assoc();
    } else {
        echo "Membre non trouvé.";
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
  <title>Modifier un Adhérent</title>
  <style>
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
    input[type="date"],
    input[type="tel"],
    input[type="email"],
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
  </style>  </style>
</head>
<body>
  <div class="container">
  <h1>Modifier un Adhérent</h1>
  <form id="editMembreForm" method="post">
    <!-- Formulaire pour modifier un membre -->
    <label for="nom">Nom:</label>
    <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($membre['nom_membre']) ?>" required>

    <label for="prenom">Prénom:</label>
    <input type="text" id="prenom" name="prenom" value="<?= htmlspecialchars($membre['prenom_membre']) ?>" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" value="<?= htmlspecialchars($membre['email_membre']) ?>" required>

    <label for="telephone">Téléphone:</label>
    <input type="text" id="telephone" name="telephone" value="<?= htmlspecialchars($membre['telephone']) ?>" required>

    <label for="date_naissance">Date de Naissance:</label>
    <input type="date" id="date_naissance" name="date_naissance" value="<?= htmlspecialchars($membre['date_naissance']) ?>" required>

    <label for="date_inscription">Date d'Inscription:</label>
    <input type="date" id="date_inscription" name="date_inscription" value="<?= htmlspecialchars($membre['date_inscription']) ?>" required>

    <label for="statut">Statut:</label>
    <select id="statut" name="statut">
      <option value="1" <?= $membre['statut'] ? 'selected' : '' ?>>Actif</option>
      <option value="0" <?= !$membre['statut'] ? 'selected' : '' ?>>Inactif</option>
    </select>
    <button type="submit">Modifier l'Adhérent</button>
  </form>
  <?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Récupérer les nouvelles valeurs du formulaire
  $nom = $_POST['nom'];
  $prenom = $_POST['prenom'];
  $email = $_POST['email'];
  $telephone = $_POST['telephone'];
  $date_naissance = $_POST['date_naissance'];
  $date_inscription = $_POST['date_inscription'];
  $statut = $_POST['statut'];

  // Requête pour mettre à jour les données du membre
  $update_sql = "UPDATE MEMBRE SET 
                  nom_membre = ?, 
                  prenom_membre = ?, 
                  email_membre = ?, 
                  telephone = ?, 
                  date_naissance = ?, 
                  date_inscription = ?, 
                  statut = ? 
                WHERE id_membre = ?";
  
  $stmt_update = $conn->prepare($update_sql);
  $stmt_update->bind_param("ssssssii", $nom, $prenom, $email, $telephone, $date_naissance, $date_inscription, $statut, $id);

  if ($stmt_update->execute()) {
    echo "<script>alert('Modification reussie');</script>";
  } else {
    echo "<script>alert('Echec');</script>";
  }

  // Fermer la déclaration préparée
  $stmt_update->close();
}

?>

  </div>
</body>
</html>
