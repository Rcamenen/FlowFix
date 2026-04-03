<h1>GROUP</h1>

<?php 


    // echo "Data : <br>";
    // var_dump($data);

    // if(isset($data))extract($data); // extraction des données pour accès direct aux variables

    echo "<br>";

?>

<h2>IRRITANT TO PILOT</h2>

<div class="card">
<?php 

    if(isset($frictionToPilot)){

?>
    <p>Vous avez un irritant à piloter</p>
    <h2><?= $frictionToPilot["title"] ?></h2>
    <p><?= $frictionToPilot["description"] ?></p>
    <a href="/team/<?=$frictionToPilot["team_id"]?>/friction/<?=$frictionToPilot["id"]?>"> Voir l'irritant </a>

<?php 

    }else{

    echo "<p> Vous n'avez aucun irritant à piloter";

} ?>
</div>

<h2>IRRITANT IN PROGRESS</h2>

<?php 
if(isset($frictionsInProgress)){

    foreach($frictionsInProgress as $friction){
        
?>

<div class="card">

    <h2><?= $friction["title"] ?></h2>
    <p><?= $friction["description"] ?></p>
    <a href="/team/<?= $friction["team_id"]?>/friction/<?= $friction["id"]?>" > Voir l'irritant </a>

</div>

<?php
    }

} ?>