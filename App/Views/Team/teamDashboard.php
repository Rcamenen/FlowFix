<?php
$labelClassMap = [
    'Non traité' => 'totreat',
    'En cours'   => 'inprogress',
    'En vote'    => 'invote',
    'Clos'       => 'closed'
];
$activeTab = 'dashboard';
?>

<main class="main container">

    <h1 class="title-md mb-32">GROUPE</h1>

    <div class="main__container">
        <?php include 'Partials/_nav.php' ?>

            <section class="main__section section main__section--first">

                <div class="section__top">
                    <h2 class="section__title title-lg">Tableau de bord</h2>
                </div>

                <div class="section__content">

                    <h3 class="title-md">Frictions que vous pilotez :</h3>

                    <?php foreach ($frictionsToPilot as $f): ?>
                        <article class="frictionCard">
                            <h3><?= htmlspecialchars($f["title"]) ?></h3>
                            <a class="btn-secondary--sm" href="/team/<?= $teamId ?>/friction/<?= $f["id"] ?>">Voir</a>
                        </article>
                    <?php endforeach ?>

                    <?php if (!$frictionsToPilot): ?>
                        <p class="notice--info">Vous n'avez pas d'irritant à piloter !</p>
                    <?php endif ?>

                </div>

                <div class="section__content">

                    <h3 class="title-md">Irritants en cours :</h3>

                    <?php foreach ($frictionsInProgress as $f): ?>
                        <article class="frictionCard">
                            <h3><?= htmlspecialchars($f["title"]) ?></h3>
                            <a class="btn-secondary--sm" href="/team/<?= $teamId ?>/friction/<?= $f["id"] ?>">Voir</a>
                        </article>
                    <?php endforeach ?>

                    <?php if (!$frictionsInProgress): ?>
                        <p class="notice--info">Il n'y a pas d'irritant en cours de traitement !</p>
                    <?php endif ?>

                </div>

                <div class="section__content">

                    <h3 class="title-md">Irritants que vous avez votés :</h3>

                    <?php foreach ($frictionsVoted as $f): ?>
                        <article class="frictionCard frictionCard--<?= $labelClassMap[$f["status_label"]] ?>">

                            <header class="frictionCard__header">
                                <h3><?= htmlspecialchars($f["title"]) ?></h3>
                                <span class="badge badge--<?= $labelClassMap[$f["status_label"]] ?>">
                                    <?= htmlspecialchars($f["status_label"]) ?>
                                </span>
                            </header>

                            <p><?= htmlspecialchars($f["description"]) ?></p>

                            <a class="btn-secondary--sm" href="/team/<?= $teamId ?>/friction/<?= $f["id"] ?>">
                                Consulter l'irritant
                            </a>

                        </article>
                    <?php endforeach ?>

                    <?php if (!$frictionsVoted): ?>
                        <p class="notice--info">Vous n'avez voté pour aucun irritant !</p>
                    <?php endif ?>

                </div>

            </section>


    </div>
</main>

<script src="/js/nagerRequest.js" defer></script>
