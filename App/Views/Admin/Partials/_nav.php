<aside class="main__nav">
    <nav class="subnav">
        <p class="section-label">Panneau admin</p>
        <ul class="subnav__list">

            <li class="subnav__item <?= $activeTab === 'users' ? 'btn-tab btn-tab--active' : 'btn-tab' ?>">
                <a href="/admin/users">Utilisateurs</a>
            </li>

            <li class="subnav__item <?= $activeTab === 'teams' ? 'btn-tab btn-tab--active' : 'btn-tab' ?>">
                <a href="/admin/teams">Groupes</a>
            </li>

        </ul>
    </nav>
</aside>