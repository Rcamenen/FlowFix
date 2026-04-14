<h1>Login</h1>

<?php
if(isset($_SESSION["error"])){
    echo $_SESSION["error"];
    unset($_SESSION['error']);
}

if(isset($validationErrors)){
    foreach($validationErrors as $input => $error){
?>

<p><?= $error ;?></p>
        
<?php
    }

}
if(isset($successMessage)){
?>

<p><?= $successMessage ;?></p>
        
<?php
}
?>

<form action="/login" method="post">

    <input name="email" type="text" placeholder="Email" required>
    <input name="password" type="password" placeholder="Mot de passe" required>

    <button type="submit">Se connecter</button>

</form>