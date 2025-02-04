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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $montant = $conn->real_escape_string($_POST['montant']);
    $date_paiement = $conn->real_escape_string($_POST['date_paiement']);
    $methode_paiement = $conn->real_escape_string($_POST['methode_paiement']);
    $reference_transaction = $conn->real_escape_string($_POST['reference_transaction']);
    $statut = $conn->real_escape_string($_POST['statut']);
    $id_abonnement = $conn->real_escape_string($_POST['id_abonnement']);
    $id_membre = $conn->real_escape_string($_POST['id_membre']);

    // Insertion dans la base de données
    $sql = "INSERT INTO paiement (montant, date_paiement, methode_paiement, reference_transaction, statut, id_abonnement, id_membre) 
            VALUES ('$montant', '$date_paiement', '$methode_paiement', '$reference_transaction', '$statut', '$id_abonnement', '$id_membre')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Paiement ajouté avec succès');</script>";
    } else {
        echo "<script>alert('Erreur lors de l\'ajout du paiement');</script>";
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
  <title>Ajouter un Paiement</title>
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
    <h1>Ajouter un Paiement</h1>
    <form id="addPaiementForm" method="post">
      <!-- Montant -->
      <label for="montant">Montant :</label>
      <input type="number" id="montant" name="montant" step="0.01" required>

      <!-- Date de paiement -->
      <label for="date_paiement">Date de Paiement :</label>
      <input type="date" id="date_paiement" name="date_paiement" required>

      <!-- Méthode de paiement -->
      <label for="methode_paiement">Méthode de Paiement :</label>
      <select id="methode_paiement" name="methode_paiement" required>
        <option value="Carte">Carte</option>
        <option value="Virement">Virement</option>
        <option value="Espèces">Espèces</option>
      </select>

      <!-- Référence de transaction -->
      <label for="reference_transaction">Référence de Transaction :</label>
      <input type="text" id="reference_transaction" name="reference_transaction" required>

      <!-- Statut -->
      <label for="statut">Statut :</label>
      <select id="statut" name="statut" required>
        <option value="en_attente">En attente</option>
        <option value="valide">Validé</option>
        <option value="refus">Refusé</option>
      </select>

      <!-- ID Abonnement -->
      <label for="id_abonnement">ID Abonnement :</label>
      <input type="number" id="id_abonnement" name="id_abonnement" required>

      <!-- ID Membre -->
      <label for="id_membre">ID Membre :</label>
      <input type="number" id="id_membre" name="id_membre" required>

      <!-- Bouton de soumission -->
      <button type="submit">Ajouter le Paiement</button>
    </form>
  </div>
</body>
</html>