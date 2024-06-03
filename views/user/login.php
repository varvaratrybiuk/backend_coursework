<?php
?>
<div class="container-md form-container">
    <h2>Вхід</h2>
    <div id="error" class="error"></div>
    <form id="form" method="POST" class="loginForm" >
        <div class="row g-1 form-field emailField">
            <div class="col auto">
                <label for="logemail">Email:</label>
            </div>
            <div class="col auto">
                <input type="text" id="logemail" name="logemail" placeholder="merchua@gmail.com" required>
            </div>
        </div>
        <div class="row g-1 form-field passwordField">
            <div class="col auto">
                <label for="logpassword">Пароль:</label>
            </div>
            <div class="col auto">
                <input type="password" id="logpassword" name="logpassword" required>
            </div>
        </div>
        <div class="row g-1 form-field">
            <div class="col auto d-flex justify-content-center">
                <button id="logIn" type="submit">Увійти</button>
            </div>
        </div>
    </form>
</div>
