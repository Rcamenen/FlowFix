<h1>TEAM</h1>

<?php 


    // echo "Data : <br>";
    // var_dump($data);

    // if(isset($data))extract($data); // extraction des données pour accès direct aux variables

    echo "<br>";

?>

<h2>IRRITANT TO PILOT</h2>

<?php 
if(isset($frictionsToPilot)){

    foreach($frictionsToPilot as $friction){
        
?>

<div class="teamCard">

    <h2><?= $friction["title"] ?></h2>
    <p><?= $friction["description"] ?></p>
    <a href="/team/<?= $friction["team_id"]?>/friction/<?= $friction["id"]?>" > Voir l'irritant </a>

</div>

<?php
    }

} ?>

<h2>IRRITANT IN PROGRESS</h2>

<?php 
if(isset($frictionsInProgress)){

    foreach($frictionsInProgress as $friction){
        
?>

<div class="teamCard">

    <h2><?= $friction["title"] ?></h2>
    <p><?= $friction["description"] ?></p>
    <a href="/team/<?= $friction["team_id"]?>/friction/<?= $friction["id"]?>" > Voir l'irritant </a>

</div>

<?php
    }

} ?>

<a href="/team/<?= $teamId ?>/friction/create">Créer un irritant</a>