<?php if($isModerator) echo "vous êtes modérateur de ce groupe";
        else echo "Vous n'êtes pas modérateur de ce groupe";?>
<nav class="tab-nav">
    <button class="tab-btn active" data-tab="overview">Vue globale</button>
    <button class="tab-btn" data-tab="frictions">Liste des irritants</button>
    <button class="tab-btn" data-tab="infos">Infos groupe</button>
</nav>

<a href="/team/<?= $teamId ?>/friction/create">Créer un irritant</a>

<section id="tab-overview" class="tab-content active">

    <?php foreach($frictionsToPilot as $f): ?>
        <div class="frictionCard">
            <h3><?= $f["title"] ?></h3>
            <a href="/team/<?= $teamId ?>/friction/<?= $f["id"] ?>">Voir</a>
        </div>
    <?php endforeach; ?>

</section>


<section id="tab-frictions" class="tab-content">

    <div id="frictions-container">
    
    </div>

</section>


<section id="tab-infos" class="tab-content">
   
</section>

<div id="team-dashboard" data-team-id="<?= htmlspecialchars($teamId) ?>">
    ...
</div>

<script src="/js/dashboard.js" defer></script>

<?php include(ROOT."/App/Views/Team/teamMember/teamMemberAddForm.php"); ?>