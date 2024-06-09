<?php
/** @var ProductDTO $productObject */

use core\Core;
use models\products\ProductDTO;
$user_id = Core::getInstance()->getCurrentSession()->userIsLoggedIn() ? Core::getInstance()->getCurrentSession()->get("id") : "guest";
$pricesAndSizes = $productObject->getPricesAndSizes();
$pricesAndSizesJSON = json_encode($pricesAndSizes);
?>
<div class="container-fluid">
    <div class="row product-container">
        <div class="col-md-6 product-photos">
            <div id="<?= $productObject->getId()?>" class="carousel carousel-dark slide carousel-fade">
                <div class="carousel-indicators">
                    <?php if(count($productObject->getProductPhotos()) > 1):?>
                        <?php foreach ($productObject->getProductPhotos() as $index => $photo): ?>
                            <button type="button" data-bs-target="#<?= $productObject->getId()?>" data-bs-slide-to="<?= $index ?>" <?= $index === 0 ? 'class="active" aria-current="true"' : '' ?> aria-label="Slide <?= $index + 1 ?>"></button>
                        <?php endforeach; ?>
                    <?php endif;?>
                </div>
                <div class="carousel-inner">
                    <?php foreach ($productObject->getProductPhotos() as $index => $photo): ?>
                        <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                            <img  src="<?= $photo['photo_filepath'] ?>" class="d-block w-100" alt="...">
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php if(count($productObject->getProductPhotos()) > 1):?>
                    <button class="carousel-control-prev" type="button" data-bs-target="#<?= $productObject->getId() ?>" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#<?= $productObject->getId() ?>" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                <?php endif;?>
            </div>
        </div>
        <div class="col-md-6 description-container">
            <div class="description">
                <table class="table">
                    <tbody>
                    <tr>
                        <td>Назва:</td>
                        <td><?= $productObject->getName() ?></td>
                    </tr>
                    <tr>
                        <td>Розміри:</td>
                        <td class="sizes">
                            <ul>
                                <?php foreach ($productObject->getPricesAndSizes() as $index => $size): ?>
                                    <li class="<?= $index === 0 && count($productObject->getPricesAndSizes()) > 1? "active-li" : '' ?>">
                                        <?= $size["size"] ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </td>
                    </tr>
                    <tr class="quantity">
                        <td>К-сть
                            <p style="font-size: 10px; color: darkred;">
                                Одна людина може придбати не більше 4
                            </p>
                        </td>
                        <td class="productNum" ><input  type="number" min="1" max="4" value="1">
                            <p style="display: none; font-size: 10px; color: darkred;">Кількість товару в кошику перевищує 4</p>
                        </td>
                    </tr>
                    <tr>
                        <td>Ціна:</td>
                        <td class="price"></td>
                    </tr>
                    <tr>
                        <td>Рейтинг:</td>
                        <td><?= $productObject->getAvgRating()?> / 5</td>
                    </tr>
                    <tr>
                        <td>Опис:</td>
                        <td><?= $productObject->getDescription() ?></td>
                    </tr>
                    <tr>
                        <td><button type="submit" class="btn addToBasket">Купити</button></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php if(Core::getInstance()->getCurrentSession()->userIsLoggedIn()):?>
    <div class="row">
        <div class="col-md-6">
            <div class="card mt-4 add-comment">
                <div class="card-header">
                    Додати коментар
                </div>
                <div class="card-body">
                    <form class="form" method="POST">
                        <div class="mb-3 row">
                            <label for="comment">Коментар: </label>
                            <textarea  id="comment" name="comment" rows="3" placeholder="Додайте сюди коментар"></textarea>
                        </div>
                        <div class="mb-3 row">
                            <label for="rating" class="form-label">Рейтинг: </label>
                            <input type="range" id="rating" name="rating" min="1" max="5" step="1" oninput="this.nextElementSibling.value = this.value">
                            <output id="ratingValue" name="ratingValue">3</output>
                        </div>
                        <div class="add-button">
                            <button type="submit" class="btn col">Додати</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php endif;?>
        <div class="col-md-6 comments">
            <div class="card mt-4">
                <div class="card-header">
                   Коментарі
                </div>
                <div>
                    <?php foreach ($productObject->getRatingAndComments() as $comment): ?>
                        <div class="card-body">
                            <h5 class="card-title"><?= $comment["author"] ?></h5>
                            <p class="card-text">Оцінка: <?= $comment["stars"] ?></p>
                            <p class="card-text"><?= $comment["comment"] ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const quantityBox = document.querySelector(".quantity");
        const sizesArray = document.querySelectorAll(".sizes li");
        const buyButton = document.querySelector(".addToBasket");
        const price = document.querySelector(".price");
        const content = document.querySelector(".content");
        const quantityInput = document.querySelector(".productNum");
        const productInformArray = <?=$pricesAndSizesJSON?>;
        updatePriceAndQuantity(0);

        sizesArray.forEach((item, index) => {
            if (item.textContent.trim() === "No size" || item.textContent.trim() === "One Size") {
                setQuantityBoxVisible(item);
            } else {
                item.addEventListener("click", () => setActiveSize(item, index));
            }
        });

        function setQuantityBoxVisible(item) {
            updatePriceAndQuantity(0);
            quantityBox.style.display = "table-row";
            item.classList.add("no-hover");
        }

        function setActiveSize(item, index) {
            sizesArray.forEach(size => size.classList.remove("active-li"));
            item.classList.add("active-li");
            updatePriceAndQuantity(index);
        }

        function updatePriceAndQuantity(index) {
            const maxQuantity = Math.min(productInformArray[index].quantity, 4);
            if (maxQuantity === 0) {
                quantityInput.innerHTML = `<span style='color: darkred; font-weight: bold;'>Немає в наявності</span>`;
            } else {
                const inputHTML = `<input class="productNum" type="number" min="1" max="${maxQuantity}" value="1">`;
                const errorMessageHTML = `<p style="display: none; font-size: 10px; color: darkred;">Кількість товару в кошику перевищує ${maxQuantity}</p>`;
                quantityInput.innerHTML = `${inputHTML}${errorMessageHTML}`;
            }
            price.textContent = productInformArray[index].price + " ГРН";
            quantityBox.style.display = "table-row";
        }
        const commentForm = document.querySelector('.add-comment form');
        if (commentForm != null) {
            commentForm.addEventListener('submit', (event) => {
                event.preventDefault();
                const formData = new FormData(commentForm);
                fetch(window.location.href, {
                    method: 'POST',
                    body: formData
                }).then(response => {
                    return response.text();
                }).then(data => {
                    content.innerHTML = data;
                }).catch(error => {
                    console.error('Помилка', error);
                })
            });
        }
        buyButton.addEventListener("click",() => {
            let cart = JSON.parse(localStorage.getItem('<?=$user_id?>')) || [];
            let productId = <?= $productObject->getId() ?>;
            let selectedSize = document.querySelector(".active-li") ? document.querySelector(".active-li").textContent.trim() : document.querySelector(".no-hover").textContent.trim();
            let existingProductIndex = cart.findIndex(item => item.id === productId && item.size === selectedSize);
            if (existingProductIndex !== -1) {
                let newQuantity = cart[existingProductIndex].quantity + parseInt(document.querySelector(".quantity input").value);
                if (newQuantity <= 4) {
                    cart[existingProductIndex].quantity = newQuantity;
                } else {
                    document.querySelector(".quantity td:last-child > p").style.display = "block";
                }
            } else {
                let quantity = parseInt(document.querySelector(".quantity input").value);
                if (quantity <= 4) {
                    cart.push({
                        id: productId,
                        size: selectedSize,
                        quantity: quantity
                    });
                } else {
                    document.querySelector(".quantity td:last-child > p").style.display = "block";
                }
            }
            localStorage.setItem('<?=$user_id?>', JSON.stringify(cart));
        })
    });
</script>
