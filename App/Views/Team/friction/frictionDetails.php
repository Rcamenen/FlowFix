<?php if(isset($data))extract($data); // extraction des données pour accès direct aux variables ?>
<H2>FRICTION</H2>
<div class="teamCard">

    <h3><?= $friction["title"] ?></h3>
    <p><?= $friction["description"] ?></p>
    <p><?= $friction["created_at"] ?></p>
    <p><?= $friction["updated_at"] ?? "Pas d'update" ?></p>
    <p><?= $friction["author"] ?></p>
    <p><?= $friction["statusLabel"] ?></p>

    <?php 
    
        if($friction["isAlreadyVoted"]) echo "Vous avez déjà voté pour cet irritant !";
        else echo "Vous n'avez pas encore voté pour cet irritant !";

    ?>

    <form action="/team/<?= $teamId ?>/friction/<?= $friction["id"] ?>/vote" method="post">
    <button type="submit">Voter</button>
    </form>

</div>






<?php if(isset($treatments)){ 
    foreach($treatments as $treatment){?>
<div class="teamCard">
    <h3>LAST TREATMENT</h3>
    <p><?= $treatment["solution"] ?></p>
    <p><?= $treatment["created_at"] ?></p>
    <p><?= $treatment["updated_at"] ?? "Pas d'update" ?></p>
    <p><?= $treatment["pilot"] ?></p>
    <p><?= $treatment["statusLabel"] ?></p>
</div>
<?php }} ?>