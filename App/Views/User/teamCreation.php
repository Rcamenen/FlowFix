<main class="main container">
    
    <h1 class="title-md mb-32">Création d'un groupe</h1>
    <div class="main__container">
        <div class="main__content">
            
            <section class="main__section section container">

                        <div class="section__top">
                            <p class="section-label">Créer un groupe</p>
                            <h2 class="section__title title-lg">Veuillez renseigner les informations suivantes :</h2>
                        </div>

                        <!-- message d'erreur -->

                        <?php if(isset($_SESSION["error"])){ ?>

                                <div class="card--error">
                                    <p><?= $_SESSION["error"] ?></p>
                                </div>
                                
                        <?php unset($_SESSION['error']) ;} ?>



                        <div class="section__content">
                            <form class="form" action="/team/create" method="post">
                                <div class="form_row">
                                    <label class="text--xs" for="name">Nom du groupe</label>
                                    <input class="form__input" id="name" name="name" type="text">
                                </div>

                                <div class="form__row">
                                    <label class="text--xs" for="description">Description du groupe</label>
                                    <input class="form__input" id="description" name="description" type="text">
                                </div>

                                <div class="form__row">
                                    <label class="text--xs" for="duration">Durée d'un cycle</label>
                                    <input class="form__input" id="duration" name="duration" type="number">
                                </div>

                                <div class="form__row">
                                    <label class="text--xs" for="treatmentsMax">Nombre de friction à traiter simultanement</label>
                                    <input class="form__input" id="treatmentsMax" name="treatmentsMax" type="number">
                                </div>

                                <div class="form__row">
                                    <label class="text--xs" for="votingDelay">Délais de vote d'une solution</label>
                                    <input class="form__input" id="votingDelay" name="votingDelay" type="number">
                                </div>

                                <button class="btn-primary" type="submit" >Soumettre</button>

                            </form>
                        </div>

            </section>
        </div>
    </div>
</main>