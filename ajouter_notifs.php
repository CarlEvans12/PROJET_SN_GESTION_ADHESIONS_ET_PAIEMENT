<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "gestionabonnements";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Échec de la connexion à la base de données : " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Récupération des données du formulaire
  $titre = $conn->real_escape_string($_POST['titre']);
  $message = $conn->real_escape_string($_POST['message']);
  $date_envoie = $_POST['date_envoie'];
  $type = $_POST['type'];
  $statut = $_POST['statut'];
  $id_membre = $_POST['id_membre'];

  // Insertion dans la base de données
  $sql = "INSERT INTO notification (titre, message, date_envoie, type, statut, id_membre) 
          VALUES ('$titre', '$message', '$date_envoie', '$type', '$statut', '$id_membre')";

  if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Notification ajoutée avec succès');</script>";
  } else {
    echo "<script>alert('Erreur lors de l\'ajout de la notification');</script>";
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
  <title>Ajouter une Notification</title>
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
    textarea,
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
  </style>
</head>
<body>
  <div class="container">
    <h1>Ajouter une Notification</h1>
    <form id="addNotificationForm" method="post">
      <label for="titre">Titre :</label>
      <input type="text" id="titre" name="titre" required>

      <label for="message">Message :</label>
      <textarea id="message" name="message" rows="4" required></textarea>

      <label for="date_envoie">Date d'Envoi :</label>
      <input type="date" id="date_envoie" name="date_envoie" required>

      <label for="type">Type :</label>
      <select id="type" name="type" required>
        <option value="rappel">Rappel</option>
        <option value="information">Information</option>
        <option value="paiement">Paiement</option>
      </select>

      <label for="statut">Statut :</label>
      <select id="statut" name="statut" required>
        <option value="envoyee">Envoyée</option>
        <option value="lue">Lue</option>
      </select>

      <label for="id_membre">ID du Membre :</label>
      <input type="number" id="id_membre" name="id_membre" required>

      <button type="submit">Ajouter la Notification</button>
    </form>
  </div>
</body>
</html>
