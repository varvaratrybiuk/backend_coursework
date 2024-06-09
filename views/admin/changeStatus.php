<?php
/** @var array $usersOrders */
/** @var array $ordersProducts */
/** @var array $statuses */
?>
<div class="row container-fluid">
    <div class="col-auto table-container">
        <table class="table">
            <thead>
            <tr>
                <th>Номер замовлення</th>
                <th>Ім'я та прізвище</th>
                <th>Товари</th>
                <th>Адреса</th>
                <th>Статус</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($usersOrders as $userOrder): ?>
                <tr>
                    <td id="id"><?= $userOrder->getOrderId(); ?></td>
                    <td><?= $userOrder->getFullName(); ?></td>
                    <td>
                        <ul>
                            <?php foreach ($ordersProducts as $orderProduct): ?>
                                <?php if ($orderProduct->getOrderId() === $userOrder->getOrderId()): ?>
                                    <li><?= $orderProduct->getProductName() . ' (' . $orderProduct->getQuantity() . ')'; ?></li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </td>
                    <td><?php echo $userOrder->getAddress(); ?></td>
                    <td>
                        <select class="status">
                            <?php
                            foreach ($statuses as $status): ?>
                                <option value="<?= $status['id']; ?>" <?= ($status['id'] === $userOrder->getStatus()) ? 'selected' : ''; ?>>
                                    <?= $status['status_description']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectElements = document.querySelectorAll('.status');
        selectElements.forEach(selectElement => {
            if (selectElement.value === '4' || selectElement.value === '5') {
                selectElement.disabled = true;
            }
            selectElement.addEventListener('change', function () {
                const orderId = selectElement.closest('tr').querySelector('#id').textContent;
                const newStatusId = selectElement.value;
                const formData = new FormData();
                formData.append('orderId', orderId);
                formData.append('newStatusId', newStatusId);
                const requestOptions = {
                    method: "POST",
                    body: formData
                };
                fetch(window.location.href, requestOptions)
                    .then(response => response.text())
                    .then(data => {
                        location.reload();
                    })
                    .catch(error => {
                        console.error('Помилка:', error);
                    });
            });
        });
    });
</script>