<div class="login page page--static container">

    <div class="page__header">
        <h1 class="page__label page__title">Connexion utilisateur</h1>
        <p class="title-lg">Veuillez renseigner vos informations</p>
    </div>

    <div class="page__content">

            <!-- message d'erreur -->

            <?php if(isset($_SESSION["error"])){ ?>

            <div class="notice--error">
                <p><?= $_SESSION["error"] ?></p>
            </div>
                    
            <?php unset($_SESSION['error']); } ?>

            <div class="section__content">
                <form class="form" action="login" method="post">

                    <input class="form__input" name="email" type="text" placeholder="Email" required>
                    <input class="form__input" name="password" type="password" placeholder="Mot de passe" required>

                    <button class="form__btn btn-primary" type="submit">Se connecter</button>

                </form>
            </div>
    </div>
        
</div>