<main id="teamsPanel" class="main container">

    <div class="page__header">
        <h1 class="title-md mb-32">Création d'un groupe</h1>
    </div>

    <div class="page__panel">

        <aside class="main__nav">
            <nav class="subnav">
                <!-- <p class="section-label">Vos groupes</p> -->
                <ul class="subnav__list">
                    <li class="subnav__item btn-tab btn-tab--active">Groupes</li>
                    <!-- <li class="subnav__item btn-tab">Invitations</li> -->
                    <li class="subnav__item btn-primary--sm"><a href="/team/create">Créer un groupe</a></li>
                </ul>
            </nav>
        </aside>

        <div class="page__content panelContent">

            <div class="panelContent__header">
                <p class="section-label">Créer un groupe</p>
                <h2 class="section__title title-lg">Veuillez renseigner les informations suivantes :</h2>
            </div>

            <div class="panelContent__sections">
                <section class="panelContent__section">

                    <!-- message d'erreur -->

                    <?php if(isset($_SESSION["error"])){ ?>

                        <div class="card--error">
                            <p><?= $_SESSION["error"] ?></p>
                        </div>

                    <?php unset($_SESSION['error']) ;} ?>

                    <form class="form" action="/team/create" method="post">
                        <div class="form__row">
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

                </section>
            </div>

        </div>

    </div>
</main>