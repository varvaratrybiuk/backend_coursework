<?php
/** @var string $userMenuContent */
?>

<div class ="container-fluid menu-container">
    <div class="list-group user-menu">
        <a href="http://merchua/profile/contact" class="list-group-item list-group-item-action ">Контактна інформація</a>
        <a href="http://merchua/profile/address" class="list-group-item list-group-item-action">Адресна книга</a>
        <a href="http://merchua/profile/history" class="list-group-item list-group-item-action">Історія замовлень</a>
    </div>
    <div class="user-menu-items">
        <?= $userMenuContent ?>
    </div>
</div>
