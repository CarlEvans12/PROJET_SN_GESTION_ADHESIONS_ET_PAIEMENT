<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Login_Admin.css">
    <title>Login Administrateur</title>
</head>

<body>

    <div class="container" id="container">
        <div class="form-container sign-up">
            <form>
                <h1 style="color: #a7a465; font-weight: bold;">Créer un compte</h1>
                <div class="social-icons">
                    <a href="#" class="icon"><img src="Images/icons8-chrome-48.png" alt="Google icon" style="margin-left:10px;"></a>
                    <a href="#" class="icon"><img src="Images/icons8-instagram-48 (1).png" alt="Instagram icon" style="margin-left:20px;"></a>
                    <a href="#" class="icon"><img src="Images/icons8-twitter-circled-48.png" alt="Twitter icon" style="margin-left:20px;"></a>
                </div>
            </form>
        </div>
        <div class="form-container sign-in">
            <form method="POST" action="">
                  <h1 style="color: #27a69e; font-weight: bold; margin-bottom: 30px;">Se connecter</h1>
                  <input type="email" id="email" name="email" placeholder="Email" required>
                  <input type="password" id="password" name="password" placeholder="Mot de passe" required>
                <span>Vous pouvez aussi vous connecter vous via</span>
                <div class="social-icons">
                    <a href="#" class="icon"><img src="Images/icons8-chrome-48.png" alt="Google icon" style="margin-left:10px;"></a>
                    <a href="#" class="icon"><img src="Images/icons8-instagram-48 (1).png" alt="Instagram icon" style="margin-left:20px;"></a>
                    <a href="#" class="icon"><img src="Images/icons8-twitter-circled-48.png" alt="Twitter icon" style="margin-left:20px;"></a>
                </div>
                <div class="quest">
                </div>
                <button type="submit" name="ok">Se Connecter</button>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Bon retour parmis nous!</h1>
                    <p>Avez-vous déjà un compte ?</p>
                    <button type="submit" name="ok" class="hidden" id="login">Se Connecter</button>
                </div>
               
                <div class="toggle-panel toggle-right">
                    <div class="logo1">
                        <img src="Images/logo_final.png" alt="Sport_center Logo" class="logo">
                     </div>
                    <div class="text-container">
                      <h1 class="white-text">Bon retour</h1>
                      <h1 class="tomato-text">parmis nous!</h1>
                      <p>Prêt à apporter de nouvelles modifications à l'appli Sportify Online ?</p>
                    
                    </div>
                    
                   
                </div>
            </div>
        </div>
    </div>
    <?php
session_start();

$host = "localhost";
$dbname = "gestionabonnements";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

if (isset($_POST['ok'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

     if ($email != "" && $password != "") {
        // Requête sécurisée pour récupérer les informations de l'utilisateur
        $stmt = $pdo->prepare("SELECT * FROM administration WHERE email_admin = :email AND motDePasse = :pass");
        $stmt->execute(['email' => $email,'pass' => $password]);
        $rep = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($rep ) {
            $_SESSION['id_administration'] = $req['IdEtudiant'];
        echo "<script>window.location.href = 'loader.php';</script>";
        } 
        else {
            // Mot de passe incorrect ou utilisateur non trouvé
            echo "<script>alert('Email ou mot de passe incorrect.');
                  window.location.href = 'Login_Admin.php';</script>";
       
         }
     }
}
?>
</body>

</html>
