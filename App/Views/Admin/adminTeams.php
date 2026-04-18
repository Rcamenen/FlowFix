<?php $activeTab = 'teams'; ?>

<main id="admin" class="main container">

    <h1 class="title-md mb-32">ADMINISTRATION</h1>

    <div class="main__container">

        <?php include dirname(__DIR__) . '/Admin/Partials/_nav.php' ?>

        <div class="main__content">
            <section class="main__section section main__section--first">

                <div class="section__top">
                    <h2 class="section__title title-lg">Liste des groupes</h2>
                </div>

                <div class="section__content">

                    <?php if (empty($teams)): ?>

                        <p class="notice--info">Aucun groupe trouvé.</p>

                    <?php else: ?>

                        <div class="grid">
                            <?php foreach ($teams as $team): ?>
                                <div class="teamCard">
                                    <div class="teamCard__header">
                                        <span class="teamCard__name"><?= htmlspecialchars($team["name"]) ?></span>
                                        <span class="teamCard__id">#<?= $team["id"] ?></span>
                                    </div>
                                    <div class="teamCard__footer">
                                        <a class="btn-secondary--sm" href="/team/<?= $team["id"] ?>">Voir</a>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </div>

                        <?php if ($totalPages > 1): ?>
                            <nav class="pagination">

                                <?php if ($currentPage > 1): ?>
                                    <a class="btn-secondary--sm" href="/admin/teams?page=<?= $currentPage - 1 ?>">Précédent</a>
                                <?php else: ?>
                                    <a class="btn-secondary--sm btn--inactive">Précédent</a>
                                <?php endif ?>

                                <span><?= $currentPage ?> / <?= $totalPages ?></span>

                                <?php if ($currentPage < $totalPages): ?>
                                    <a class="btn-secondary--sm" href="/admin/teams?page=<?= $currentPage + 1 ?>">Suivant</a>
                                <?php else: ?>
                                    <a class="btn-secondary--sm btn--inactive">Suivant</a>
                                <?php endif ?>

                            </nav>
                        <?php endif ?>

                    <?php endif ?>

                </div>

            </section>
        </div>

    </div>
</main>