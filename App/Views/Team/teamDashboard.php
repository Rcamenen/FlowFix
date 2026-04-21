<?php
$labelClassMap = [
    'Non traité' => 'totreat',
    'En cours'   => 'inprogress',
    'En vote'    => 'invote',
    'Clos'       => 'closed'
];
$activeTab = 'dashboard';
?>

<div class="teamPanel page page--panel container">

    <div class="page__header">
        <h1 class="title-md mb-32">GROUPE</h1>
    </div>

    <div class="page__panel">

        <?php include 'Partials/_nav.php' ?>
        <div class="page__content panelContent">

            <div class="panelContent__header">
                <h2 class="section__title title-lg">Tableau de bord</h2>
            </div>

            <div class="panelContent__sections">

                <section class="panelContent__section section">

                    <div class="section__header">
                        <h3 class="title-md">Frictions que vous pilotez :</h3>
                    </div>
                    <div class="section__content">

                        <?php foreach ($frictionsToPilot as $f): ?>
                                <?php include 'Partials/_friction.php' ?>
                        <?php endforeach ?>

                        <?php if (!$frictionsToPilot): ?>
                            <p class="notice--info">Vous n'avez pas d'irritant à piloter !</p>
                        <?php endif ?>
                    </div>

                </section>

                <section class="panelContent__section section">

                    <div class="section__header">
                        <h3 class="title-md">Irritants en cours :</h3>
                    </div>

                    <div class="section__content">

                        <?php foreach ($frictionsInProgress as $f): ?>
                                <?php include 'Partials/_friction.php' ?>
                        <?php endforeach ?>

                        <?php if (!$frictionsInProgress): ?>
                            <p class="notice--info">Il n'y a pas d'irritant en cours de traitement !</p>
                        <?php endif ?>

                    </div>

                </section>

                <section class="panelContent__section section">
                    <div class="section__header">
                        <h3 class="title-md">Irritants que vous avez votés :</h3>
                    </div>

                    <div class="section__content">
                        <?php foreach ($frictionsVoted as $f): ?>
                                <?php include 'Partials/_friction.php' ?>
                        <?php endforeach ?>
                    </div>

                    <?php if (!$frictionsVoted): ?>
                        <p class="notice--info">Vous n'avez voté pour aucun irritant !</p>
                    <?php endif ?>

                </section>

            </div>

        </div>

    </div>
</div>

<script src="/js/nagerRequest.js" defer></script>