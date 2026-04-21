<?php $activeTab = 'members'; ?>

<div class="teamPanel container">

    <div class="page__header">
        <h1 class="title-md mb-32">GROUPE</h1>
    </div>

    <div class="page__panel">

        <?php include 'Partials/_nav.php' ?>
        <div class="page__content panelContent">

            <div class="panelContent__header">
                <h2 class="section__title title-lg">Membres</h2>

                <?php if ($isModerator): ?>
                    <a class="btn-primary--sm" href="team/<?= $teamId ?>/member/add">Ajouter un membre</a>
                <?php endif ?>
            </div>

            <div class="panelContent__sections">
                <section class="panelContent__section">
                        <div class="section__content">

                            <?php if (!$members): ?>

                                <p class="notice--info">Aucun membre dans ce groupe.</p>

                            <?php else: ?>

                                <?php foreach ($members as $member): ?>
                                    <?php include 'Partials/_member.php' ?>
                                <?php endforeach ?>

                            <?php endif ?>

                        </div>

                </section>
            </div>

        </div>

    </div>
</div>