<main class="main container">
    
    <h1 class="title-md mb-32">Groupes</h1>

    <!-- SOUS MENU DE NAVIGATION -->
    <div class="main__container">
    <aside class="main__nav">
        <nav class="subnav">
            <!-- <p class="section-label">Vos groupes</p> -->
            <ul class="subnav__list">
                <!-- <li class="subnav__item btn-tab btn-tab--active">Groupes</li> -->
                <!-- <li class="subnav__item btn-tab">Invitations</li> -->
                <li class="subnav__item btn-primary--sm"><a href="/team/create">Créer un groupe</a></li>
            </ul>
        </nav>
    </aside>

    <!-- CONTENU DE LA PAGE -->

    <div class="main__content">

        <section class="main__section main__section--first section">

            <div class="section__top">
                <h2 class="section__title title-lg">Liste de vos groupes</h2>
            </div>

            <div class="section__content">
                <?php

                if(!empty($userTeams)){

                    foreach($userTeams as $team){ ?>
                    <div class="teamCard">
                        
                        <h3 class="title-md"><?= htmlspecialchars($team["name"]) ?></h3>
                        <p><?= htmlspecialchars($team["description"]) ?></p>
                        
                        <a class="btn-secondary--sm" href="/team/<?= $team["id"] ?>">Accéder au groupe</a>

                    </div>

                <?php
                    }

                }else{
                    echo "Vous ne faites partie d'aucune équipe";
                }

                ?>
            </div>

        </section>

    </div>
    </div>
    

</main>
