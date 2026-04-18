<?php $activeTab = 'members'; ?>

<main class="main container">

    <h1 class="title-md mb-32">GROUPE</h1>

    <div class="main__container">

        <?php include dirname(__DIR__).'/Partials/_nav.php' ?>

        <div class="main__content">
            <section class="main__section section main__section--first">

                <div class="section__top">
                    <h2 class="section__title title-lg">Ajouter un membre</h2>
                    <a class="btn-secondary--sm" href="/team/<?= $teamId ?>/members">Retour</a>
                </div>

                <div class="section__content">

                    <?php if (!empty($formError)): ?>
                        <p class="notice--error"><?= htmlspecialchars($formError) ?></p>
                    <?php endif ?>

                    <?php if (!empty($formSuccess)): ?>
                        <p class="notice--success"><?= htmlspecialchars($formSuccess) ?></p>
                    <?php endif ?>

                    <form class="form" action="/team/<?= $teamId ?>/member/add" method="POST">
                        <input
                            class="form__input <?= !empty($formError) ? 'form__input--error' : '' ?>"
                            name="email"
                            type="email"
                            placeholder="Email du membre"
                            required
                        >
                        <button class="form__btn btn-primary" type="submit">Ajouter</button>
                    </form>

                </div>

            </section>
        </div>

    </div>
</main>