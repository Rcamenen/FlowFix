<?php
$labelClassMap = [
    'Non traité'    => 'totreat',
    'En cours' => 'inprogress',
    'En vote'     => 'invote',
    'Clos'     => 'closed',
    'Validé' => 'approved',
    'Non validé' => 'rejected',
    'À valider' => 'invote',
];
?>

<main class="main container" data-team-id=<?= $teamId ?>>

    <h1 class="section-label">Irritant</h1>
    <!-- MESSAGE DE SUCCES OU D'ERREUR -->

    <!-- SOUS MENU DE NAVIGATION -->
    <div class="main__container">

        <div class="main__content">


            <!-- AFFICHAGE DE L'IRRITANT -->

            <section class="main__section section main__section--first">

                <?php
                    $friction = $frictionData["friction"];
                    $user = $frictionData["user"];
                ?>

                <div class="section__top">
                    <h2 class="section__title title-lg">Détails de l'irritant</h2>
                </div>

                <div class="section__content">

                    <div class="card">
                        <div class="card__header">
                            <h3><?= $friction["title"] ?></h3>
                            <p class="text--xs">Ajouté le <?= new DateTime($friction["created_at"])->format("d-m-Y") ?> par <?= $friction["author"] ?></p>
                            <p class="badge badge--<?= $labelClassMap[$friction["statusLabel"]] ?>"><?= $friction["statusLabel"] ?></p>
                        </div>
                        <p><?= $friction["description"] ?></p>

                        <?php

                        if ($user["canVoteFriction"]): ?> //Si l'irritant n'est pas en cours ou pas déjà voté

                            <form action="/team/<?= $teamId ?>/friction/<?= $friction["id"] ?>/vote" method="post">
                                <button type="submit">Voter</button>
                            </form>

                        <?php endif ?>

                        <p> <?= $user["hasVotedFriction"] ? "Vous avez voté pour cet irritant !" : "Vous n'avez pas voté cet irritant" ?> </p>

                    </div>

                </div>

            </section>

            <!-- AFFICHAGE DES DERNIERS TREATMENTS -->

            <section class="main__section section main__section--first">

                <div class="section__top">
                    <?php if (isset($treatmentsData)): ?>
                        <h2 class="section__title title-lg">Détails du traitement</h2>
                    <?php else : ?>
                        <h2 class="section__title title-lg">Aucun traitement</h2>
                        <p class="text--xs">L'irritant n'a jamais été traité</p>
                    <?php endif ?>
                </div>

                <div class="section__content">

                    <?php if (isset($treatmentsData)) :?>

                    <?php foreach ($treatmentsData as $treatmentData) :

                            $treatment = $treatmentData["treatment"];
                            $user = $treatmentData["user"];

                    ?>
                            <div class="card">

                                <?php if ($treatment["cycleId"] == $cycleId): ?>
                                    <h3>Traitement en cours :</h3>
                                <?php else: ?>
                                    <h3>Traitement du cycle <?= $treatment["cycleId"] ?></h3>
                                <?php endif ?>

                                <p><?= $treatment["solution"] ?></p>

                                <?php if($user["canUpdateSolution"]): ?>
                                    <a href="/team/<?php echo $teamId ?>/friction/<?= $friction["id"] ?>/treatment/<?= $treatment["id"] ?>/updatesolution" class="btn-primary--sm mt-8">Ajouter une solution</a>
                                <?php endif ?>

                                <p><?= $treatment["created_at"] ?></p>
                                <p><?= $treatment["updated_at"] ?? "Pas d'update" ?></p>
                                <p><?= $treatment["pilot"] ?></p>
                                <p class="badge badge--<?= $labelClassMap[$treatment["statusLabel"]] ?>"><?= $treatment["statusLabel"] ?></p>

                                <!-- GESTION BOUTONS D'APPROBATION OU REJET -->
                                <?php if($user["canVoteTreatment"]): ?>

                                    <form class="btn-primary--sm mt-8" action="/team/<?= $teamId ?>/friction/<?= $friction["id"] ?>/treatment/<?= $treatment["id"] ?>/vote/1" method="post">
                                        <button type="submit">Approuver</button>
                                    </form>

                                    <form class="btn-primary--sm mt-8" action="/team/<?= $teamId ?>/friction/<?= $friction["id"] ?>/treatment/<?= $treatment["id"] ?>/vote/0" method="post">
                                        <button type="submit">Rejeter</button>
                                    </form>

                                <?php endif ?>

                                <?php if(!empty($user["hasApprovedSolution"])):?>

                                    <p> <?= $user["hasApprovedSolution"] ? "Vous avez voté pour" : "Vous avez voté contre !" ?> </p>

                                <?php endif ?>
                            </div>

                    <?php endforeach ?>
                    <?php endif ?>

                </div>

            </section>

        </div>

    </div>
</main>