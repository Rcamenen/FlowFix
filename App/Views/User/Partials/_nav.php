<aside class="main__nav">
    <nav class="subnav">
        <p class="section-label"><?= htmlspecialchars($_SESSION["username"] ?? "") ?></p>
        <ul class="subnav__list">

            <li class="subnav__item <?= $activeTab === 'teams' ? 'btn-tab btn-tab--active' : 'btn-tab' ?>">
                <a href="/teams">Groupes</a>
            </li>

            <li class="subnav__item btn-primary--sm">
                <a href="/team/create">Créer un groupe</a>
            </li>

        </ul>
    </nav>
</aside>