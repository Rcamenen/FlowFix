<div class="register page page--static container">

    <div class="page__header">
        <h1 class="page__label page__title">Création d'un compte</h1>
        <p class="title-lg">Veuillez renseigner vos informations</p>
    </div>

    <div class="page__content">

        <?php if (isset($_SESSION["error"])) { ?>
            <p class="notice--error"><?= $_SESSION["error"] ?></p>
        <?php unset($_SESSION['error']); } ?>

        <?php
            if (!empty($_SESSION["formErrors"])) {
                $validationErrors = $_SESSION["formErrors"];
                unset($_SESSION['formErrors']);
            }
        ?>

        <form class="form" action="register" method="post">

            <?php if (isset($validationErrors["firstname"])) { ?>
                <p class="text--error"><?= $validationErrors["firstname"] ?></p>
            <?php } ?>
            <input class="form__input" name="firstname" type="text" placeholder="Votre prénom" value="<?= htmlspecialchars($val["firstname"] ?? '') ?>" required>

            <?php if (isset($validationErrors["lastname"])) { ?>
                <p class="text--error"><?= $validationErrors["lastname"] ?></p>
            <?php } ?>
            <input class="form__input" name="lastname" type="text" placeholder="Votre nom" value="<?= htmlspecialchars($val["lastname"] ?? '') ?>" required>

            <?php if (isset($validationErrors["username"])) { ?>
                <p class="text--error"><?= $validationErrors["username"] ?></p>
            <?php } ?>
            <input class="form__input" name="username" type="text" placeholder="Votre pseudo" value="<?= htmlspecialchars($val["username"] ?? '') ?>" required>

            <?php if (isset($validationErrors["email"])) { ?>
                <p class="text--error"><?= $validationErrors["email"] ?></p>
            <?php } ?>
            <input class="form__input" name="email" type="email" placeholder="Votre email" value="<?= htmlspecialchars($val["email"] ?? '') ?>" required>

            <?php if (isset($validationErrors["password"])) { ?>
                <p class="text--error"><?= $validationErrors["password"] ?></p>
            <?php } ?>
            <input class="form__input" name="password" type="password" placeholder="Choisir un mot de passe" required><label class="form__checkbox">
                <input type="checkbox" name="privacy" value="1" <?= !empty($val["privacy"]) ? 'checked' : '' ?> required>
                <span>J'accepte la <a href="privacy" target="_blank">politique de confidentialité</a></span>
            </label>

            <button class="form__btn btn-primary" type="submit">Créer un compte</button>

        </form>

    </div>

</div>