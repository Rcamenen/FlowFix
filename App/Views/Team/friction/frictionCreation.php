<main>
    <div class="wrapper">

        <section class="main__section section container">

            <div class="section__top">
                <p class="section-label">Ajouter un irritant</p>
                <h2 class="section__title title-xl">Veuillez renseigner les champs</h2>
            </div>

            <!-- message d'erreur -->

            <?php if(isset($_SESSION["error"])){ ?>

                    <div class="card--error">
                        <p><?= $_SESSION["error"] ?></p>
                    </div>
                    
            <?php unset($_SESSION['error']) ;} ?>



            <div class="section__content">

                <form class="form" action="/team/<?= $teamId ?>/friction/create" method="post">

                    <p><?php if(isset($validationErrors["title"])) echo $validationErrors["title"];?> </p>
                    <input class="form__input" name="title" type="text" placeholder="Titre de l'irritant" <?= $val["title"] ?? null ?> required>

                    <p><?php if(isset($validationErrors["description"])) echo $validationErrors["description"];?> </p>
                    <textarea class="form__input" name="description" placeholder="Description du problème rencontré" <?= $val["description"] ?? null ?> required></textarea>

                    <button class="form__btn btn-primary" type="submit" >Soumettre</button>

                </form>

            </div>

        </section>

    </div>

</main>
