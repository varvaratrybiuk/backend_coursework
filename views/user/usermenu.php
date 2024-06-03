<?php
/** @var string $userMenuContent */
?>

<div class ="container-fluid menu-container">
    <div class="list-group user-menu">
        <a href="http://merchua/profile/contactInfo" class="list-group-item list-group-item-action ">Контактна інформація</a>
        <a href="http://merchua/profile/addressBook" class="list-group-item list-group-item-action">Адресна книга</a>
        <a href="http://merchua/profile/orderHistory" class="list-group-item list-group-item-action">Історія замовлень</a>
    </div>
    <div class="user-menu-items">
        <?= $userMenuContent ?>
    </div>
</div>
