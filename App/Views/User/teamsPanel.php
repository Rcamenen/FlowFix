<?php $activeTab = 'teams'; ?>

<div class="teamsPanel container">

    <div class="page__header">
        <h1 class="title-md mb-32">Groupes</h1>
    </div>

    <!-- SOUS MENU DE NAVIGATION -->
    <div class="page__panel">

        <?php include 'Partials/_nav.php' ?>

        <!-- CONTENU DE LA PAGE -->
        <div class="page__content panelContent">

            <div class="panelContent__header">
                <h2 class="section__title title-lg">Liste de vos groupes</h2>
            </div>

            <div class="panelContent__sections">
                <section class="panelContent__section">

                    <?php

                    if(!empty($userTeams)){

                        foreach($userTeams as $team){ ?>
                        <div class="teamCard">

                            <h3 class="title-md"><?= htmlspecialchars($team["name"]) ?></h3>
                            <p><?= htmlspecialchars($team["description"]) ?></p>

                            <a class="btn-secondary--sm" href="team/<?= $team["id"] ?>">Accéder au groupe</a>

                        </div>

                    <?php
                        }

                    }else{
                        echo "Vous ne faites partie d'aucune équipe";
                    }

                    ?>

                </section>
            </div>

        </div>

    </div>

</div>