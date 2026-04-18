<?php
    $labelClassMap = [
        'Non traité'    => 'totreat',
        'En cours' => 'inprogress',
        'En vote'     => 'invote',
        'Clos'     => 'closed',
        'Validé' => 'validate',
        'À valider' => 'closed',
    ];
    echo $teamId;
?>





<main class="main container" data-team-id=<?= $teamId ?>>

    <h1 class="section-label">Irritant</h1>
    <!-- MESSAGE DE SUCCES OU D'ERREUR -->

    <!-- SOUS MENU DE NAVIGATION -->
    <div class="main__container">

        <div class="main__content">

            <section  class="main__section section main__section--first">

                <div class="section__top">
                    <h2 class="section__title title-lg">Détails de l'irritant</h2>
                </div>

                <div class="section__content">

                    <div class="card">
                        <div class="card__header">
                            <h3><?= $friction["title"] ?></h3>
                            <p class="text--xs">Ajouter le <?= new DateTime($friction["created_at"])->format("d-m-Y") ?> par <?= $friction["author"] ?></p>
                            <p class="badge badge--<?= $labelClassMap[$friction["statusLabel"]] ?>"><?= $friction["statusLabel"] ?></p>
                        </div>
                        <p><?= $friction["description"] ?></p>

                        <?php 
                        
                            if(!($friction["isAlreadyVoted"] || $friction["statusLabel"]!="Non traité")):?> //Si l'irritant n'est pas en cours ou pas déjà voté

                            <form action="/team/<?= $teamId ?>/friction/<?= $friction["id"] ?>/vote" method="post">
                                <button type="submit">Voter</button>
                            </form>

                        <?php endif?>

                    </div>

                </div>       

            </section>

            <section  class="main__section section main__section--first">

                <div class="section__top">
                    <?php if(isset($treatments)):?>
                    <h2 class="section__title title-lg">Détails du traitement</h2>
                    <?php else :?>
                    <h2 class="section__title title-lg">Aucun traitement</h2>
                    <p class="text--xs">L'irritant n'a jamais été traité</p>
                    <?php endif ?>
                </div>

                <div class="section__content">

                        <?php if(isset($treatments)){ 
                            foreach($treatments as $treatment){?>
                        <div class="card">
                            <?php if($treatment["cycleId"] == $cycleId): ?>
                            <h3>Traitement en cours :</h3>
                            <?php else:?>
                            <h3>Traitement du cycle <?= $treatment["cycleId"] ?></h3>
                            <?php endif?>    
                            <p><?= $treatment["solution"] ?></p>
                            <?php if($treatment["statusLabel"]=="En cours" && $treatment["pilotId"]==$memberId): ?>
                                <a href="/team/<?php echo $teamId ?>/friction/<?= $friction["id"] ?>/treatment/<?= $treatment["id"] ?>/updatesolution" class="btn-primary--sm mt-8">Ajouter une solution</a>
                            <?php endif?>
                            <p><?= $treatment["created_at"] ?></p>
                            <p><?= $treatment["updated_at"] ?? "Pas d'update" ?></p>
                            <p><?= $treatment["pilot"] ?></p>
                            <p class="badge badge--<?= $labelClassMap[$treatment["statusLabel"]] ?>"><?= $treatment["statusLabel"] ?></p>
                            <form class="btn-primary--sm mt-8" action="/team/<?= $teamId ?>/friction/<?= $friction["id"] ?>/treatment/<?= $treatment["id"] ?>/vote" method="post">
                                <button type="submit">Voter</button>
                            </form>
                        </div>
                        <?php }} ?>

                </div>       

            </section>
            
        </div>

    </div>
</main>