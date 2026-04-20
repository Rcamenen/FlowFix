<?php $activeTab = 'frictions'; ?>

<main id="teamPanel" class="main container">

    <div class="page__header">
        <h1 class="title-md mb-32">GROUPE</h1>
    </div>

    <div class="page__panel">

        <?php include dirname(__DIR__).'/Partials/_nav.php' ?>
        <div class="page__content panelContent">

            <div class="panelContent__header">
                <h2 class="section__title title-lg">Ajouter une solution</h2>
                <a class="btn-secondary--sm" href="team/<?= $teamId ?>/friction/<?= $frictionId ?>">Retour</a>
            </div>

            <div class="panelContent__sections">
                <section class="panelContent__section">

                    <?php if (isset($_SESSION["error"])): ?>
                        <p class="notice--error"><?= $_SESSION["error"] ?></p>
                        <?php unset($_SESSION["error"]) ?>
                    <?php endif ?>

                    <form class="form" action="team/<?= $teamId ?>/friction/<?= $frictionId ?>/treatment/<?= $treatmentId ?>/updatesolution" method="POST">

                        <?php if (isset($validationErrors["solution"])): ?>
                            <p class="form__error-msg"><?= $validationErrors["solution"] ?></p>
                        <?php endif ?>
                        <textarea class="form__input <?= isset($validationErrors["solution"]) ? 'form__input--error' : '' ?>" name="solution" placeholder="Description de la solution" required><?= $val["solution"] ?? null ?></textarea>

                        <button class="form__btn btn-primary" type="submit">Soumettre</button>

                    </form>

                </section>
            </div>

        </div>

    </div>
</main>