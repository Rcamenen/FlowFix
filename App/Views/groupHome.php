<h1>GROUP</h1>

<?php 


    echo "Data : <br>";
    var_dump($data);

    extract($data);
    echo "<br>";

    var_dump($frictionToPilot);


?>

<div>

<h2><?= $frictionToPilot["title"] ?></h2>
<p><?= $frictionToPilot["description"] ?></p>
<a href="/group/<?= $frictionToPilot["group_id"]?>/irritant/<?= $frictionToPilot["id"]?>"> Voir l'irritant </a>

</div>