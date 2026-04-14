<?php
if(!empty($users)){
    foreach($users as $user){ ?>

        <div class="teamCard">

            <p><?= $user["firstname"] ?></p>
            <p><?= $user["lastname"] ?></p>
            <p><?= $user["email"] ?></p>
            <p><?= $user["username"] ?></p>

            <form action="/admin/user/<?= $user["id"] ?>/delete" method="post">
                <button type="submit">Supprimer</button>
            </form>
        </div>

<?php
        }
   }

?>