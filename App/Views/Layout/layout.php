<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/main.css">
    <title>FlowFix</title>

    <link crossorigin="anonymous" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
    integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
    referrerpolicy="no-referrer" rel="stylesheet" />
</head>
<body>
    <script src="/js/nav.js" defer></script>

    <?php if(isset($_GET["message"])) echo $_GET["message"]; ?>

    <?php if(isset($_SESSION["disconnect"])): ?>
    <div class="container">
        <p class="notice--success">Vous avez bien été déconnecté ! </p>
        <?php unset($_SESSION["disconnect"]) ?>
    </div>
    <?php endif ?>
    
    <header class="header">

        <nav class="navbar">

            <div class="navbar__logo">
            FlowFix
            </div>

            <button aria-label="ouvrir le menu de navigation" class="navbar__burger">
                <i class="fa-solid fa-bars burger"></i>
            </button>

            <ul class="navbar__menu">

                <li class="navbar__item">
                    <a class="navbar__link" href="/">Accueil</a>
                </li>

                <?php if(empty($_SESSION["adminId"])): ?>

                    <?php if(!empty($_SESSION["userId"])): ?>

                    <li class="navbar__item">
                        <a class="navbar__link" href="/teams">Groupes</a>
                    </li>

                    <li class="navbar__item">
                        <a class="navbar__link" href="/account">Profil</a>
                    </li>

                    <form action="/logout" method="post">
                        <button type="submit">Déconnexion</button>
                    </form>

                    <?php else: ?>

                    <li class="navbar__item">
                        <a class="navbar__link" href="/register">Inscription</a>
                    </li>

                    <li class="navbar__item">
                        <a class="navbar__link" href="/login">Connexion</a>
                    </li>

                    <?php endif ?>

                    <li class="navbar__item navbar__item--active">
                    <a class="navbar__link" href="/contact">Contact</a>
                    </li>

                <?php else: ?>

                    <li class="navbar__item">
                    <a class="navbar__link" href="/admin/teams">Groupes</a>
                    </li>

                    <li class="navbar__item navbar__item--active">
                    <a class="navbar__link" href="/admin/users">Utilisateurs</a>
                    </li>

                    <li class="navbar__item navbar__item--active">
                    <form action="/admin/logout" method="post">
                        <button class="navbar__link" type="submit">Déconnexion</button>
                    </form>
                    </li>

                <?php endif ?>

            </ul>

        </nav>

    </header>
    <?php include($contentPath); ?>
</body>
</html>