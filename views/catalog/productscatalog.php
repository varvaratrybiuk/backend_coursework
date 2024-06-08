<?php
/** @var array $productObjects */
?>
<div class="sorting-and-products">
    <div class="sorting-container">
        <form class="form"  id="form" method="GET" action="">
            <div class="sort-group">
                <div class="header">
                    <label>Сортувати за ціною:</label>
                </div>
                <div>
                    <label>
                        <input type="radio" name="sortPrice" value="ASC">
                        Від дешевших до дорожчих
                    </label>
                    <label>
                        <input type="radio" name="sortPrice" value="DESC">
                        Від дорожчих до дешевших
                    </label>
                </div>
            </div>
            <div class="sort-group">
                <div class="header">
                    <label>Сортувати за рейтингом:</label>
                </div>
                <div>
                    <label>
                        <input type="radio" name="sortRating" value="ASC">
                        Від нижчого до вищого
                    </label>
                    <label>
                        <input type="radio" name="sortRating" value="DESC">
                        Від вищого до нижчого
                    </label>
                </div>
            </div>
            <button type="submit" class="btn">Сортувати</button>
        </form>
    </div>
    <div class="product-grid" id = "product-grid">
        <?php foreach ($productObjects as $productObject):?>
            <div class="card col" style="width: 100%;">
                <div id="<?= $productObject->getId() ?>" class="carousel carousel-dark slide">
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
                                <img src="<?= $photo['photo_filepath'] ?>" class="d-block w-100" alt="...">
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
                <div class="card-body">
                    <h5 class="card-title"><?= $productObject->getName() ?></h5>
                    <?php if (count($productObject->getPricesAndSizes()) > 1): ?>
                        <p class="card-text fw-bold"> Від <?= $productObject->getMinPrice() ?> ГРН</p>
                    <?php else: ?>
                        <p class="card-text fw-bold"><?= $productObject->getMinPrice() ?> ГРН</p>
                    <?php endif; ?>
                        <p class="card-text"><?= $productObject->getAvgRating()?> / 5 </p>
                    <p class="card-text"><?= $productObject->getDescription() ?></p>
                    <a href="http://merchua/catalog/product/<?=$productObject->getId()?>" class="btn">Купити</a>
                </div>
            </div>
        <?php endforeach;?>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const container = document.getElementById("content");
        const urlParams = new URLSearchParams(window.location.search);
        const formData = new FormData();
        formData.append('sortPrice', urlParams.get('sortPrice'));
        formData.append('sortRating', urlParams.get('sortRating'));
        sendData(formData);

        function sendData(formData) {
            const requestOptions = {
                method: "POST",
                body: formData
            };
            fetch(window.location.href, requestOptions)
                .then(response => {
                    return response.text();
                })
                .then(data => {
                    container.innerHTML = data;
                })
                .catch(error => {
                    console.error('Помилка:', error);
                });
        }
    });
</script>