<?php
/** @var array $productObjs */
/** @var float $price */
/** @var array $data */
?>
<div class="row">
    <div class="col  products">
        <?php foreach ($data as $item): ?>
            <div class="product-holder">
                <ul>
                    <li><img src="<?=$item[0]->getProductPhotos()[0]["photo_filepath"]?>" /></li>
                    <li>Ім'я товару: "<?=$item[0]->getName()?>"</li>
                    <li class = "size">Розмір: </li>
                    <li class = "quantity">К-сть: </li>
                    <li class ="productPrice">Ціна: <span><?= $item[1]?></span> </li>
                </ul>
            </div>
        <?php endforeach;?>
    </div>
    <div class="col  finale">
        <p>Всього до сплати: <span></span></p>
        <a href="http://merchua/payment" class="btn">Оформити замовлення</a>
    </div>
</div>
