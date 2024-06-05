<?php
/** @var array $productObjects */
?>
<div class="product-grid">
    <?php foreach ($productObjects as $productObject):?>
        <div class="card col" style="width: 18rem;">
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
                <p class="card-text text-center"><?= $productObject->getDescription() ?></p>
                <a href="#" class="btn ">Купити</a>
            </div>
        </div>
    <?php endforeach;?>
</div>
