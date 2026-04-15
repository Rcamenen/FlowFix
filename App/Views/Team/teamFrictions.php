<!-- <?php if($isModerator) echo "vous êtes modérateur de ce groupe";
        else echo "Vous n'êtes pas modérateur de ce groupe";?> -->
            <!-- message d'erreur -->

            <?php if(isset($_SESSION["error"])){ ?>

                    <div class="card--error">
                        <p><?= $_SESSION["error"] ?></p>
                    </div>
                    
            <?php unset($_SESSION['error']) ;} ?>

<main class="main container">

    <h1 class="title-md">Irritants du groupe</h1>
    <!-- MESSAGE DE SUCCES OU D'ERREUR -->

    <?php if(!empty($_SESSION["error"])): ?>
    <div class="container">
            <p class="notice--success"> Vous ne faites pas partie de ce groupe </p>
    </div>
    <?php endif ?>

    <!-- SOUS MENU DE NAVIGATION -->
    <div class="main__container">
    <aside class="main__nav">
        <nav class="subnav">
            <p class="section-label">Groupe</p>
            <ul class="subnav__list">
                <li class="subnav__item btn-tab"><a href="/team/<?= $teamId ?>">Vue globale</a></li>
                <li class="subnav__item btn-tab btn-tab--active">Irritants</li>
                <li class="subnav__item btn-tab">Infos groupe</li>
                <li class="subnav__item btn-primary--sm"><a href="/team/<?= $teamId ?>/friction/create">Créer un irritant</a></li>
            </ul>
        </nav>
    </aside>

    <div class="main__content">
        <section class="main__section section main__section main__section--first">

            <div class="section__top">
                <h2 class="section__title title-lg">Listes des irritants</h2>
            </div>

            <!-- AFFICHAGE DES IRRITANTS DU GROUPES -->

            <!-- Mapping labels/class -->
            <?php
            $labelClassMap = [
                'Non traité'    => 'totreat',
                'En cours' => 'inprogress',
                'En vote'     => 'invote',
                'Clos'     => 'closed'
            ];
            ?>

            <div class="section__content">
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

                <?php if(!$frictions){?>

                    <p class="notice--info">Aucun irritant sur le groupe !</p>

                <?php } ?>
            </div>

        </section>

    </div>
    </div>
</main>

<script src="/js/dashboard.js" defer></script>

<!-- <?php include(ROOT."/App/Views/Team/teamMember/teamMemberAddForm.php"); ?> -->
