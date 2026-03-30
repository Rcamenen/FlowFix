<h1>Bienvenue sur FlowFix</h1>

<?php if(isset($_GET["message"])) echo $_GET["message"]; ?>
<?php if(isset($_GET['disconnected'])) echo "Vous avez bien été deconnecté<br>"; ?>

<?php 

if(isset($_SESSION["userId"])) echo "<a href=\"/disconnect\">Se déconnecter</a>";
else{
    echo "<a href=\"/login\">Se connecter</a>";
    echo "<br><a href=\"/register\">Se créer un compte</a>";
}

