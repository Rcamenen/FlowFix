<h1>Register</h1>

<?php

    if(!empty($formFields)){

        foreach($formFields as $field => $value){

            $val[$field] = "value = \"".$value."\"";
            
        }

    }

    if(!empty($response["failedMessage"])){
?>

    <div class="errors">
        <p><?= $response["failedMessage"] ?></p>
    </div>

<?php 
    }
?>

<form action="/register" method="post">

    <p><?php if(isset($validationErrors["firstname"])) echo $validationErrors["firstname"];?></p>
    <input name="firstname" type="text" placeholder="Votre prénom" <?= $val["firstname"] ?? null ?> required>

    <p><?php if(isset($validationErrors["lastname"])) echo $validationErrors["lastname"];?></p>
    <input name="lastname" type="text" placeholder="Votre nom" <?= $val["lastname"] ?? null ?> required>

    <p><?php if(isset($validationErrors["username"])) echo $validationErrors["username"];?></p>
    <input name="username" type="text" placeholder="Votre pseudo" <?= $val["username"] ?? null ?> required>

    <p><?php if(isset($validationErrors["email"])) echo $validationErrors["email"];?></p>
    <input name="email" type="email" placeholder="Votre email" <?= $val["email"] ?? null ?> required>

    <p><?php if(isset($validationErrors["password"])) echo $validationErrors["password"];?></p>
    <input name="password" type="password" placeholder="Choisir un mot de passe" <?= $val["password"] ?? null ?> required>

    <button type="submit" >Créer un compte</button>

</form>