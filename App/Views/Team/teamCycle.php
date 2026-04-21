<?php $activeTab = 'cycle'; ?>

<div class="teamPanel container">

    <div class="page__header">
        <h1 class="title-md mb-32">GROUPE</h1>
    </div>

    <div class="page__panel">

        <?php include 'Partials/_nav.php' ?>
        <div class="page__content panelContent">

            <div class="panelContent__header">
                <h2 class="section__title title-lg">Cycle en cours</h2>
            </div>

            <div class="panelContent__sections">

                <section class="panelContent__section">
                    <div class="section__header">
                        <h3 class="title-md">Dates</h3>
                    </div>

                    <div class="section__content">
                        <div class="card--cycle">

                            <div class="flex-col g-8">
                                <p class="text--xs">Début :</p>
                                <span class="badge badge--inprogress">
                                    <?= (new DateTime($cycle["start_date"]))->format('d-m-Y') ?>
                                </span>
                            </div>

                            <div class="flex-col g-8">
                                <p class="text--xs">Fin :</p>
                                <span class="badge badge--closed">
                                    <?= (new DateTime($cycle["end_date"]))->format('d-m-Y') ?>
                                </span>
                            </div>

                            <p class="text--xs">Les cycles se terminent le jour indiqué à 23h59</p>

                        </div>
                    </div>

                </section>

                <section>
                    <h3 class="title-md">Consultation des jours fériés</h3>
                    <div class="card--cycle">

                        <p class="text--xs">Renseigner une date afin de savoir s'il s'agit d'un jour férié.</p>

                        <form class="form" id="formHolidayCheck">
                            <input class="form__input" id="checkDate" name="checkDate" type="date" required>
                            <button type="button" class="btn-primary">Vérifier</button>
                            <p class="form__message"></p>
                        </form>

                    </div>

                </section>
            </div>

        </div>

    </div>
</div>

<script src="Public/js/nagerRequest.js" defer></script>