<main id="adminPanel" class="main container">

    <h1 class="title-md mb-32">ADMINISTRATION</h1>

    <div class="main__container">

    <?php include(dirname(__DIR__)."/Admin/Partials/_nav.php");?>

        <!-- <div class="main__content"> -->

            <section data-tab-content="users" class="main__section section main__section--first">

                <div class="section__top">
                    <h2 class="section__title title-lg">Liste des utilisateurs</h2>
                </div>

                <!-- Contenu chargé dynamiquement via loadUsers() -->
                <div class="section__content"></div>

            </section>

            <section data-tab-content="teams" class="main__section section dn main__section--first">

                <div class="section__top">
                    <h2 class="section__title title-lg">Liste des groupes</h2>
                </div>

                <!-- Contenu chargé dynamiquement via loadTeams() -->
                <div class="section__content"></div>

            </section>

        <!-- </div> -->
    </div>
</main>

<script src="/js/adminDashboard.js" defer></script>