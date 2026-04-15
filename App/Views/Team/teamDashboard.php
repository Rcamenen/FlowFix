<!-- <?php if($isModerator) echo "vous êtes modérateur de ce groupe";
        else echo "Vous n'êtes pas modérateur de ce groupe";?> -->
            <!-- message d'erreur -->

            <?php if(isset($_SESSION["error"])){ ?>

                    <div class="card--error">
                        <p><?= $_SESSION["error"] ?></p>
                    </div>
                    
            <?php unset($_SESSION['error']) ;} ?>

<main class="main container" data-team-id=<?= $teamId ?>>

    <h1 class="title-md">Tableau de bord</h1>
    <!-- MESSAGE DE SUCCES OU D'ERREUR -->

    <?php if(!empty($_SESSION["error"])): ?>
    <div class="container">
            <p class="notice--success"> Vous ne faites pas partie de ce groupe </p>
    </div>
    <?php endif ?>

    <!-- SOUS MENU DE NAVIGATION -->
    <div class="main__container">
    <aside class="main__nav">
        <nav class="subnav">
            <p class="section-label">Groupe</p>
            <ul class="subnav__list">
                <li data-tab-button="dashboard" class="subnav__item btn-tab btn-tab--active">Vue globale</li>
                <li data-tab-button="frictions" class="subnav__item btn-tab">Irritants</li>
                <li data-tab-button="infos" class="subnav__item btn-tab">Infos groupe</li>
                <li data-tab-button="addFriction" class="subnav__item btn-primary--sm"><a href="/team/<?= $teamId ?>/friction/create">Créer un irritant</a></li>
            </ul>
        </nav>
    </aside>

    <div class="main__content">
        <section data-tab-content="dashboard" class="main__section section main__section main__section--first">

            <div class="section__top">
                <h2 class="section__title title-lg">Irritants à piloter</h2>
            </div>

            <div class="section__content">
                <?php foreach($frictionsToPilot as $f): ?>
                    <div class="frictionCard">
                        <h3><?= $f["title"] ?></h3>
                        <a href="/team/<?= $teamId ?>/friction/<?= $f["id"] ?>">Voir</a>
                    </div>
                <?php endforeach; ?>
                <?php if(!$frictionsToPilot){?>

                    <p class="notice--info">Vous n'avez pas d'irritant à piloter !</p>

                <?php } ?>
            </div>

        </section>

        <section data-tab-content="dashboard" class="main__section section">

            <div class="section__top">
                <h2 class="section__title title-lg">Irritants en cours</h2>
            </div>

            <div class="section__content">
                <?php foreach($frictionsInProgress as $f): ?>
                    <div class="frictionCard">
                        <h3><?= $f["title"] ?></h3>
                        <a href="/team/<?= $teamId ?>/friction/<?= $f["id"] ?>">Voir</a>
                    </div>
                <?php endforeach; ?>
                <?php if(!$frictionsToPilot){?>

                    <p class="notice--info">Il n'y a pas d'irritant en cours de traitement !</p>

                <?php } ?>
            </div>

        </section>

        <section data-tab-content="dashboard" class="main__section section">

            <div class="section__top">
                <h2 class="section__title title-lg">Vos votes</h2>
            </div>

            <div class="section__content">
                <?php foreach($frictionsInProgress as $f): ?>
                    <div class="frictionCard">
                        <h3><?= $f["title"] ?></h3>
                        <a href="/team/<?= $teamId ?>/friction/<?= $f["id"] ?>">Voir</a>
                    </div>
                <?php endforeach; ?>
                <?php if(!$frictionsToPilot){?>

                    <p class="notice--info">Vous n'avez voté pour aucun irritant !</p>

                <?php } ?>
            </div>

        </section>

        <section data-tab-content="frictions" class="main__section section dn main__section--first">

            <div class="section__top">
                <h2 class="section__title title-lg">Listes des irritants</h2>
            </div>

            <!-- AFFICHAGE DES IRRITANTS DU GROUPES -->
            <div class="section__content">

            </div>

        </section>
    </div>
    </div>
</main>

<script src="/js/dashboard.js" defer></script>

<!-- <?php include(ROOT."/App/Views/Team/teamMember/teamMemberAddForm.php"); ?> -->
