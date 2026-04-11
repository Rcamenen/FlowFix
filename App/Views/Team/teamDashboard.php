<nav class="tab-nav">
    <button class="tab-btn active" data-tab="overview">Vue globale</button>
    <button class="tab-btn" data-tab="frictions">Liste des irritants</button>
    <button class="tab-btn" data-tab="infos">Infos groupe</button>
</nav>

<a href="/team/<?= $teamId ?>/friction/create">Créer un irritant</a>

<!-- Onglet 1 : Vue globale (données déjà chargées) -->
<section id="tab-overview" class="tab-content active">

    <?php foreach($frictionsToPilot as $f): ?>
        <div class="frictionCard">
            <h3><?= $f["title"] ?></h3>
            <a href="/team/<?= $teamId ?>/friction/<?= $f["id"] ?>">Voir</a>
        </div>
    <?php endforeach; ?>

</section>

<!-- Onglet 2 : Liste (chargée en AJAX au premier clic) -->
<section id="tab-frictions" class="tab-content">

    <div id="frictions-container">
        <p>Chargement...</p>
    </div>

</section>

<!-- Onglet 3 : Infos groupe -->
<section id="tab-infos" class="tab-content">
    <!-- à compléter -->
</section>

<div id="team-dashboard" data-team-id="<?= htmlspecialchars($teamId) ?>">
    ...
</div>

<!-- Plus de PHP dans le script, juste l'import -->
<!-- <script src=<?php echo ROOT."/Public/js/dashboard.js"?> defer></script> -->
<script src="/js/dashboard.js" defer></script>