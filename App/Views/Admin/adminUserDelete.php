<?php $activeTab = 'users'; ?>

<main id="adminPanel" class="main container">

    <div class="page__header">
        <h1 class="title-md mb-32">ADMINISTRATION</h1>
    </div>

    <div class="page__panel">

        <?php include dirname(__DIR__) . '/Admin/Partials/_nav.php' ?>
        <div class="page__content panelContent">

            <div class="panelContent__header">
                <h2 class="section__title title-lg">Supprimer un utilisateur</h2>
                <a class="btn-secondary--sm" href="admin/users">Retour</a>
            </div>

            <div class="panelContent__sections">
                <section class="panelContent__section">

                    <div class="card">
                        <div class="card__header">
                            <h3><?= htmlspecialchars($user["username"]) ?> <span class="userCard__id">#<?= $user["id"] ?></span></h3>
                            <p><?= htmlspecialchars($user["email"]) ?></p>
                            <p class="text--xs">Inscrit le <?= (new DateTime($user["registered_at"]))->format('d-m-Y') ?></p>
                        </div>
                    </div>

                    <p class="notice--error">Cette action est irréversible. L'utilisateur sera supprimé définitivement.</p>

                    <form action="/admin/user/<?= $user["id"] ?>/delete" method="POST">
                        <button class="btn-danger" type="submit">Confirmer la suppression</button>
                    </form>

                </section>
            </div>

        </div>

    </div>
</main>