<?php $activeTab = 'frictions'; ?>

<div class="page page--panel teamPanel container">

    <div class="page__header">
        <h1 class="title-md mb-32">GROUPE</h1>
    </div>

    <div class="page__panel">

        <?php include dirname(__DIR__) . '/Partials/_nav.php' ?>

        <div class="page__content panelContent">

            <div class="panelContent__header">
                <h2 class="section__title title-lg">Ajouter une solution</h2>
                <a class="btn-secondary--sm" href="team/<?= $teamId ?>/friction/<?= $frictionId ?>">Retour</a>
            </div>

            <div class="panelContent__sections">
                <section class="panelContent__section">

                    <?php if (isset($_SESSION["formErrorMessage"])) { ?>
                        <p class="notice--error"><?= $_SESSION["formErrorMessage"] ?></p>
                    <?php unset($_SESSION['error']);
                    } ?>

                    <?php
                    if (!empty($_SESSION["formErrors"])) {
                        $validationErrors = $_SESSION["formErrors"]["errors"];
                        $fieldsValue = $_SESSION["formErrors"]["fieldsValue"];
                        unset($_SESSION['formErrors']);
                    }
                    ?>

                    <form class="form" action="team/<?= $teamId ?>/friction/<?= $frictionId ?>/treatment/<?= $treatmentId ?>/updatesolution" method="post">

                        <div class="form__field">
                            <label class="form__label" for="treatment-solution">Description de la solution</label>
                            <?php if (isset($validationErrors["solution"])) { ?>
                                <p class="text--error" id="treatment-solution-error"><?= $validationErrors["solution"] ?></p>
                            <?php } ?>
                            <textarea class="form__input" id="treatment-solution" name="solution" <?= isset($validationErrors["solution"]) ? 'aria-invalid="true" aria-describedby="treatment-solution-error"' : '' ?> required><?= htmlspecialchars($fieldsValue["solution"] ?? '') ?></textarea>
                        </div>

                        <button class="form__btn btn-primary" type="submit">Soumettre</button>

                    </form>

                </section>
            </div>

        </div>

    </div>
</div>