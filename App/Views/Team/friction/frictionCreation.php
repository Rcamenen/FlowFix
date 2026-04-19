<?php $activeTab = 'frictions'; ?>

<main class="main container">

    <h1 class="title-md mb-32">GROUPE</h1>

    <div class="main__container">

        <?php include dirname(__DIR__).'/Partials/_nav.php' ?>

            <section class="main__section section main__section--first">

                <div class="section__top">
                    <h2 class="section__title title-lg">Ajouter un irritant</h2>
                </div>

                <div class="section__content">

                    <?php if (isset($_SESSION["error"])): ?>
                        <p class="notice--error"><?= $_SESSION["error"] ?></p>
                        <?php unset($_SESSION["error"]) ?>
                    <?php endif ?>

                    <form class="form" action="/team/<?= $teamId ?>/friction/create" method="POST">

                        <?php if (isset($validationErrors["title"])): ?>
                            <p class="form__error-msg"><?= $validationErrors["title"] ?></p>
                        <?php endif ?>
                        <input class="form__input <?= isset($validationErrors["title"]) ? 'form__input--error' : '' ?>" name="title" type="text" placeholder="Titre de l'irritant" <?= $val["title"] ?? null ?> required>

                        <?php if (isset($validationErrors["description"])): ?>
                            <p class="form__error-msg"><?= $validationErrors["description"] ?></p>
                        <?php endif ?>
                        <textarea class="form__input <?= isset($validationErrors["description"]) ? 'form__input--error' : '' ?>" name="description" placeholder="Description du problème rencontré" required><?= $val["description"] ?? null ?></textarea>

                        <button class="form__btn btn-primary" type="submit">Soumettre</button>

                    </form>

                </div>

            </section>

    </div>
</main>