<?php
/** @var array $userInfo */
$user_id = \core\Core::getInstance()->getCurrentSession()->get("id") ?? "guest";
?>
<div class="container-md form-container">
    <h2>Форма для оформлення замовлення</h2>
    <div id="error" class="error"></div>
    <form id="form" method="POST" class="formField">
        <div class="row g-1 form-field">
            <div class="col auto">
                <label for="first_name">Ім'я:</label>
            </div>
            <div class="col auto">
                <input type="text" id="first_name" value="<?= $userInfo["name"] ?? '' ?>" name="first_name" required>
            </div>
        </div>
        <div class="row g-1 form-field">
            <div class="col auto">
                <label for="last_name">Прізвище:</label>
            </div>
            <div class="col auto">
                <input type="text" value="<?= $userInfo["lastname"] ?? '' ?>" id="last_name" name="last_name" required>
            </div>
        </div>
        <div class="row g-1 form-field">
            <div class="col auto">
                <label for="email">Електронна пошта:</label>
            </div>
            <div class="col auto">
                <input type="email" value="<?= $userInfo["email"] ?? '' ?>" placeholder="merchua@gmail.com" id="email" name="email" required>
            </div>
        </div>
        <?php use core\Core;

        if (Core::getInstance()->getCurrentSession()->userIsLoggedIn() && !empty($addresses)): ?>
            <div class="row g-1 form-field">
                <div class="col auto">
                    <label for="address">Адреса:</label>
                </div>
                <div class="col auto">
                    <select id="addressId" name="addressId">
                        <option value="0">
                            Обрати...
                        </option>
                        <?php foreach ($addresses['addresses'] as $index => $address): ?>
                            <option value="<?php echo $addresses['id'][$index]; ?>">
                                <?php echo $address; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        <?php else: ?>
            <div class="row g-1 form-field">
                <div class="col auto">
                    <label for="country">Країна:</label>
                </div>
                <div class="col auto">
                    <input type="text" placeholder="Україна" id="country" name="country">
                </div>
            </div>
            <div class="row g-1 form-field">
                <div class="col auto">
                    <label for="city">Місто:</label>
                </div>
                <div class="col auto">
                    <input type="text" id="city" name="city">
                </div>
            </div>
            <div class="row g-1 form-field">
                <div class="col auto">
                    <label for="street">Вулиця:</label>
                </div>
                <div class="col auto">
                    <input type="text" id="street" name="street">
                </div>
            </div>
            <div class="row g-1 form-field">
                <div class="col auto">
                    <label for="zip_code">Зіп код:</label>
                </div>
                <div class="col auto">
                    <input type="text" id="zip_code" name="zip_code">
                </div>
            </div>
        <?php endif; ?>
        <div class="row g-1 form-field">
            <div class="col auto">
                <label for="card_number">Номер картки:</label>
            </div>
            <div class="col auto">
                <input type="text" id="card_number" name="card_number" pattern="[0-9]{16}" title="Номер картки повинен містити 16 цифр" required>
            </div>
        </div>
        <div class="row g-1 form-field">
            <div class="col auto">
                <label for="expiration_date">Дата закінчення терміну дії:</label>
            </div>
            <div class="col auto">
                <input type="month" id="expiration_date" name="expiration_date" required>
            </div>
        </div>
        <div class="row g-1 form-field">
            <div class="col auto">
                <label for="cvv">CVV код:</label>
            </div>
            <div class="col auto">
                <input type="text" id="cvv" name="cvv" pattern="[0-9]{3}" title="CVV код повинен містити 3 цифри" required>
            </div>
        </div>
        <div class="row g-1 form-field">
            <div class="col auto d-flex justify-content-center">
                <button  type="submit">Відправити</button>
            </div>
        </div>
    </form>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const userId = "<?= $user_id ?>";
        const userItems = [];
        for (let i = 0; i < localStorage.length; i++) {
            const key = localStorage.key(i);
            if (key.includes(userId)) {
                const item = localStorage.getItem(key);
                userItems.push({ key: key, value: item });
            }
        }
        if (userItems.length === 0) {
            window.location.href = "/catalog/";
            return;
        }

        const firstNameInput = document.getElementById("first_name");
        const lastNameInput = document.getElementById("last_name");
        const emailInput = document.getElementById("email");
        const addressSelect = document.getElementById("addressId");
        const errorBox = document.getElementById("error");
        const form = document.getElementById("form");

        if (firstNameInput && firstNameInput.value.trim() !== "") {
            firstNameInput.readOnly = true;
        }
        if (lastNameInput && lastNameInput.value.trim() !== "") {
            lastNameInput.readOnly = true;
        }
        if (emailInput && emailInput.value.trim() !== "") {
            emailInput.readOnly = true;
        }

        form.addEventListener("submit", function(event) {
            event.preventDefault();
            errorBox.textContent = "";
            if (addressSelect && addressSelect.value === "0") {
                errorBox.textContent = "Оберіть адресу";
                return;
            }
            sendData();
        });

        function sendData() {
            let formData = new FormData(form);
            formData.append('json', JSON.stringify(userItems));
            const requestOptions = {
                method: "POST",
                body: formData
            };
            fetch(window.location.href, requestOptions)
                .then(response => response.json())
                .then(data => {
                    if(data.done) {
                        localStorage.removeItem(userId);
                        window.location.href = "/catalog/";
                    }
                    errorBox.textContent = data.error;
                })
                .catch(error => {
                    console.error('Помилка:', error);
                });
        }
    });
</script>