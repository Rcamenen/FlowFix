<div class="adminlogin page page--static container">

    <div class="page__header">
        <h1 class="page__label page__title">Connexion administrateur</h1>
        <p class="title-lg">Veuillez renseigner vos informations</p>
    </div>

    <div class="page__content">

    <?php if(isset($_SESSION["error"])): ?>
        <p class="notice--error"><?= $_SESSION["error"] ?></p>
        <?php unset($_SESSION['error']); ?>
    <?php endif?>

    <form class="form" action="adminLogin" method="post" novalidate>

        <div class="form__field">
            <label class="form__label" for="admin-email">Adresse e-mail</label>
            <input class="form__input" id="admin-email" name="email" type="email" autocomplete="username" required aria-required="true">
        </div>

        <div class="form__field">
            <label class="form__label" for="admin-password">Mot de passe</label>
            <input class="form__input" id="admin-password" name="password" type="password" autocomplete="current-password" required aria-required="true">
        </div>

        <button class="form__btn btn-primary" type="submit">Se connecter</button>

    </form>

    </div>

</div>