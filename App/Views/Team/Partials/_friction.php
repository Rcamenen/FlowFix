<?php 

$icon = ($f["votes"]>0) ? "fa-arrow-up-long" : "fa-minus";

?>

<article class="frictionCard frictionCard--<?= $labelClassMap[$f["status_label"]] ?>">

    <header class="frictionCard__top">
        <h3><?= htmlspecialchars($f["title"]) ?></h3>
        <span class="badge badge--<?= $labelClassMap[$f["status_label"]] ?>">
            <?= htmlspecialchars($f["status_label"]) ?>
        </span>
    </header>
    <div class="frictionCard__description">
        <p><?= htmlspecialchars($f["description"]) ?></p>
    </div>
    <div class="frictionCard__bottom">

        <?php if ($f["status_label"] === "Non traité"): ?>
        <p class="upVote">
            <i class="upVote__arrow fa-solid <?= $icon ?>" aria-hidden="true"></i>
            <span class="upVote__count"><?= (int) $f["votes"] ?></span>
            <span class="upVote__label">votes</span>
        </p>
        <?php endif ?>

        <a class="btn-secondary--sm" href="team/<?= $teamId ?>/friction/<?= $f["id"] ?>">
            Consulter l'irritant
        </a>

    </div>

</article>