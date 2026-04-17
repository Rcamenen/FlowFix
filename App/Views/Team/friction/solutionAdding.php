
<main>
    <div class="wrapper">

        <section class="main__section section container">

            <div class="section__top">
                <p class="section-label">Ajouter une solution</p>
                <h2 class="section__title title-xl">Veuillez renseigner le champs ci-dessous</h2>
            </div>

            <!-- message d'erreur -->

            <?php if(isset($_SESSION["error"])){ ?>

                    <div class="card--error">
                        <p><?= $_SESSION["error"] ?></p>
                    </div>
                    
            <?php unset($_SESSION['error']) ;} ?>



            <div class="section__content">

                <form class="form" action="/team/<?= $teamId ?>/friction/<?= $frictionId ?>/treatment/<?= $treatmentId ?>/updatesolution" method="post">

                    <p><?php if(isset($validationErrors["solution"])) echo $validationErrors["solution"];?> </p>
                    <textarea class="form__input" name="solution" placeholder="Description de la solution" <?= $val["solution"] ?? null ?> required></textarea>

                    <button class="form__btn btn-primary" type="submit" >Soumettre</button>

                </form>

            </div>

        </section>

    </div>

</main>
