<aside class="main__nav">
    <p class="section-label"><?= htmlspecialchars($teamName ?? "") ?></p>
    <nav class="subnav">
        <ul class="subnav__list">

            <li class="subnav__item <?= $activeTab === 'dashboard' ? 'btn-tab btn-tab--active' : 'btn-tab' ?>">
                <a href="team/<?= $teamId ?>">Tableau de bord</a>
            </li>

            <li class="subnav__item <?= $activeTab === 'frictions' ? 'btn-tab btn-tab--active' : 'btn-tab' ?>">
                <a href="team/<?= $teamId ?>/frictions">Irritants</a>
            </li>

            <li class="subnav__item <?= $activeTab === 'cycle' ? 'btn-tab btn-tab--active' : 'btn-tab' ?>">
                <a href="team/<?= $teamId ?>/cycle">Cycle</a>
            </li>

            <li class="subnav__item <?= $activeTab === 'members' ? 'btn-tab btn-tab--active' : 'btn-tab' ?>">
                <a href="team/<?= $teamId ?>/members">Membres</a>
            </li>

            <li class="subnav__item btn-primary--sm">
                <a href="team/<?= $teamId ?>/friction/create">Créer un irritant</a>
            </li>

        </ul>
    </nav>
</aside>