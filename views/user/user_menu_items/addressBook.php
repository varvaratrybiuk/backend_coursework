<?php
?>
<div class="container-md">
    <h3>Доступні адреси</h3>
    <table class=" address-table table ">
        <thead>
        <tr>
            <th scope="col">№</th>
            <th scope="col">Країна</th>
            <th scope="col">Місто</th>
            <th scope="col">Вулиця</th>
            <th scope="col">ZIP код</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th scope="row">1</th>
            <td>Україна</td>
            <td>Житомир</td>
            <td>Пр. Миру, 3</td>
            <td>10001</td>
        </tr>
        <tr>
            <th scope="row">1</th>
            <td>Україна</td>
            <td>Житомир</td>
            <td>Пр. Миру, 3</td>
            <td>10001</td>
        </tr>
        </tbody>
    </table>
</div>
<div class="form-container">
    <h3>Додати адресу</h3>
    <form id="addressForm" class="AddressForm" method="POST">
        <div class="row g-1 form-field countryField">
            <div class="col-auto">
                <label for="country">Країна:</label>
            </div>
            <div class="col-auto">
                <input type="text" id="country" name="country" required>
            </div>
        </div>
        <div class="row g-1 form-field cityField">
            <div class="col-auto">
                <label for="city">Місто:</label>
            </div>
            <div class="col-auto">
                <input type="text" id="city" name="city" required>
            </div>
        </div>
        <div class="row g-1 form-field streetField">
            <div class="col-auto">
                <label for="street">Вулиця:</label>
            </div>
            <div class="col-auto">
                <input type="text" id="street" name="edit_street" required>
            </div>
        </div>
        <div class="row g-1 form-field zipField">
            <div class="col-auto">
                <label for="zip_code">Поштовий індекс:</label>
            </div>
            <div class="col-auto">
                <input type="text" id="zip_code" name="zip_code" required>
            </div>
        </div>
        <div class="row g-1 form-field">
            <div class="col auto d-flex justify-content-center">
                <button type="submit">Додати</button>
            </div>
        </div>
    </form>
</div>
