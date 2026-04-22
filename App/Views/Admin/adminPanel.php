<div class="page page--panel adminPanel container">

    <!-- PAGE__HEADER -->

    <div class="page__header">
        <h1 class="title-md mb-32">ADMINISTRATION</h1>
    </div>

    <!-- PAGE__PANEL -->

    <div class="page__panel">

        <!-- SUB NAV -->
         
        <?php include(dirname(__DIR__)."/Admin/Partials/_nav.php");?>
        <div class="page__content panelContent">

            <div class="panelContent__sections">

                <section data-tab-content="users" class="panelContent__section">
                    <h3 class="title-md">Liste des utilisateurs</h3>
                </section>

                <section data-tab-content="teams" class="panelContent__section dn">
                    <h3 class="title-md">Liste des groupes</h3>
                </section>

            </div>

        </div>

    </div>

</div>

<script src="/js/adminDashboard.js" defer></script>