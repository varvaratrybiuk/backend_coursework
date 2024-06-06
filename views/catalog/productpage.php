<?php
/** @var ProductDTO $productObject */

use core\Core;
use models\products\ProductDTO;

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
                                <?php foreach ($productObject->getPricesAndSizes() as $size):?>
                                    <li><?= $size["size"] ?></li>
                                <?php endforeach;?>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td>Ціна:</td>
                        <td>
                            <?php
                            $prices = array_unique(array_column($productObject->getPricesAndSizes(), 'price'));
                            foreach ($prices as $price):
                                ?>
                                <span><?= $price ?></span>
                            <?php endforeach; ?>
                            ГРН
                        </td>
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
                        <td><button type="submit" class="btn">Купити</button></td>

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
                    <form class="form">
                        <div class="mb-3 row">
                            <label for="comment">Коментар: </label>
                            <textarea  id="comment" rows="3"></textarea>
                        </div>
                        <div class="mb-3 row">
                            <label for="rating" class="form-label">Рейтинг: </label>
                            <input type="range" id="rating" min="1" max="5" step="1" oninput="this.nextElementSibling.value = this.value">
                            <output>3</output>
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
                    Comments
                </div>
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