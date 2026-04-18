<main class="main">

    <div class="wrapper">

        <section class="main__section section container">

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


                <form class="form" action="/register" method="post">

                    <?php if(isset($validationErrors["firstname"])){ ?>
                    <p class="text--error"><?= $validationErrors["firstname"] ?></p>
                    <?php } ?>
                    <input class="form__input" name="firstname" type="text" placeholder="Votre prénom" <?= $val["firstname"] ?? null ?> required>

                    <?php if(isset($validationErrors["lastname"])){ ?>
                    <p class="text--error"><?= $validationErrors["lastname"] ?></p>
                    <?php } ?>
                    <input class="form__input" name="lastname" type="text" placeholder="Votre nom" <?= $val["lastname"] ?? null ?> required>

                    <?php if(isset($validationErrors["username"])){ ?>
                    <p class="text--error"><?= $validationErrors["username"] ?></p>
                    <?php } ?>
                    <input class="form__input" name="username" type="text" placeholder="Votre pseudo" <?= $val["username"] ?? null ?> required>

                    <?php if(isset($validationErrors["email"])){ ?>
                    <p class="text--error"><?= $validationErrors["email"] ?></p>
                    <?php } ?>
                    <input class="form__input" name="email" type="email" placeholder="Votre email" <?= $val["email"] ?? null ?> required>

                    <?php if(isset($validationErrors["password"])){ ?>
                    <p class="text--error"><?= $validationErrors["password"] ?></p>
                    <?php } ?>
                    <input class="form__input" name="password" type="password" placeholder="Choisir un mot de passe" <?= $val["password"] ?? null ?> required>

                    <button class="form__btn btn-primary" type="submit" >Créer un compte</button>

                </form>

            </div>

        </section>

    </div>

</main>

