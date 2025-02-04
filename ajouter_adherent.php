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
  $nom_membre = $conn->real_escape_string($_POST['nom_membre']);
  $prenom_membre = $conn->real_escape_string($_POST['prenom_membre']);
  $email_membre = $conn->real_escape_string($_POST['email_membre']);
  $motDePasse = $conn->real_escape_string($_POST['motDePasse']);
    $telephone = $conn->real_escape_string($_POST['telephone']);
  $date_naissance = $_POST['date_naissance'];
  $date_inscription = $_POST['date_inscription'];
  $statut = $_POST['statut'];

  // Insertion dans la base de données
  $sql = "INSERT INTO MEMBRE (nom_membre, prenom_membre, email_membre, motDePasse, telephone, date_naissance, date_inscription, statut) 
          VALUES ('$nom_membre', '$prenom_membre', '$email_membre', '$motDePasse', '$telephone', '$date_naissance', '$date_inscription', '$statut')";

  if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Ajout reussie');</script>";
  } else {
    echo "<script>alert('Echec de l'ajout');</script>";
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
  <title>Ajouter un Étudiant</title>
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
  </style>
</head>
<body>
  <div class="container">
  <h1>Ajouter un Adhérent</h1>
<form id="addMembreForm" method="post">
  <!-- Informations pour la table `membre` -->
  <label for="nom_membre">Nom :</label>
  <input type="text" id="nom_membre" name="nom_membre" required>

  <label for="prenom_membre">Prénom :</label>
  <input type="text" id="prenom_membre" name="prenom_membre" required>

  <label for="email_membre">Email :</label>
  <input type="email" id="email_membre" name="email_membre" required>

  <label for="motDePasse">Mot de Passe :</label>
  <input type="password" id="motDePasse" name="motDePasse" required>

  <label for="telephone">Téléphone :</label>
  <input type="tel" id="telephone" name="telephone">

  <label for="date_naissance">Date de Naissance :</label>
  <input type="date" id="date_naissance" name="date_naissance" required>

  <label for="date_inscription">Date d'Inscription :</label>
  <input type="date" id="date_inscription" name="date_inscription" required>
  
  <label for="statut">Statut :</label>
  <select id="statut" name="statut" required>
    <option value="1">Actif</option>
    <option value="0">Inactif</option>
  </select>

  <button type="submit">Ajouter l'Adhérent</button>
</form>
  </div>
</body>
</html>