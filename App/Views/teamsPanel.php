<?php
//$successMessage
if(!empty($successMessage)) echo "$successMessage";

?>
<h1>Mes groupes</h1>

<?php

if(!empty($userTeams)){

    foreach($userTeams as $team){ ?>
    <div class="card">

        <h2><?= $team["name"] ?></h2>
        <p><?= $team["description"] ?></p>
        <p><?= $team["id"] ?></p>
        
        <a href="/team/<?= $team["id"] ?>">Accéder au groupe</a>

    </div>

<?php
    }

}

?>