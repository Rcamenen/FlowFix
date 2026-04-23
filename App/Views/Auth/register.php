<div class="register page page--static container">

    <div class="page__header">
        <h1 class="page__label page__title">Création d'un compte</h1>
        <p class="title-lg">Veuillez renseigner vos informations</p>
    </div>

    <div class="page__content">

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

        <form class="form" action="register" method="post">

            <div class="form__field">
                <label class="form__label" for="register-firstname">Prénom</label>
                <?php if (isset($validationErrors["firstname"])) { ?>
                    <p class="text--error" id="register-firstname-error"><?= $validationErrors["firstname"] ?></p>
                <?php } ?>
                <input class="form__input" id="register-firstname" name="firstname" type="text" autocomplete="given-name" value="<?= htmlspecialchars($fieldsValue["firstname"] ?? '') ?>" <?= isset($validationErrors["firstname"]) ? 'aria-invalid="true" aria-describedby="register-firstname-error"' : '' ?> required>
            </div>

            <div class="form__field">
                <label class="form__label" for="register-lastname">Nom</label>
                <?php if (isset($validationErrors["lastname"])) { ?>
                    <p class="text--error" id="register-lastname-error"><?= $validationErrors["lastname"] ?></p>
                <?php } ?>
                <input class="form__input" id="register-lastname" name="lastname" type="text" autocomplete="family-name" value="<?= htmlspecialchars($fieldsValue["lastname"] ?? '') ?>" <?= isset($validationErrors["lastname"]) ? 'aria-invalid="true" aria-describedby="register-lastname-error"' : '' ?> required>
            </div>

            <div class="form__field">
                <label class="form__label" for="register-username">Pseudo</label>
                <?php if (isset($validationErrors["username"])) { ?>
                    <p class="text--error" id="register-username-error"><?= $validationErrors["username"] ?></p>
                <?php } ?>
                <input class="form__input" id="register-username" name="username" type="text" autocomplete="username" value="<?= htmlspecialchars($fieldsValue["username"] ?? '') ?>" <?= isset($validationErrors["username"]) ? 'aria-invalid="true" aria-describedby="register-username-error"' : '' ?> required>
            </div>

            <div class="form__field">
                <label class="form__label" for="register-email">Adresse e-mail</label>
                <?php if (isset($validationErrors["email"])) { ?>
                    <p class="text--error" id="register-email-error"><?= $validationErrors["email"] ?></p>
                <?php } ?>
                <input class="form__input" id="register-email" name="email" type="email" autocomplete="email" value="<?= htmlspecialchars($fieldsValue["email"] ?? '') ?>" <?= isset($validationErrors["email"]) ? 'aria-invalid="true" aria-describedby="register-email-error"' : '' ?> required>
            </div>

            <div class="form__field">
                <label class="form__label" for="register-password">Mot de passe</label>
                <?php if (isset($validationErrors["password"])) { ?>
                    <p class="text--error" id="register-password-error"><?= $validationErrors["password"] ?></p>
                <?php } ?>
                <input class="form__input" id="register-password" name="password" type="password" autocomplete="new-password" <?= isset($validationErrors["password"]) ? 'aria-invalid="true" aria-describedby="register-password-error"' : '' ?> required>
            </div>

            <div class="form__field">
                <label class="form__checkbox">
                    <input type="checkbox" name="privacy" value="1" <?= !empty($fieldsValue["privacy"]) ? 'checked' : '' ?> required>
                    <span>J'accepte la <a href="privacy" target="_blank" rel="noopener noreferrer">politique de confidentialité</a> (nouvelle fenêtre)</span>
                </label>
            </div>

            <button class="form__btn btn-primary" type="submit">Créer un compte</button>

        </form>

    </div>

</div>