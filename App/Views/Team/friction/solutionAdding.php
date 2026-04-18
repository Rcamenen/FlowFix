<?php $activeTab = 'frictions'; ?>

<main class="main container">

    <h1 class="title-md mb-32">GROUPE</h1>

    <div class="main__container">

        <?php include dirname(__DIR__).'/Partials/_nav.php' ?>

        <div class="main__content">
            <section class="main__section section main__section--first">

                <div class="section__top">
                    <h2 class="section__title title-lg">Ajouter une solution</h2>
                    <a class="btn-secondary--sm" href="/team/<?= $teamId ?>/friction/<?= $frictionId ?>">Retour</a>
                </div>

                <div class="section__content">

                    <?php if (isset($_SESSION["error"])): ?>
                        <p class="notice--error"><?= $_SESSION["error"] ?></p>
                        <?php unset($_SESSION["error"]) ?>
                    <?php endif ?>

                    <form class="form" action="/team/<?= $teamId ?>/friction/<?= $frictionId ?>/treatment/<?= $treatmentId ?>/updatesolution" method="POST">

                        <?php if (isset($validationErrors["solution"])): ?>
                            <p class="form__error-msg"><?= $validationErrors["solution"] ?></p>
                        <?php endif ?>
                        <textarea class="form__input <?= isset($validationErrors["solution"]) ? 'form__input--error' : '' ?>" name="solution" placeholder="Description de la solution" required><?= $val["solution"] ?? null ?></textarea>

                        <button class="form__btn btn-primary" type="submit">Soumettre</button>

                    </form>

                </div>

            </section>
        </div>

    </div>
</main>