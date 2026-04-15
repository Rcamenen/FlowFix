<main class="main container">
    <h1 class="title-md">Vos groupes</h1>

    <!-- MESSAGE DE SUCCES OU D'ERREUR -->



    <?php if(!empty($_SESSION["error"])): ?>
    <div class="container">
            <p class="notice--success"> Vous ne faites pas partie de ce groupe </p>
    </div>
    <?php endif ?>

    <!-- SOUS MENU DE NAVIGATION -->
    <div class="main__container">
    <aside class="main__nav">
        <nav class="subnav">
            <p class="section-label">Vos groupes</p>
            <ul class="subnav__list">
                <li class="subnav__item btn-tab btn-tab--active">Groupes</li>
                <li class="subnav__item btn-tab">Invitations</li>
                <li class="subnav__item btn-primary--sm">Créer un groupe</li>
            </ul>
        </nav>
    </aside>

    <!-- CONTENU DE LA PAGE -->

    <div class="main__content">
        <?php if(!empty($successMessage)): ?>
        <div class="container">
                <p class="notice--success"><?= $successMessage ?></p>
        </div>
        <?php endif ?>
        <section class="main__section main__section--first section">

            <div class="section__top">
                <h2 class="section__title title-lg">Liste de vos groupes</h2>
            </div>

            <!-- message d'erreur -->

            <?php if(isset($_SESSION["error"])){ ?>

                        <p class="notice--error"><?= $_SESSION["error"] ?></p>
                    
            <?php unset($_SESSION['error']) ;} ?>



            <div class="section__content">
                <?php

                if(!empty($userTeams)){

                    foreach($userTeams as $team){ ?>
                    <div class="card--team">

                        <h3 class="title-md"><?= htmlspecialchars($team["name"]) ?></h2>
                        <p><?= htmlspecialchars($team["description"]) ?></p>
                        
                        <a class="btn-secondary" href="/team/<?= $team["id"] ?>">Accéder au groupe</a>

                    </div>

                <?php
                    }

                }else{
                    echo "Vous ne faites partie d'aucune équipe";
                }

                ?>
            </div>

        </section>

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
