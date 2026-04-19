<?php
$labelClassMap = [
    'Non traité' => 'totreat',
    'En cours'   => 'inprogress',
    'En vote'    => 'invote',
    'Clos'       => 'closed'
];
$activeTab = 'frictions';
?>

<main class="main container">

    <h1 class="title-md mb-32">GROUPE</h1>

    <div class="main__container">

        <?php include 'Partials/_nav.php' ?>

            <section class="main__section section main__section--first">

                <div class="section__top">
                    <h2 class="section__title title-lg">Liste des irritants</h2>
                </div>

                <div class="section__content">

                    <?php if (!$frictions): ?>

                        <p class="notice--info">Aucun irritant sur le groupe !</p>

                    <?php else: ?>

                        <?php foreach ($frictions as $f): ?>
                            <article class="frictionCard frictionCard--<?= $labelClassMap[$f["status_label"]] ?>">

                                <header class="frictionCard__header">
                                    <h3><?= htmlspecialchars($f["title"]) ?></h3>
                                    <span class="badge badge--<?= $labelClassMap[$f["status_label"]] ?>">
                                        <?= htmlspecialchars($f["status_label"]) ?>
                                    </span>
                                </header>

                                <p><?= htmlspecialchars($f["description"]) ?></p>

                                <?php if ($f["status_label"] === "Non traité"): ?>
                                    <p><?= $f["votes"] ?> votes</p>
                                <?php endif ?>

                                <a class="btn-secondary--sm" href="/team/<?= $teamId ?>/friction/<?= $f["id"] ?>">
                                    Consulter l'irritant
                                </a>

                            </article>
                        <?php endforeach ?>

                        <nav class="pagination">

                            <?php if ($currentPage > 1): ?>
                                <a class="btn-secondary--sm" href="/team/<?= $teamId ?>/frictions?page=<?= $currentPage - 1 ?>">
                                    Précédent
                                </a>
                            <?php else: ?>
                                <a class="btn-secondary--sm btn--inactive">Précédent</a>
                            <?php endif ?>

                            <span><?= $currentPage ?> / <?= $totalPages ?></span>

                            <?php if ($currentPage < $totalPages): ?>
                                <a class="btn-secondary--sm" href="/team/<?= $teamId ?>/frictions?page=<?= $currentPage + 1 ?>">
                                    Suivant
                                </a>
                            <?php else: ?>
                                <a class="btn-secondary--sm btn--inactive">Suivant</a>
                            <?php endif ?>

                        </nav>

                    <?php endif ?>

                </div>

            </section>

    </div>
</main>
