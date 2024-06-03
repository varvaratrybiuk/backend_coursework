<?php
?>
<div class="container-xs form-container">
<h2>Контактна інформація</h2>
<form id="form" class="editUserForm" method="POST">
    <div class="row g-1 form-field emailField">
        <div class="col-auto">
            <label for="edit_email">Email:</label>
        </div>
        <div class="col-auto">
            <input type="text" id="edit_email" name="edit_email" placeholder="merchua@gmail.com" required>
        </div>
    </div>
    <div class="row g-1 form-field nameField">
        <div class="col-auto">
            <label for="edit_name">Ім'я:</label>
        </div>
        <div class="col-auto">
            <input type="text" id="edit_name" name="edit_name" required>
        </div>
    </div>
    <div class="row g-1 form-field lastnameField">
        <div class="col-auto">
            <label for="edit_lastname">Прізвище:</label>
        </div>
        <div class="col-auto">
            <input type="text" id="edit_lastname" name="edit_lastname"  required>
        </div>
    </div>
    <div class="row g-1 form-field birthdayField">
        <div class="col-auto">
            <label for="edit_birthday">Дата народження:</label>
        </div>
        <div class="col-auto">
            <input type="date" id="edit_birthday" name="edit_birthday"  required>
        </div>
    </div>
    <div class="row g-1 form-field">
        <div class="col-auto d-flex justify-content-center">
            <button type="submit">Зберегти зміни</button>
        </div>
    </div>
</form>
</div>