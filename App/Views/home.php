<h1>Résolver les irritants qui freinent votre équipe</h1>
<p>FlowFix permet à chaque membre de l'équipe de signaler les frictions du quotidien, de voter collectivement pour les prioriser, et de les traiter cycle par cycle.</p>
<?php if(isset($_GET["message"])) echo $_GET["message"]; ?>
<?php if(isset($_GET['disconnected'])) echo "Vous avez bien été deconnecté<br>"; ?>

<?php 

if(isset($_SESSION["userId"])) echo "<a href=\"/disconnect\">Se déconnecter</a>";
else{
    echo "<a href=\"/login\">Se connecter</a>";
    echo "<br><a href=\"/register\">Se créer un compte</a>";
}

?>