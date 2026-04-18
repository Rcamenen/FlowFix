<?php $activeTab = 'members'; ?>

<main class="main container">

    <h1 class="title-md mb-32">GROUPE</h1>

    <div class="main__container">

        <?php include 'Partials/_nav.php' ?>

        <div class="main__content">
            <section class="main__section section main__section--first">

                <div class="section__top">
                    <h2 class="section__title title-lg">Membres</h2>

                    <?php if ($isModerator): ?>
                        <a class="btn-primary--sm" href="/team/<?= $teamId ?>/member/add">Ajouter un membre</a>
                    <?php endif ?>
                </div>

                <div class="section__content">

                    <?php if (!$members): ?>

                        <p class="notice--info">Aucun membre dans ce groupe.</p>

                    <?php else: ?>

                        <?php foreach ($members as $member): ?>
                            <div class="memberCard">
                                <p><?= htmlspecialchars($member["username"]) ?></p>
                                <?php if ($member["promoted_at"]): ?>
                                    <span class="badge">Modérateur</span>
                                <?php endif ?>
                            </div>
                        <?php endforeach ?>

                    <?php endif ?>

                </div>

            </section>
        </div>

    </div>
</main>
