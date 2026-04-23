<?php $activeTab = 'teams'; ?>

<div class="page page--panel adminPanel main container">

    <div class="page__header">
        <h1 class="title-md mb-32">ADMINISTRATION</h1>
    </div>

    <div class="page__panel">

        <?php include dirname(__DIR__) . '/Admin/Partials/_nav.php' ?>
        <div class="page__content panelContent">

            <div class="panelContent__header">
                <h2 class="section__title title-lg">Liste des groupes</h2>
            </div>

            <div class="panelContent__sections">
                <section class="panelContent__section">

                    <?php if (empty($teams)): ?>

                        <p class="notice--info">Aucun groupe trouvé.</p>

                    <?php else: ?>
                            <?php foreach ($teams as $team): ?>
                                <div class="teamCard">
                                    <div class="teamCard__header">
                                        <span class="teamCard__name"><?= htmlspecialchars($team["name"]) ?></span>
                                        <span class="teamCard__date text--xs">Créé le <?= htmlspecialchars(($team["created_at"])) ?></span>
                                        <span class="teamCard__id">#<?= $team["id"] ?></span>
                                    </div>
                                </div>
                            <?php endforeach ?>
                            
                        <?php if ($totalPages > 1): ?>
                            <nav class="pagination">

                                <?php if ($currentPage > 1): ?>
                                    <a class="btn-secondary--sm" href="admin/teams?page=<?= $currentPage - 1 ?>">Précédent</a>
                                <?php else: ?>
                                    <a class="btn-secondary--sm btn--inactive">Précédent</a>
                                <?php endif ?>

                                <span><?= $currentPage ?> / <?= $totalPages ?></span>

                                <?php if ($currentPage < $totalPages): ?>
                                    <a class="btn-secondary--sm" href="admin/teams?page=<?= $currentPage + 1 ?>">Suivant</a>
                                <?php else: ?>
                                    <a class="btn-secondary--sm btn--inactive">Suivant</a>
                                <?php endif ?>

                            </nav>
                        <?php endif ?>

                    <?php endif ?>

                </section>
            </div>

        </div>

    </div>
</div>