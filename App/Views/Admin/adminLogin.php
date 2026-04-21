<div class="adminlogin">
    <div class="wrapper">

        <section class="main__section section container">

            <div class="section__top">
                <p class="section-label">Connexion</p>
                <h2 class="section__title title-xl">Veuillez renseigner vos informations</h2>
            </div>

            <?php if(isset($_SESSION["error"])){ ?>

            <div class="notice--error">
                <p><?= $_SESSION["error"] ?></p>
            </div>
                    
            <?php unset($_SESSION['error']) ;} ?>

            <div class="section__content">
                <form class="form" action="adminLogin" method="post">

                    <input class="form__input" name="email" type="text" placeholder="Email" required>
                    <input class="form__input" name="password" type="password" placeholder="Mot de passe" required>

                    <button class="form__btn btn-primary" type="submit">Se connecter</button>

                </form>
            </div>

        </section>

    </div>

</div>