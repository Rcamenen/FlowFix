<?php $activeTab = 'users'; ?>

<main id="adminPanel" class="main container">

    <div class="page__header">
        <h1 class="title-md mb-32">ADMINISTRATION</h1>
    </div>

    <div class="page__panel">

        <?php include dirname(__DIR__) . '/Admin/Partials/_nav.php' ?>
        <div class="page__content panelContent">

            <div class="panelContent__header">
                <h2 class="section__title title-lg">Liste des utilisateurs</h2>
            </div>

            <div class="panelContent__sections">
                <section class="panelContent__section">

                    <?php if (empty($users)): ?>

                        <p class="notice--info">Aucun utilisateur trouvé.</p>

                    <?php else: ?>

                        <div class="grid">
                            <?php foreach ($users as $user): ?>
                                <div class="userCard">
                                    <div class="userCard__header">
                                        <span class="userCard__username"><?= htmlspecialchars($user["username"]) ?></span>
                                        <span class="userCard__id">#<?= $user["id"] ?></span>
                                    </div>
                                    <div class="userCard__email"><?= htmlspecialchars($user["email"]) ?></div>
                                    <div class="userCard__footer">
                                        <span class="userCard__date"><?= (new DateTime($user["registered_at"]))->format('d-m-Y') ?></span>
                                        <a class="btn-danger--sm" href="/admin/user/<?= $user["id"] ?>/delete">Supprimer</a>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </div>

                        <?php if ($totalPages > 1): ?>
                            <nav class="pagination">

                                <?php if ($currentPage > 1): ?>
                                    <a class="btn-secondary--sm" href="/admin/users?page=<?= $currentPage - 1 ?>">Précédent</a>
                                <?php else: ?>
                                    <a class="btn-secondary--sm btn--inactive">Précédent</a>
                                <?php endif ?>

                                <span><?= $currentPage ?> / <?= $totalPages ?></span>

                                <?php if ($currentPage < $totalPages): ?>
                                    <a class="btn-secondary--sm" href="/admin/users?page=<?= $currentPage + 1 ?>">Suivant</a>
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
</main>