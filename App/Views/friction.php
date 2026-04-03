<?php if(isset($data))extract($data); // extraction des données pour accès direct aux variables ?>
<H2>FRICTION</H2>

<h3><?= $friction["title"] ?></h3>
<p><?= $friction["description"] ?></p>
<p><?= $friction["created_at"] ?></p>
<p><?= $friction["updated_at"] ?? "Pas d'update" ?></p>
<p><?= $friction["author"] ?></p>
<p><?= $friction["statusLabel"] ?></p>

<?php if(isset($treatment)){ ?>

    <H2>LAST TREATMENT</H2>
    <p><?= $treatment["solution"] ?></p>
    <p><?= $treatment["created_at"] ?></p>
    <p><?= $treatment["updated_at"] ?? "Pas d'update" ?></p>
    <p><?= $treatment["pilot"] ?></p>
    <p><?= $treatment["statusLabel"] ?></p>

<?php } ?>