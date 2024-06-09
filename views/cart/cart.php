<?php

$user_id = \core\Core::getInstance()->getCurrentSession()->get("id") ?? "guest";
?>
<div class="container-fluid cart-container" style="display: none">
</div>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const container = document.getElementById("content");
        const parentContainer = document.querySelector(".cart-container");

        const userId = "<?= $user_id ?>" ;
        const userItems = [];
        for (let i = 0; i < localStorage.length; i++) {
            const key = localStorage.key(i);
            if (key.includes(userId)) {
                const item = localStorage.getItem(key);
                userItems.push({ key: key, value: item });
            }
        }
        if(userItems.length !== 0){
            const formData = new FormData();
            formData.append('json', JSON.stringify(userItems));
            parentContainer.style.display = "flex"
            sendData(formData);

            function sendData(formData) {
                const requestOptions = {
                    method: "POST",
                    body: formData
                };
                console.log(userItems);
                fetch(window.location.href, requestOptions)
                    .then(response => response.text())
                    .then(data => {
                        handleResponse(data);
                    })
                    .catch(error => {
                        console.error('Помилка:', error);
                    });
            }
            function handleResponse(data) {
                parentContainer.innerHTML = data;
                container.appendChild(parentContainer);
                const priceSpans = document.querySelectorAll(".productPrice > span")
                const finalePriceSpan = document.querySelector(".finale > p > span");
                const liItems = document.querySelectorAll(".quantity");
                const liItemsS = document.querySelectorAll(".size");
                let price = 0;

                liItems.forEach((li, index) => {
                    const valueObj = JSON.parse(userItems[0].value);
                    li.textContent += valueObj[index].quantity;
                    price += parseInt(valueObj[index].quantity) * parseInt(priceSpans[index].textContent);
                    liItemsS[index].textContent += valueObj[index].size;

                });
                finalePriceSpan.innerText = price;
            }
        }
    });
</script>
