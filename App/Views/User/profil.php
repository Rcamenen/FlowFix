<main id="accountPanel" class="main container">

    <div class="page__header">
        <h1 class="title-md mb-32">Mon compte</h1>
    </div>

    <div class="page__panel">

        <aside class="main__nav">
            <nav class="subnav">
                <p class="section-label"><?= htmlspecialchars($_SESSION["username"] ?? "") ?></p>
                <ul class="subnav__list">
                    <li class="subnav__item btn-tab btn-tab--active"><a href="/account">Mes informations</a></li>
                    <li class="subnav__item btn-tab"><a href="/account/delete">Supprimer mon compte</a></li>
                </ul>
            </nav>
        </aside>

        <div class="page__content panelContent">

            <div class="panelContent__header">
                <h2 class="section__title title-lg">Mes informations</h2>
            </div>

            <div class="panelContent__sections">
                <section class="panelContent__section">

                    <p>Bonjour <?= $user["firstname"] ?></p>

                </section>
            </div>

        </div>

    </div>
</main>