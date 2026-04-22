<div class="login page page--static container">

    <div class="page__header">
        <h1 class="page__label page__title">Connexion utilisateur</h1>
        <p class="title-lg">Veuillez renseigner vos informations</p>
    </div>

    <div class="page__content">

        <?php if(isset($_SESSION["error"])): ?>
            <p class="notice--error"><?= $_SESSION["error"] ?></p>
            <?php unset($_SESSION['error']);?>
        <?php endif?>

        <?php if (isset($_SESSION["registerSuccess"])): ?>
            <p class="notice--success"><?= htmlspecialchars($_SESSION["registerSuccess"]) ?></p>
            <?php unset($_SESSION["registerSuccess"]); ?>
        <?php endif ?>
        <form class="form" action="login" method="post">
            
            <div class="form__field">
                <label class="form__label" for="email">Adresse e-mail</label>
                <input id="email" class="form__input" name="email" type="text" required>
            </div>

            <div class="form__field">
                <label class="form__label" for="password">Mot de passe</label>
                <input id=password class="form__input" name="password" type="password" required>
            </div>

            <button class="form__btn btn-primary" type="submit">Se connecter</button>

        </form>
         
    </div>
        
</div>