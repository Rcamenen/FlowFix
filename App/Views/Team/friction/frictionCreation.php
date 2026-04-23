<?php $activeTab = 'frictions'; ?>

<div class="page page--panel teamPanel container">

    <div class="page__header">
        <h1 class="title-md mb-32">GROUPE</h1>
    </div>

    <div class="page__panel">

        <?php include dirname(__DIR__).'/Partials/_nav.php' ?>
        <div class="page__content panelContent">

            <div class="panelContent__header">
                <h2 class="section__title title-lg">Ajouter un irritant</h2>
            </div>

            <div class="panelContent__sections">

                <?php if (isset($_SESSION["formErrorMessage"])) { ?>
                    <p class="notice--error"><?= $_SESSION["formErrorMessage"] ?></p>
                <?php unset($_SESSION['formErrorMessage']); } ?>

                <?php
                    if (!empty($_SESSION["formErrors"])) {
                        $validationErrors = $_SESSION["formErrors"]["errors"];
                        $fieldsValue = $_SESSION["formErrors"]["fieldsValue"];
                        unset($_SESSION['formErrors']);
                    }
                ?>

                    <form class="form" action="team/<?= $teamId ?>/friction/create" method="post">

                    <div class="form__field">
                        <label class="form__label" for="friction-title">Titre de l'irritant</label>
                        <?php if (isset($validationErrors["title"])) { ?>
                            <p class="text--error" id="friction-title-error"><?= $validationErrors["title"] ?></p>
                        <?php } ?>
                        <input class="form__input" id="friction-title" name="title" type="text" value="<?= htmlspecialchars($fieldsValue["title"] ?? '') ?>" <?= isset($validationErrors["title"]) ? 'aria-invalid="true" aria-describedby="friction-title-error"' : '' ?> required>
                    </div>

                    <div class="form__field">
                        <label class="form__label" for="friction-description">Description du problème rencontré</label>
                        <?php if (isset($validationErrors["description"])) { ?>
                            <p class="text--error" id="friction-description-error"><?= $validationErrors["description"] ?></p>
                        <?php } ?>
                        <textarea class="form__input" id="friction-description" name="description" <?= isset($validationErrors["description"]) ? 'aria-invalid="true" aria-describedby="friction-description-error"' : '' ?> required><?= htmlspecialchars($fieldsValue["description"] ?? '') ?></textarea>
                    </div>

                    <button class="form__btn btn-primary" type="submit">Soumettre</button>

                </form>

            </div>

        </div>

    </div>
</div>