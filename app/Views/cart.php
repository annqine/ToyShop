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
                    <li><a href="/login" class="nav-link px-2 link-body-emphasis">Login</a></li>
                    <li><a href="/cart" class="nav-link px-2 link-body-emphasis">Cart</a></li>
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
                    <?php foreach ($cartItems as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['name']) ?></td>
                            <td><?= htmlspecialchars($item['price']) ?> ₽</td>
                            <td><?= htmlspecialchars($item['quantity']) ?></td>
                            <td><?= htmlspecialchars($item['price'] * $item['quantity']) ?> ₽</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <a href="/checkout" class="btn btn-primary">Proceed to Checkout</a>
        <?php else: ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>
    </div>
</body>

</html>