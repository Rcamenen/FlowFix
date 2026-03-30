<?php
//$successMessage
if(!empty($successMessage)) echo "$successMessage";

?>
<h1>Mes groupes</h1>

<?php

if(!empty($userGroups)){

    foreach($userGroups as $group){ ?>

        <h2><?= $group["groupName"] ?></h2>
        <p><?= $group["groupDesc"] ?></p>
        <p><?= $group["groupId"] ?></p>
        
        <a href="/group/<?= $group["groupId"] ?>">Accéder au groupe</a>

<?php
    }

}

?>