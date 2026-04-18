
<main id="teamDashboard" class="main container" data-team-id=<?= $teamId ?>>

    <h1 class="title-md mb-32">GROUPE</h1>

    <div class="main__container">

        <aside class="main__nav">
            <nav class="subnav">
                <p class="section-label"><?= $teamName ?></p>
                <ul class="subnav__list">
                    <li data-tab-button="dashboard" class="subnav__item btn-tab btn-tab--active">Tableau de bord</li>
                    <li data-tab-button="frictions" class="subnav__item btn-tab">Irritants</li>
                    <li data-tab-button="infos" class="subnav__item btn-tab">Cycle</li>
                    <?php if($isModerator): ?>
                    <li data-tab-button="moderation" class="subnav__item btn-tab">Modération</li>
                    <?php endif ?>
                    <li data-tab-button="addFriction" class="subnav__item btn-primary--sm"><a href="/team/<?= $teamId ?>/friction/create">Créer un irritant</a></li>
                </ul>
            </nav>
        </aside>

        <div class="main__content">

            <section data-tab-content="dashboard" class="main__section section main__section main__section--first">

                <div class="section__top">
                    <h2 class="section__title title-lg">Tableau de bord</h2>
                </div>

                <div class="section__content">

                    <h3 class="title-md">Friction que vous pilotez :</h3>

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

                <div class="section__content">

                    <h3 class="title-md">Irritants en cours :</h3>
                    <?php foreach($frictionsInProgress as $f): ?>
                        <div class="frictionCard">
                            <h3><?= $f["title"] ?></h3>
                            <a href="/team/<?= $teamId ?>/friction/<?= $f["id"] ?>">Voir</a>
                        </div>
                    <?php endforeach; ?>
                    <?php if(!$frictionsInProgress){?>
                        <p class="notice--info">Il n'y a pas d'irritant en cours de traitement !</p>
                    <?php } ?>

                </div>

                <div class="section__content">
                    <h3 class="title-md">Irritants que vous avez voté :</h3>

                    <?php foreach($frictionsVoted as $f): ?>

                        <article class="frictionCard frictionCard--<?= $labelClassMap[$f["status_label"]] ?>">

                            <header class="frictionCard__header">
                                <h3><?= $f["title"] ?></h3>
                                <span class="badge badge--<?= $labelClassMap[$f["status_label"]] ?>"><?= $f["status_label"] ?></span>
                            </header>

                            <p><?= $f["description"] ?></p>

                            <a class="btn-secondary--sm" href="/team/<?= $teamId ?>/friction/<?= $f["id"] ?>">Consulter l'irritant</a>

                        </article>

                    <?php endforeach; ?>
                    <?php if(!$frictionsVoted){?>
                        <p class="notice--info">Vous n'avez voté pour aucun irritant !</p>
                    <?php } ?>
                </div>

            </section>

            <section data-tab-content="frictions" class="main__section section dn main__section--first">

                <div class="section__top">
                    <h2 class="section__title title-lg">Listes des irritants</h2>
                </div>

                <!-- Contenu chargé dynamiquement via loadFrictions() -->
                <div class="section__content"></div>

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
                            <span class="badge badge--inprogress"><?= new DateTime($cycle["start_date"])->format('d-m-Y') ?></span>
                        </div>

                        <div class="flex-col g-8">
                            <p class="text--xs">Fin :</p>
                            <span class="badge badge--closed"><?= new DateTime($cycle["end_date"])->format('d-m-Y') ?></span>
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

            <section data-tab-content="moderation" class="main__section section dn main__section--first">

                <div class="section__top">
                    <h2 class="section__title title-lg">Modération</h2>
                </div>

                <!-- Contenu chargé dynamiquement via loadAddMemberTab() -->
                <div class="section__content"></div>

            </section>

        </div>     
    </div>
</main>

<script src="/js/dashboard.js" defer></script>
<script src="/js/nagerRequest.js" defer></script>