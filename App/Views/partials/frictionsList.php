<?php
    $labelClassMap = [
        'Non traité'    => 'totreat',
        'En cours' => 'inprogress',
        'En vote'     => 'invote',
        'Clos'     => 'closed'
    ];
?>

<?php foreach($frictions as $f): ?>

<article class="card--friction-<?= $labelClassMap[$f["status_label"]] ?>">

    <header class="card--friction__header">
        <h3><?= $f["title"] ?></h3>
        <span class="badge badge--<?= $labelClassMap[$f["status_label"]] ?>"><?= $f["status_label"] ?></span>
    </header>

    <p><?= $f["description"] ?></p>

    <?php if($f["status_label"]=="Non traité"): ?>
        <p><?= $f["votes"] ?> votes</p>
    <?php endif?>

    <p><?= $f["status_label"] ?></p>

    <a class="btn-secondary" href="/team/<?= $teamId ?>/friction/<?= $f["id"] ?>">Consulter l'irritant</a>

</article>

<?php endforeach; ?>

<?php if(!$frictions):?>

    <p class="notice--info">Aucun irritant sur le groupe !</p>


<?php else: ?>


<nav class="pagination">


    <?php if($currentPage > 1): ?>
        <a class="pagination__prev btn-secondary--sm" data-team="<?= $teamId ?>" data-page="<?= $currentPage - 1 ?>">Précédent</a>
    <?php else: ?>
        <a class="btn-secondary--sm btn--inactive">Précédent</a>
    <?php endif; ?>

    <span><?= $currentPage ?> / <?= $totalPages ?></span>

    <?php if($currentPage < $totalPages): ?>
        <a class="pagination__next btn-secondary--sm" data-team="<?= $teamId ?>" data-page="<?= $currentPage + 1 ?>">Suivant</a>
    <?php else: ?>
        <a class="btn-secondary--sm btn--inactive">Suivant</a>
    <?php endif; ?>

</nav>

<?php endif ?>
