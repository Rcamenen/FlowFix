<?php $activeTab = 'cycle'; ?>

<main class="main container">

    <h1 class="title-md mb-32">GROUPE</h1>

    <div class="main__container">

        <?php include 'Partials/_nav.php' ?>

            <section class="main__section section main__section--first">

                <div class="section__top">
                    <h2 class="section__title title-lg">Cycle en cours</h2>
                </div>

                <div class="section__content">

                    <div class="card--cycle">

                        <h3 class="title-md">Dates</h3>

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

                    <div class="card--cycle">

                        <h3 class="title-md">Consultation des jours fériés</h3>
                        <p class="text--xs">Renseigner une date afin de savoir s'il s'agit d'un jour férié.</p>

                        <form class="form" id="formHolidayCheck">
                            <input class="form__input" id="checkDate" name="checkDate" type="date" required>
                            <button type="button" class="btn-primary">Vérifier</button>
                            <p class="form__message"></p>
                        </form>

                    </div>

                </div>

            </section>

    </div>
</main>

<script src="/js/nagerRequest.js" defer></script>
