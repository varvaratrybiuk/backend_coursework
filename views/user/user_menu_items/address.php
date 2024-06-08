<?php
/** @var array|null $addresses */
?>
<div class="container-md">
    <h3>Доступні адреси</h3>
    <table class=" address-table table ">
        <thead>
        <tr>
            <th scope="col">№</th>
            <th scope="col">Адреса</th>
        </tr>
        </thead>
        <tbody>
        <?php if(isset($addresses)):?>
            <?php $count = 1; ?>
            <?php foreach($addresses as $index => $address): ?>
                <tr>
                    <th scope="row"><?= $count ?></th>
                    <td><?= $address ?></td>
            </tr>
            <?php $count++; ?>
        <?php endforeach; ?>
        <?php endif;?>
        </tbody>
    </table>
</div>
<div class="form-container">
    <h3>Додати адресу</h3>
    <div id="error" class="error"></div>
    <form id="form" class="AddressForm" method="POST">
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
