<?php
/** @var array $products */
/** @var array $artists */
/** @var array $sizes */
?>
<div class ="row container-fluid">
    <div class ="col auto table-container">
        <table class="table">
            <thead>
            <tr>
                <th>Ім'я товару</th>
                <th>Опис</th>
                <th>Ціна</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($products as $product): ?>
               <tr>
                   <td><?=$product->getName()?></td>
                   <td><?=$product->getDescription()?></td>
                   <td>
                       <ul>
                           <?php foreach ($product->getPricesAndSizes() as $inform): ?>
                            <li><?=$inform["size"]?>: <?=$inform["price"]?></li>
                           <?php endforeach; ?>
                       </ul>
                   </td>
               </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="col auto">
        <div class="container-md form-container">
            <h2>Форма додавання товару</h2>
            <form id="productForm" method="POST" class="productForm">
                <div class="row g-1 form-field">
                    <div class="col auto">
                        <label for="name">Назва товару</label>
                    </div>
                    <div class="col auto">
                        <input type="text" id="name" name="name" required>
                    </div>
                </div>
                <div class="row g-1 form-field">
                    <div class="col auto">
                        <label for="description">Опис</label>
                    </div>
                    <div class="col auto">
                        <textarea id="description" name="description" rows="4" required></textarea>
                    </div>
                </div>
                <div class="row g-1 form-field">
                    <div class="col auto">
                        <label for="photos">Фотографії</label>
                    </div>
                    <div class="col auto">
                        <input type="file" id="photos" name="photos[]" accept="image/*" multiple>
                        <div class="photo-container" id="photoContainer"></div>
                    </div>
                </div>
                <div class="row g-1 form-field">
                    <div class="col auto">
                        <label for="artist">Артист</label>
                    </div>
                    <div class="col auto">
                        <select id="artist" name="artist" required>
                            <option value="0">
                                Обрати...
                            </option>
                            <?php foreach ($artists as $artist): ?>
                                <option value= <?=$artist["artist_id"]?>>
                                    <?=$artist["artist_name"]?>
                                </option>
                            <?php endforeach; ?>

                        </select>
                    </div>
                </div>
                <div class="row g-1 form-field">
                    <div class="col auto d-flex justify-content-center">
                        <button type="submit">Додати товар</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="container-md form-container">
            <h2>Форма додавання варіанту товару</h2>
            <form id="variantForm" method="POST" class="variantForm">
                <div class="row g-1 form-field">
                    <div class="col auto">
                        <label for="product">Товар: </label>
                    </div>
                    <div class="col auto">
                        <select id="product" name="product" required>
                            <option value="0">
                                Обрати...
                            </option>
                            <?php foreach ($products as $product): ?>
                                <option value= <?=$product->getId()?>>
                                    <?=$product->getName()?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="row g-1 form-field">
                    <div class="col auto">
                        <label for="size">Розмір</label>
                    </div>
                    <div class="col auto">
                        <select id="size" name="size" required>
                            <option value="0">
                                Обрати...
                            </option>
                            <?php foreach ($sizes as $size): ?>
                                <option value= <?=$size["id"]?>>
                                    <?=$size["size"]?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="row g-1 form-field">
                    <div class="col auto">
                        <label for="quantity">Кількість</label>
                    </div>
                    <div class="col auto">
                        <input type="number" id="quantity" min="1" name="quantity" required>
                    </div>
                </div>
                <div class="row g-1 form-field">
                    <div class="col auto">
                        <label for="price">Ціна</label>
                    </div>
                    <div class="col auto">
                        <input type="text" id="price" name="price" required>
                    </div>
                </div>
                <div class="row g-1 form-field">
                    <div class="col auto d-flex justify-content-center">
                        <button type="submit">Додати варіант</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    let variantAdded = false;
    const productForm = document.getElementById("productForm");
    const variantForm = document.getElementById("variantForm");

    productForm.addEventListener("submit", (event) => {
        event.preventDefault();
        sendData(productForm);
    });

    variantForm.addEventListener("submit", (event) => {
        event.preventDefault();
        sendData(variantForm);
    });

    function sendData(form) {
        let formData = new FormData(form);
        const requestOptions = {
            method: "POST",
            body: formData
        };
        console.log(window.location.href + `/${form.id}`);
        fetch(window.location.href + `/${form.id}`, requestOptions)
            .then(response => response.text())
            .then(data => {
                location.reload();
            })
            .catch(error => {
                console.error('Помилка:', error);
            });
    }


</script>

