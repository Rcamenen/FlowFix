<!-- <?php if($isModerator) echo "vous êtes modérateur de ce groupe";
        else echo "Vous n'êtes pas modérateur de ce groupe";?> -->
            <!-- message d'erreur -->

            <?php if(isset($_SESSION["error"])){ ?>

                    <div class="card--error">
                        <p><?= $_SESSION["error"] ?></p>
                    </div>
                    
            <?php unset($_SESSION['error']) ;} ?>

<main id="teamDashboard" class="main container" data-team-id=<?= $teamId ?>>

    <h1 class="title-md">Tableau de bord du groupe</h1>
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
            <p class="section-label"><?= $teamName ?></p>
            <ul class="subnav__list">
                <li data-tab-button="dashboard" class="subnav__item btn-tab btn-tab--active">Vue globale</li>
                <li data-tab-button="frictions" class="subnav__item btn-tab">Irritants</li>
                <li data-tab-button="infos" class="subnav__item btn-tab">Cycle</li>
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

        <section data-tab-content="infos" class="main__section section dn main__section--first">

            <div class="section__top">
                <h2 class="section__title title-lg">Cycle en cours</h2>
            </div>

            <div class="section__content">


                     <div class="card--cycle">

                        <h3 class="title-md">Dates</h3>

                        <div class="flex-col g-8">
                            <p class="text--xs">Début : </p>
                            <span class=" badge badge--inprogress"><?= new DateTime($cycle["start_date"])->format('d-m-Y') ?> </span>
                        </div>

                        <div class="flex-col g-8">
                            <p class="text--xs">Fin :</p>
                            <span class="badge badge--closed"><?= new DateTime($cycle["end_date"])->format('d-m-Y')?></span>
                        </div>

                        <p class="text--xs">Les cycles se terminent le jour indiqué à 23h59</p>
                    </div>

                    <!-- FORM POUR REQUETE API -->
                    <div class="card--cycle">

                        <h3 class="title-md">Consultation des jours fériés</h3>
                        <p class="text--xs">Renseigner une date afin de savoir s'il s'agit d'un jour férié.</p>
                        <form class="form" id="formHolidayCheck" action="">

                            <input class="form__input" id="checkDate" name="checkDate" type="date" required>

                            <button type="button" class="btn-primary">Vérifier</button>

                            <p class="form__message"></p>

                        </form>


                    </div>

            </div>       

        </section>
    </div>
    </div>
</main>

<script src="/js/dashboard.js" defer></script>
<script src="/js/nagerRequest.js" defer></script>

<!-- <?php include(ROOT."/App/Views/Team/teamMember/teamMemberAddForm.php"); ?> -->
