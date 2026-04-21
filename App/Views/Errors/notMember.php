<div class="notMember">

        <section class="main__section section container">

            <!-- message d'erreur -->

            <?php if(isset($_SESSION["error"])){ ?>

            <div class="notice--error">
                <p><?= $_SESSION["error"] ?></p>
            </div>
                    
            <?php unset($_SESSION['error']) ;} ?>

            <a class="btn-secondary--sm" href="teams">Voir vos groupes</a>

        </section>

</div>
