<?php
    $badgeStatus = (!empty($member["promoted_at"])) ? ["class"=>"badge--moderator","label"=>"Modérateur"] : ["class"=>"badge--member","label"=>"Membre"];
?>

<div class="memberCard">
    <p class="text--strong memberCard__username"><?= htmlspecialchars($member["username"]) ?></p>
    <span class="badge <?= $badgeStatus["class"] ?>"><?= $badgeStatus["label"] ?></span>
    <p class="text--xs">Membre depuis le <?= (new DateTime($member["joined_at"]))->format("d/m/Y") ?></p>
</div>