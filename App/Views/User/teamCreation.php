<div class="teamsPanel page page--panel container">

    <div class="page__header">
        <h1 class="title-md mb-32">Création d'un groupe</h1>
    </div>

    <div class="page__panel">

        <?php include 'Partials/_nav.php' ?>

        <div class="page__content panelContent">

            <div class="panelContent__header">
                <h2 class="section__title title-lg">Veuillez renseigner les informations suivantes :</h2>
            </div>

            <div class="panelContent__sections">

                    <?php if (isset($_SESSION["formErrorMessage"])) { ?>
                        <p class="notice--error"><?= $_SESSION["formErrorMessage"] ?></p>
                        <?php unset($_SESSION['formErrorMessage']);
                    } ?>

                    <?php
                    if (!empty($_SESSION["formErrors"])) {
                        $validationErrors = $_SESSION["formErrors"]["errors"];
                        $fieldsValue = $_SESSION["formErrors"]["fieldsValue"];
                        unset($_SESSION['formErrors']);
                    }
                    ?>
                <form class="form" action="team/create" method="post">

                    <div class="form__field">
                        <label class="form__label" for="team-name">Nom du groupe</label>
                        <?php if (isset($validationErrors["name"])) { ?>
                            <p class="text--error" id="team-name-error"><?= $validationErrors["name"] ?></p>
                        <?php } ?>
                        <input class="form__input" id="team-name" name="name" type="text" value="<?= htmlspecialchars($fieldsValue["name"] ?? '') ?>" <?= isset($validationErrors["name"]) ? 'aria-invalid="true" aria-describedby="team-name-error"' : '' ?> required>
                    </div>

                    <div class="form__field">
                        <label class="form__label" for="team-description">Description du groupe</label>
                        <?php if (isset($validationErrors["description"])) { ?>
                            <p class="text--error" id="team-description-error"><?= $validationErrors["description"] ?></p>
                        <?php } ?>
                        <input class="form__input" id="team-description" name="description" type="text" value="<?= htmlspecialchars($fieldsValue["description"] ?? '') ?>" <?= isset($validationErrors["description"]) ? 'aria-invalid="true" aria-describedby="team-description-error"' : '' ?> required>
                    </div>

                    <div class="form__field">
                        <label class="form__label" for="team-duration">Durée d'un cycle</label>
                        <?php if (isset($validationErrors["duration"])) { ?>
                            <p class="text--error" id="team-duration-error"><?= $validationErrors["duration"] ?></p>
                        <?php } ?>
                        <input class="form__input" id="team-duration" name="duration" type="number" min="1" value="<?= htmlspecialchars($fieldsValue["duration"] ?? '') ?>" <?= isset($validationErrors["duration"]) ? 'aria-invalid="true" aria-describedby="team-duration-error"' : '' ?> required>
                    </div>

                    <div class="form__field">
                        <label class="form__label" for="team-treatmentsMax">Nombre d'irritants à traiter simultanément</label>
                        <?php if (isset($validationErrors["treatmentsMax"])) { ?>
                            <p class="text--error" id="team-treatmentsMax-error"><?= $validationErrors["treatmentsMax"] ?></p>
                        <?php } ?>
                        <input class="form__input" id="team-treatmentsMax" name="treatmentsMax" type="number" min="1" value="<?= htmlspecialchars($fieldsValue["treatmentsMax"] ?? '') ?>" <?= isset($validationErrors["treatmentsMax"]) ? 'aria-invalid="true" aria-describedby="team-treatmentsMax-error"' : '' ?> required>
                    </div>

                    <div class="form__field">
                        <label class="form__label" for="team-votingDelay">Délai de vote d'une solution</label>
                        <?php if (isset($validationErrors["votingDelay"])) { ?>
                            <p class="text--error" id="team-votingDelay-error"><?= $validationErrors["votingDelay"] ?></p>
                        <?php } ?>
                        <input class="form__input" id="team-votingDelay" name="votingDelay" type="number" min="1" value="<?= htmlspecialchars($fieldsValue["votingDelay"] ?? '') ?>" <?= isset($validationErrors["votingDelay"]) ? 'aria-invalid="true" aria-describedby="team-votingDelay-error"' : '' ?> required>
                    </div>

                    <button class="form__btn btn-primary" type="submit">Soumettre</button>

                </form>

            </div>

        </div>

    </div>
</div>