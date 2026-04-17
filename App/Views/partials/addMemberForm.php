<h3 class="title-md">Ajouter un membre</h3>

<?php if (!empty($formError)): ?>
    <ul class="form__errors">
            <li class="notice--error"><?= htmlspecialchars($formError) ?></li>
    </ul>
<?php endif; ?>

<?php if (!empty($formSuccess)): ?>
    <p class="notice--success"><?= htmlspecialchars($formSuccess) ?></p>
<?php endif; ?>

<form id="addMemberForm" class="form">

    <input class="form__input <?= !empty($data["errors"]["email"]) ? "form__input--error" : "" ?>"name="email" type="text" placeholder="Email" value="<?= htmlspecialchars($data["email"] ?? "") ?>" required>

    <?php if (!empty($data["errors"]["email"])): ?>
        <p class="form__error-msg"><?= htmlspecialchars($data["errors"]["email"]) ?></p>
    <?php endif; ?>

    <button class="form__btn btn-primary" type="submit">Ajouter</button>

</form>

<h3 class="title-md">Supprimer un membre</h3>