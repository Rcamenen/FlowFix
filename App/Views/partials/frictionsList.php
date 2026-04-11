<?php foreach($frictions as $friction): ?>
<div class="frictionCard teamCard">
    <h3><?= htmlspecialchars($friction["title"]) ?></h3>
    <span><?= htmlspecialchars($friction["status_label"]) ?></span>
    <a href="/team/<?= $teamId ?>/friction/<?= $friction["id"] ?>">Voir</a>
</div>
<?php endforeach; ?>

<nav class="pagination">
    <?php if($currentPage > 1): ?>
        <button onclick="loadFrictions(<?= $teamId ?>, <?= $currentPage - 1 ?>)">← Précédent</button>
    <?php endif; ?>

    <span>Page <?= $currentPage ?> / <?= $totalPages ?></span>

    <?php if($currentPage < $totalPages): ?>
        <button onclick="loadFrictions(<?= $teamId ?>, <?= $currentPage + 1 ?>)">Suivant →</button>
    <?php endif; ?>
</nav>