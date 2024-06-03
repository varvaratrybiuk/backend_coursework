<?php
?>

<div class="container-xs form-container">
    <h2>Реєстрація</h2>
    <div id="error" class="error"></div>
    <form class="formField" id="form" method="POST">
        <div class="row g-1 form-field emailField">
            <div class="col auto">
                <label for="regemail">Email:</label>
            </div>
            <div class="col auto">
                <input type="text" id="regemail" name="regemail" placeholder="merchua@gmail.com" required>
            </div>
        </div>
        <div class="row g-1 form-field passwordField">
            <div class="col auto">
                <label for="regpassword">Пароль:</label>
            </div>
            <div class="col auto">
                <input type="password" id="regpassword" name="regpassword" required>
            </div>
        </div>
        <div class="row g-1 form-field nameField">
            <div class="col auto">
                <label for="regname">Ім'я:</label>
            </div>
            <div class="col auto">
                <input type="text" id="regname" name="regname" required>
            </div>
        </div>
        <div class="row g-1 form-field lastnameField">
            <div class="col auto">
                <label for="reglastname">Прізвище:</label>
            </div>
            <div class="col auto">
                <input type="text" id="reglastname" name="reglastname" required>
            </div>
        </div>
        <div class="row g-1 form-field birthdayField">
            <div class="col auto">
                <label for="regbirthday">Дата народження:</label>
            </div>
            <div class="col auto">
                <input type="date" id="regbirthday" name="regbirthday" required>
            </div>
        </div>
        <div class="row g-1 form-field">
            <div class="col auto d-flex justify-content-center">
                <button type="submit">Зареєструватися</button>
            </div>
        </div>
    </form>
</div>
