<?php $activeTab = 'members'; ?>

<main id="teamPanel" class="main container">

    <div class="page__header">
        <h1 class="title-md mb-32">GROUPE</h1>
    </div>

    <div class="page__panel">

        <?php include dirname(__DIR__).'/Partials/_nav.php' ?>
        <div class="page__content panelContent">

            <div class="panelContent__header">
                <h2 class="section__title title-lg">Ajouter un membre</h2>
                <a class="btn-secondary--sm" href="team/<?= $teamId ?>/members">Retour</a>
            </div>

            <div class="panelContent__sections">
                <section class="panelContent__section">

                    <?php if (!empty($formError)): ?>
                        <p class="notice--error"><?= htmlspecialchars($formError) ?></p>
                    <?php endif ?>

                    <?php if (!empty($formSuccess)): ?>
                        <p class="notice--success"><?= htmlspecialchars($formSuccess) ?></p>
                    <?php endif ?>

                    <form class="form" action="team/<?= $teamId ?>/member/add" method="POST">
                        <input
                            class="form__input <?= !empty($formError) ? 'form__input--error' : '' ?>"
                            name="email"
                            type="email"
                            placeholder="Email du membre"
                            required
                        >
                        <button class="form__btn btn-primary" type="submit">Ajouter</button>
                    </form>

                </section>
            </div>

        </div>

    </div>
</main>