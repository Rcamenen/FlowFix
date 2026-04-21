<?php
$activeTab = 'frictions';

$labelClassMap = [
    'Non traité'  => 'totreat',
    'En cours'    => 'inprogress',
    'En vote'     => 'invote',
    'Clos'        => 'closed',
    'Validé'      => 'approved',
    'Non validé'  => 'rejected',
    'À valider'   => 'invote',
];
?>

<div class="teamPanel container">

    <div class="page__header">
        <h1 class="title-md mb-32">GROUPE</h1>
    </div>

    <div class="page__panel">

        <?php include dirname(__DIR__).'/Partials/_nav.php' ?>
        <div class="page__content panelContent">

            <div class="panelContent__header">
                <h2 class="section__title title-lg">Détails de l'irritant</h2>
            </div>

            <div class="panelContent__sections">

                <!-- AFFICHAGE DE L'IRRITANT -->

                <section class="panelContent__section">

                    <?php
                        $friction = $frictionData["friction"];
                        $user     = $frictionData["user"];
                    ?>

                    <div class="frictionCard">

                        <div class="frictionCard__top">
                            <h3><?= htmlspecialchars($friction["title"]) ?></h3>
                            <span class="badge badge--<?= $labelClassMap[$friction["statusLabel"]] ?>"><?= $friction["statusLabel"] ?></span>
                        </div>
                        <div class="frictionCard__description">

                            <p><?= htmlspecialchars($friction["description"]) ?></p>

                        </div>
                        
                        <div>
                        <p class="text--xs">Ajouté le <?= (new DateTime($friction["created_at"]))->format("d-m-Y") ?> par <?= $friction["author"] ?></p>
                        <?php if ($user["canVoteFriction"]): ?>
                            <form action="team/<?= $teamId ?>/friction/<?= $friction["id"] ?>/vote" method="POST">
                                <button type="submit">Voter</button>
                            </form>
                        <?php else: ?>
                            <p class="text--xs">Vous ne pouvez plus voter</p>
                        <?php endif ?>

                        <p class="text--xs"><?= $user["hasVotedFriction"] ? "Vous avez voté pour cet irritant !" : "Vous n'avez pas voté cet irritant" ?></p>
                        </div>
                        

                    </div>

                </section>

                <!-- AFFICHAGE DES TRAITEMENTS -->

                <section class="panelContent__section">

                    <?php if (isset($treatmentsData)): ?>
                        <h3 class="title-md">Détails du traitement</h3>
                    <?php else: ?>
                        <h3 class="title-md">Aucun traitement</h3>
                        <p class="text--xs">L'irritant n'a jamais été traité</p>
                    <?php endif ?>

                    <?php if (isset($treatmentsData)): ?>

                        <?php foreach ($treatmentsData as $treatmentData):

                            $treatment = $treatmentData["treatment"];
                            $user      = $treatmentData["user"];

                        ?>

                            <div class="card">

                                <?php if ($treatment["cycleId"] == $cycleId): ?>
                                    <h3>Traitement en cours :</h3>
                                <?php else: ?>
                                    <h3>Traitement du cycle <?= $treatment["cycleId"] ?></h3>
                                <?php endif ?>

                                <p><?= htmlspecialchars($treatment["solution"]) ?></p>

                                <?php if ($user["canUpdateSolution"]): ?>
                                    <a class="btn-primary--sm mt-8" href="team/<?= $teamId ?>/friction/<?= $friction["id"] ?>/treatment/<?= $treatment["id"] ?>/updatesolution">Ajouter une solution</a>
                                <?php endif ?>

                                <p><?= $treatment["created_at"] ?></p>
                                <p><?= $treatment["updated_at"] ?? "Pas d'update" ?></p>
                                <p><?= htmlspecialchars($treatment["pilot"]) ?></p>
                                <span class="badge badge--<?= $labelClassMap[$treatment["statusLabel"]] ?>"><?= $treatment["statusLabel"] ?></span>

                                <?php if ($user["canVoteTreatment"]): ?>

                                    <form class="mt-8" action="team/<?= $teamId ?>/friction/<?= $friction["id"] ?>/treatment/<?= $treatment["id"] ?>/vote/1" method="POST">
                                        <button class="btn-primary--sm" type="submit">Approuver</button>
                                    </form>

                                    <form class="mt-8" action="team/<?= $teamId ?>/friction/<?= $friction["id"] ?>/treatment/<?= $treatment["id"] ?>/vote/0" method="POST">
                                        <button class="btn-primary--sm" type="submit">Rejeter</button>
                                    </form>

                                <?php endif ?>

                                <?php if (!empty($user["hasApprovedSolution"])): ?>
                                    <p><?= $user["hasApprovedSolution"] ? "Vous avez voté pour" : "Vous avez voté contre !" ?></p>
                                <?php endif ?>

                            </div>

                        <?php endforeach ?>

                    <?php endif ?>

                </section>

            </div>

        </div>

    </div>
</div>