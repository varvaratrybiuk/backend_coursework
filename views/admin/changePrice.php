<?php
/** @var array $products */
?>
<div class="row container-fluid">
    <div class="col-auto mb-5">
        <button type="submit" id="update">Оновити</button>
        <div class ="error mt-2" style="color: darkred;"></div>
    </div>
    <div class="col-auto table-container">
        <table class="table">
            <thead>
            <tr>
                <th>Ім'я товару</th>
                <th>Опис</th>
                <th>Ціна та кількість</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($products as $index => $product): ?>
                <tr>
                    <td><?=$product->getName()?></td>
                    <td><?=$product->getDescription()?></td>
                    <td>
                        <ul>
                            <?php foreach ($product->getPricesAndSizes() as  $inform): ?>
                                <li id="<?=$inform["size"]?>">
                                    <?=$inform["size"]?>:

                                    <ul id="<?=$product->getId()?>" class ="box">

                                        <li>
                                            <label for="price<?=$index.$inform["size"]?>">Ціна:</label>
                                            <input type="text" name ="price" class ="price" id="price<?=$index.$inform["size"]?>"value="<?=$inform["price"]?>" required>
                                        </li>
                                        <li>
                                            <label for="quantity<?=$index.$inform["size"]?>">К-сть на складі:</label>
                                            <input type="text" name="quantity"class ="quantity" id="quantity<?=$index.$inform["size"]?>"  value="<?=$inform["quantity"]?>" required>
                                        </li>
                                    </ul>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const uls = document.querySelectorAll(".box");
        const priceInputs = document.querySelectorAll('.price');
        const quantityInputs = document.querySelectorAll('.quantity');
        const data = {};
        const updateButton = document.getElementById("update");
        const errorBox = document.querySelector(".error")
        console.log(errorBox);
        priceInputs.forEach((input) => {
            input.addEventListener('change', function() {
                const ul = input.closest('.box');
                const ulId = ul.id;
                const size = ul.closest('li').id;
                data[ulId] = data[ulId] || {};
                data[ulId].price = input.value;
                data[ulId].size = size;
                ul.classList.add("changed");
            });
        });

        quantityInputs.forEach((input) => {
            input.addEventListener('change', function() {
                const ul = input.closest('.box');
                const ulId = ul.id;
                const size = ul.closest('li').id;

                data[ulId] = data[ulId] || {};
                data[ulId].quantity = input.value;
                data[ulId].size = size;
                ul.classList.add("changed");
            });
        });

        updateButton.addEventListener("click", (event) => {
            event.preventDefault();
            console.log(data);
            let formData = new FormData();
            formData.append("json", JSON.stringify(data));
            const requestOptions = {
                method: "POST",
                body: formData
            };
            fetch(window.location.href, requestOptions)
                .then(response => response.json())
                .then(data => {
                    if(data.done === true){
                        location.reload()
                    }
                    errorBox.textContent = data.error;
                })
                .catch(error => {
                    console.error('Помилка:', error);
                });
        });
    });
</script>