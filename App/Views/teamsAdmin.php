<?php
if(!empty($teams)){
    foreach($teams as $team){ ?>

        <div class="teamCard">

            <p><?= $team["name"] ?></p>
            <p><?= $team["description"] ?></p>

            <form action="/admin/team/<?= $team["id"] ?>/delete" method="post">
                <button type="submit">Supprimer</button>
            </form>
        </div>

<?php
        }
   }

   else{ ?>

    <p>Aucun groupe à administrer !</p>
    
<?php
   }

?>