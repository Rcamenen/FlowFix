<?php
//$successMessage
if(!empty($successMessage)) echo "$successMessage";

?>
<h1>Mes groupes</h1>
    

<?php

if(!empty($userTeams)){

    foreach($userTeams as $team){ ?>
    <div class="teamCard">

            <h2><?= $team["name"] ?></h2>
            <p><?= $team["description"] ?></p>
        <p><?= $team["id"] ?></p>
        
        <a href="/team/<?= $team["id"] ?>">Accéder au groupe</a>

    </div>

<?php
    }

}else{
    echo "Vous ne faites partie d'aucune équipe";
}

?>

<h1>Créer un groupe</h1>

<form action="/team/create" method="post">

    <label for="name">Nom du groupe</label>
    <input id="name" name="name" type="text">

    <label for="description">Description du groupe</label>
    <input id="description" name="description" type="text">

    <label for="duration">Durée d'un cycle</label>
    <input id="duration" name="duration" type="number">

    <label for="treatmentsMax">Nombre de friction à traiter simultanement</label>
    <input id="treatmentsMax" name="treatmentsMax" type="number">

    <label for="votingDelay">Délais de vote d'une solution</label>
    <input id="votingDelay" name="votingDelay" type="number">

    <button type="submit" >Soumettre</button>

</form>