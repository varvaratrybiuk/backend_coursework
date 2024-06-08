<?php
/** @var array $productObjs */
/** @var float $price */
/** @var array $data */
$fullprice = 0;
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
                    <li>Ціна: <?= $item[1]?> </li>
                    <?php $fullprice += $item[1]?>
                </ul>
            </div>
        <?php endforeach;?>
    </div>
    <div class="col  finale">
        <p>Всього до сплати:  <?= $fullprice?></p>
        <a href="http://merchua/payment" class="btn">Оформити замовлення</a>
    </div>
</div>
