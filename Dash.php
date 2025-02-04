<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion du Club de Gym</title>
    <style>
       body {
    margin: 0;
    padding: 0;
    font-family: 'Montserrat', sans-serif;
    background: linear-gradient(330deg, #8ee9e3, #cce6ff);
    display: flex;
    flex-direction: column;
    height: 100vh;
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #1a746f ;
    color: white;
    padding: 10px 20px;
    height: 90px;
}

.header .logo {
    width: 100px;
    height: 100px;
    margin-left: 650px;
    border-radius: 50%;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s ease;
}

.logo:hover {
    transform: scale(1.1);
}

.header .welcome-message {
    font-size: 24px;
    font-weight: bold;
}

.header .welcome-message2 {
    font-size: 24px;
    font-weight: bold;
    margin-left: -1750px;
}

.container {
    display: flex;
    flex: 1;
}

.sidebar {
    width: 100px;
    background-color: #1a746f;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding-top: 20px;
}

.sidebar button {
    background: none;
    border: none;
    color: white;
    font-size: 14px;
    margin: 15px 0;
    cursor: pointer;
    text-align: center;
    transition: color 0.3s ease;
}

.sidebar button:hover {
    color: #8ee9e3;
}

.sidebar button img {
    width: 30px;
    height: 30px;
    display: block;
    margin-bottom: 5px;
}

.main-content {
    flex: 1;
    padding: 20px;
    background-color: white;
    margin: 10px;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.main-content h2 {
    color: #27a69e;
    margin-bottom: 20px;
}

.section {
    display: none;
}

.section.active {
    display: block;
}

iframe {
    width: 100%;
    height: 80vh;
    border: none;
    border-radius: 8px;
}

    </style>
</head>
<body>
    <div class="header">
        <img src="logo_gym2.png" alt="Logo Club de Gym" class="logo">
        <div class="welcome-message2">Bienvenue au Club</div>
        <div class="welcome-message">Gestion du Club de Gym</div>
    </div>

    <div class="container">
        <div class="sidebar">
            <button onclick="showSection('adherents')">
                <img src="weightliftsport_weightlift_5042.png" alt="Adhérents">
                Adhérents
            </button>
            <button onclick="showSection('abonnements')">
                <img src="cards_icon_138799.png" alt="Abonnements">
                Abonnements
            </button>
            <button onclick="showSection('paiements')">
                <img src="carduse_card_payment_5122.png" alt="Paiement">
                Paiements
            </button>
            <button onclick="showSection('notifications')">
                <img src="notifications-bell-button_icon-icons.com_72648.png" alt="Matières">
                Notifications
            </button>
            <button onclick="showSection('historiques')">
                <img src="history_117628.png" alt="Matières">
                Historiques
            </button>
            <button onclick="showSection('informations')">
                <img src="circle_customer_help_info_information_service_support_icon_123208.png" alt="Liste Étudiants">
                Infos Club
            </button>
            <button onclick="confirmLogout()">
                <img src="logout_icon_151219.png" alt="Quitter">
                Déconnexion
            </button>
        </div>

        <div class="main-content">
            <div id="adherents" class="section active">
                <h2>Adhérents</h2>
                <iframe src="afficher_adherents.php"></iframe>
            </div>

            <div id="abonnements" class="section">
                <h2>Abonnements</h2>
                <iframe src="afficher_abonnements.php"></iframe>
            </div>

            <div id="paiements" class="section">
                <h2>Paiements</h2>
                <iframe src="afficher_paiement.php"></iframe>
            </div>

            <div id="notifications" class="section">
                <h2>Notifications</h2>
                <iframe src="afficher_notifs.php"></iframe>
            </div>

            <div id="historiques" class="section">
                <h2>Historiques</h2>
                <iframe src="afficher_historique.php"></iframe>
            </div>

            <div id="informations" class="section">
                <h2>Infos Club</h2>
                <iframe src="infos_club.php"></iframe>
            </div>
        </div>
    </div>

    <script>
        function showSection(sectionId) {
            document.querySelectorAll('.section').forEach(section => {
                section.classList.remove('active');
            });
            document.getElementById(sectionId).classList.add('active');
        }

        function confirmLogout() {
            if (confirm("Êtes-vous sûr de vouloir vous déconnecter ?")) {
                window.location.href = "loader_deconnect.php";
            }
        }
    </script>
</body>
</html>
