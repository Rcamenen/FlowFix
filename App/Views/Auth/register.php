<div class="register page container">

    <div class="wrapper">

        <section class="main__section section">

            <div class="section__top">
                <p class="section-label">Inscription</p>
                <h2 class="section__title title-xl">Veuillez renseigner vos informations</h2>
            </div>

            <!-- message d'erreur -->

            <?php if(isset($_SESSION["error"])){ ?>

                        <p class="notice--error"><?= $_SESSION["error"] ?></p>
                    
            <?php unset($_SESSION['error']) ;} ?>


            <?php if(!empty($_SESSION["formErrors"])){
                    
                    $validationErrors = $_SESSION["formErrors"];
                    unset($_SESSION['formErrors']) ;

            }?>
            <div class="section__content">


                <form class="form" action="register" method="post">

                    <?php if(isset($validationErrors["firstname"])){ ?>
                    <p class="text--error"><?= $validationErrors["firstname"] ?></p>
                    <?php } ?>
                    <input class="form__input" name="firstname" type="text" placeholder="Votre prénom" value="<?= htmlspecialchars($val["firstname"] ?? '') ?>" required>

                    <?php if(isset($validationErrors["lastname"])){ ?>
                    <p class="text--error"><?= $validationErrors["lastname"] ?></p>
                    <?php } ?>
                    <input class="form__input" name="lastname" type="text" placeholder="Votre nom" value="<?= htmlspecialchars($val["lastname"] ?? '') ?>" required>

                    <?php if(isset($validationErrors["username"])){ ?>
                    <p class="text--error"><?= $validationErrors["username"] ?></p>
                    <?php } ?>
                    <input class="form__input" name="username" type="text" placeholder="Votre pseudo" value="<?= htmlspecialchars($val["username"] ?? '') ?>" required>

                    <?php if(isset($validationErrors["email"])){ ?>
                    <p class="text--error"><?= $validationErrors["email"] ?></p>
                    <?php } ?>
                    <input class="form__input" name="email" type="email" placeholder="Votre email" value="<?= htmlspecialchars($val["email"] ?? '') ?>" required>

                    <?php if(isset($validationErrors["password"])){ ?>
                    <p class="text--error"><?= $validationErrors["password"] ?></p>
                    <?php } ?>
                    <input class="form__input" name="password" type="password" placeholder="Choisir un mot de passe" required>

                    <button class="form__btn btn-primary" type="submit">Créer un compte</button>

                </form>

            </div>

        </section>

    </div>

</div>

