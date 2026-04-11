<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/main.css">
    <title>FlowFix</title>
</head>
<body class="container--page">
    <header class="header">
        <ul class="nav">
            <li><a href="/">Accueil</a></li>
        <?php if(isset($_SESSION["userId"])){ ?>
            <li><a href="/teams">Mes groupes</a></li>
            <li><a href="/account">Mon compte</a></li>
            <li><a href="/disconnect">Déconnexion</a></li>
        <?php }else{?>
            <li><a href="/login">Connexion</a></li>
           <?php }?>
        </ul>
    </header>
    <?php include($contentPath); ?>
</body>
</html>