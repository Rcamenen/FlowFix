<?php if(isset($data))extract($data); // extraction des données pour accès direct aux variables ?>
<!-- <?php var_dump($data); ?> -->
<H2>FRICTION</H2>

<form class="card" action="/team/<?= $teamId ?>/friction/create" method="post">

    <p><?php if(isset($validationErrors["title"])) echo $validationErrors["title"];?> </p>
    <input name="title" type="text" placeholder="Titre de l'irritant" <?= $val["title"] ?? null ?> required>

    <p><?php if(isset($validationErrors["description"])) echo $validationErrors["description"];?> </p>
    <textarea name="description" placeholder="Description du problème rencontré" <?= $val["description"] ?? null ?> required></textarea>

    <button type="submit" >Soumettre</button>

</form>