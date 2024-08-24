<!DOCTYPE html>
<html>

<head>
    <title>Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <header class="p-3 mb-3 border-bottom">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-between">
                <ul class="nav col-12 col-lg-auto me-lg-auto justify-content-center">
                    <li><a href="/" class="nav-link px-2 link-body-emphasis" style="color: black;">Back to home</a></li>
                    <!-- другие ссылки -->
                </ul>
            </div>
        </div>
    </header>

    <div class="container">
        <h1>Shopping Cart</h1>
        <?php if (isset($cartItems) && !empty($cartItems)): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Price</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $totalAmount = 0; // Переменная для хранения общей суммы
                    foreach ($cartItems as $item):
                        $total = $item['price'] * $item['quantity']; // Подсчитываем общую сумму для каждой строки
                        $totalAmount += $total; // Добавляем к общей сумме
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($item['name_toys']) ?></td>
                            <td><?= htmlspecialchars($item['price']) ?> ₽</td>
                            <td><?= htmlspecialchars($item['quantity']) ?></td>
                            <td><?= htmlspecialchars($total) ?> ₽</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="text-end"> <!-- Выводим общую сумму справа внизу -->
                <h4>Total: <?= htmlspecialchars($totalAmount) ?> ₽</h4>
            </div>
            <div class="text-end">
                <a href="" class="btn btn-primary" style="background-color: hotpink; border-color: hotpink;">Proceed to
                    Checkout</a>
            </div>
        <?php else: ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>
    </div>
</body>

</html>