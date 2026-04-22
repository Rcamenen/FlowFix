<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'Accueil', ENT_QUOTES, 'UTF-8') ?> — FlowFix</title>

    <base href="<?= FULL_URL ?>">
    <link rel="stylesheet" href="Public/css/main.css">

    <link crossorigin="anonymous" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        referrerpolicy="no-referrer" rel="stylesheet">

    <script src="Public/js/nav.js" defer></script>
</head>

<body>

    <a href="#main" class="skip-link">Aller au contenu principal</a>

    <header class="header">

        <nav class="header__nav navbar" aria-label="Navigation principale">

            <div class="container">
                <div class="navbar__inner">

                    <a href="<?= FULL_URL ?>" class="navbar__logo" aria-label="FlowFix - retour à l'accueil">
                        <img src="Public/images/flowfix_logo.webp" alt="Logo FlowFix">
                        <span class="title-md">FlowFix</span>
                    </a>

                    <button type="button" class="navbar__burger" aria-label="Menu de navigation" aria-expanded="false" aria-controls="primary-menu">
                        <span class="fa-solid fa-bars burger" aria-hidden="true"></span>
                    </button>

                    <ul id="primary-menu" class="navbar__menu">

                        <li class="navbar__item">
                            <a class="navbar__link link" href="<?= FULL_URL ?>">Accueil</a>
                        </li>

                        <?php if (empty($_SESSION["adminId"])): ?>

                            <?php if (!empty($_SESSION["userId"])): ?>

                                <li class="navbar__item">
                                    <a class="navbar__link link" href="teams">Groupes</a>
                                </li>

                                <li class="navbar__item">
                                    <a class="navbar__link link" href="account">Profil</a>
                                </li>

                                <li class="navbar__item">
                                    <form action="logout" method="post">
                                        <button class="navbar__link link" type="submit">Déconnexion</button>
                                    </form>
                                </li>

                            <?php else: ?>

                                <li class="navbar__item">
                                    <a class="navbar__link link" href="register">Inscription</a>
                                </li>

                                <li class="navbar__item">
                                    <a class="navbar__link link" href="login">Connexion</a>
                                </li>

                            <?php endif ?>

                        <?php else: ?>

                            <li class="navbar__item">
                                <a class="navbar__link link" href="admin/teams">Groupes</a>
                            </li>

                            <li class="navbar__item navbar__item--active">
                                <a class="navbar__link link" href="admin/users" aria-current="page">Utilisateurs</a>
                            </li>

                            <li class="navbar__item">
                                <form action="admin/logout" method="post">
                                    <button class="navbar__link link" type="submit">Déconnexion</button>
                                </form>
                            </li>

                        <?php endif ?>

                    </ul>
                </div>
            </div>

        </nav>

    </header>

    <main id="main" tabindex="-1">
        <?php include($contentPath); ?>
    </main>

    <footer class="footer">

        <div class="footer__inner container">

            <p class="footer__brand">FlowFix</p>

            <nav class="footer__nav" aria-label="Pied de page">
                <ul>
                    <li><a href="contact">Contact</a></li>
                    <li><a href="legal">Mentions légales</a></li>
                    <li><a href="privacy">Politique de confidentialité</a></li>
                </ul>
            </nav>

            <p class="footer__copyright">&copy; FlowFix 2026</p>

        </div>

    </footer>

</body>

</html>