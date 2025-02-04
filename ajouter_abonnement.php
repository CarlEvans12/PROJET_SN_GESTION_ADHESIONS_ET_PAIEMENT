<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "gestionabonnements";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Échec de la connexion à la base de données : " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Récupération des données du formulaire
  $date_debut = $_POST['date_debut'];
  $date_fin = $_POST['date_fin'];
  $description = $conn->real_escape_string($_POST['description']);
  $type_abonnement = $_POST['type_abonnement'];
  $statut = $_POST['statut'];
  $id_membre = $_POST['id_membre'];

  // Insertion dans la base de données
  $sql = "INSERT INTO ABONNEMENT (date_debut, date_fin, description, type_abonnement, statut, id_membre) 
          VALUES ('$date_debut', '$date_fin', '$description', '$type_abonnement', '$statut', '$id_membre')";

  if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Ajout réussi');</script>";
  } else {
    echo "<script>alert('Échec de l\'ajout');</script>";
  }

  // Fermer la connexion
  $conn->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ajouter un Abonnement</title>
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
    <h1>Ajouter un Abonnement</h1>
    <form id="addAbonnementForm" method="post">
      <!-- Informations pour la table `ABONNEMENT` -->
      <label for="date_debut">Date de Début:</label>
      <input type="date" id="date_debut" name="date_debut" required>

      <label for="date_fin">Date de Fin:</label>
      <input type="date" id="date_fin" name="date_fin" required>

      <label for="description">Description:</label>
      <input type="text" id="description" name="description" required>

      <label for="type_abonnement">Type d'Abonnement:</label>
      <select id="type_abonnement" name="type_abonnement" required>
        <option value="mensuelle">Mensuelle</option>
        <option value="trimestrielle">Trimestrielle</option>
        <option value="semestrielle">Semestrielle</option>
        <option value="annuelle">Annuelle</option>
      </select>

      <label for="statut">Statut:</label>
      <select id="statut" name="statut" required>
        <option value="actif">Actif</option>
        <option value="inactif">Inactif</option>
        <option value="annulé">Annulé</option>
      </select>

      <label for="id_membre">ID du Membre:</label>
      <input type="number" id="id_membre" name="id_membre" required>

      <button type="submit">Ajouter l'Abonnement</button>
    </form>
  </div>
</body>
</html>
