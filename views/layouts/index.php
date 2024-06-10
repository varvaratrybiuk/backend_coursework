<?php
/** @var string $Title
 *  @var string $Content
 *  @var string $Style
 * @var string $Script
 */
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../../public/css/header_and_footer.css">
    <link rel="stylesheet" href=<?= $Style ?>>
    <script defer src=<?= $Script ?? "" ?> ></script>
    <link rel="icon" href="public/images/shipment.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=LXGW+WenKai+Mono+TC&family=Poppins:wght@300&display=swap" rel="stylesheet">
    <title><?= $Title ?></title>
</head>
<body>
<nav class="navbar navbar-expand-xl">
    <div class="container-fluid ">
        <a class="navbar-brand" href="http://merchua/">MERCH UA</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="http://merchua/">Головна</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="http://merchua/catalog/">Каталог</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img alt="profile" src="../../public/images/profile.svg" height="20"/>
                    </a>
                    <ul class="dropdown-menu">
                        <?php if(\core\Core::getInstance()->getCurrentSession()->userIsLoggedIn()):?>
                            <li><a class="dropdown-item" href="http://merchua/profile/contact">Профіль</a></li>
                            <?php if (\core\Core::getInstance()->getCurrentSession()->userIsAdmin()):?>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="http://merchua/admin/update">Оновити ціну та к-сть</a></li>
                                <li><a class="dropdown-item" href="http://merchua/admin/update_status">Оновити статус замовлень</a></li>
                                <li><a class="dropdown-item" href="http://merchua/admin/add">Додати продукт</a></li>
                            <?php endif; ?>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="http://merchua/logout">Вихід</a></li>
                        <?php else: ?>
                            <li><a class="dropdown-item" href="http://merchua/login">Увійти</a></li>
                            <li><a class="dropdown-item" href="http://merchua/register">Зареєструватися</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="http://merchua/cart"><img alt="cart" src="../../public/images/cart.svg" height="20"/></a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="page-container container-fluid">
<div class ="content container-md my-5 mx-auto " id="content">
    <?= $Content?>
</div>
<footer class="footer mt-auto py-2 ">
    <div class="container">
        <div class="row">
            <div class="col">
                <h5>Контакти</h5>
                <p>Email: merchua@gmail.com</p>
                <p>Телефон: +097 00 00 000</p>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col text-center">
                <p>&copy; 2024 MERCH UA. Всі права захищені.</p>
            </div>
        </div>
    </div>
</footer>
</div>
</body>
</html>
