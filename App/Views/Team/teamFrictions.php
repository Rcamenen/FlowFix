<?php
$labelClassMap = [
    'Non traité' => 'totreat',
    'En cours'   => 'inprogress',
    'En vote'    => 'invote',
    'Clos'       => 'closed'
];
$activeTab = 'frictions';
?>

<div class="teamPanel container page page--panel">

    <div class="page__header">
        <h1 class="title-md mb-32">GROUPE</h1>
    </div>

    <div class="page__panel">

        <?php include 'Partials/_nav.php' ?>
        <div class="page__content panelContent">

            <div class="panelContent__header">
                <h2 class="section__title title-lg">Liste des irritants</h2>
            </div>

            <div class="panelContent__sections">
                <section class="panelContent__section section">

                    <?php if (!$frictions): ?>

                        <p class="notice--info">Aucun irritant sur le groupe !</p>

                    <?php else: ?>
                        <div class="section__content">
                            <?php foreach ($frictions as $f): ?>
                                <?php include 'Partials/_friction.php' ?>
                            <?php endforeach ?>
                        </div>


                        <nav class="pagination">

                            <?php if ($currentPage > 1): ?>
                                <a class="btn-secondary--sm" href="team/<?= $teamId ?>/frictions?page=<?= $currentPage - 1 ?>">
                                    Précédent
                                </a>
                            <?php else: ?>
                                <a class="btn-secondary--sm btn--inactive">Précédent</a>
                            <?php endif ?>

                            <span><?= $currentPage ?> / <?= $totalPages ?></span>

                            <?php if ($currentPage < $totalPages): ?>
                                <a class="btn-secondary--sm" href="team/<?= $teamId ?>/frictions?page=<?= $currentPage + 1 ?>">
                                    Suivant
                                </a>
                            <?php else: ?>
                                <a class="btn-secondary--sm btn--inactive">Suivant</a>
                            <?php endif ?>

                        </nav>

                    <?php endif ?>

                </section>
            </div>

        </div>

    </div>
</div>