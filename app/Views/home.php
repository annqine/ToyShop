<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>All Toys</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body class="body">
    <?php include 'header.php'; ?>
    <?php
    require_once __DIR__ . '/../Controllers/HomeController.php';
    require_once __DIR__ . '/../Controllers/UserController.php';
    $defaultImage = '/images/default.png';
    $cartImage = '/images/cart-icon.png';
    ?>
    <div class="container">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-3">
            <?php if (!empty($data)): ?>
                <?php foreach ($data as $toy): ?>
                    <?php
                    $imageUrl = !empty($toy['photo_url']) ? htmlspecialchars($toy['photo_url']) : $defaultImage;
                    $toyName = htmlspecialchars($toy['name_toys']);
                    $toyPrice = htmlspecialchars($toy['price']);
                    ?>
                    <div class="col">
                        <div class="card shadow-sm">
                            <img class="bd-placeholder-img card-img-top" src="<?php echo $imageUrl; ?>"
                                alt="<?php echo $toyName; ?>"
                                onerror="this.onerror=null;this.src='<?php echo $defaultImage; ?>';">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $toyName; ?></h5>
                                <div class="price-button-container">
                                    <p class="price">Price: <?php echo $toyPrice; ?></p>

                                    <?php if (UserController::isLoggedIn()): ?>
                                        <form action="/addToCart" method="POST" class="d-inline">
                                            <input type="hidden" name="toy_id" value="<?php echo $toy['id']; ?>">
                                            <input type="hidden" name="quantity" value="1"> <!-- или другой нужный вам quantity -->
                                            <button type="submit" class="btn-cart">
                                                <?php if (!empty($cartImage)): ?>
                                                    <img src="<?php echo htmlspecialchars($cartImage); ?>" alt="Cart">
                                                <?php else: ?>
                                                    <span>Cart</span>
                                                <?php endif; ?>
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <a href="/login" class="btn-cart"
                                            onclick="alert('Вы еще не вошли. Пожалуйста, войдите или зарегистрируйтесь.');">
                                            <?php if (!empty($cartImage)): ?>
                                                <img src="<?php echo htmlspecialchars($cartImage); ?>" alt="Cart">
                                            <?php else: ?>
                                                <span>Cart</span>
                                            <?php endif; ?>
                                        </a>
                                    <?php endif; ?>

                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No toys found.</p>
            <?php endif; ?>
        </div>

        <!-- Пагинация -->
        <nav class="m-4" aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <!-- Кнопка "Предыдущая" -->
                <li class="page-item <?php echo ($page == 1) ? 'disabled' : ''; ?>">
                    <a class="page-link"
                        href="?page=<?php echo $page - 1; ?>&rows=<?php echo $rows; ?>&sidx=<?php echo $sidx; ?>&sord=<?php echo $sord; ?>&category=<?php echo $category; ?>&query=<?php echo urlencode($query); ?>"
                        aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>

                <?php
                $totalPages = ceil($total / $rows);
                $startPage = max(1, $page - 2);
                $endPage = min($totalPages, $page + 2);

                if ($startPage > 1): ?>
                    <li class="page-item">
                        <a class="page-link"
                            href="?page=1&rows=<?php echo $rows; ?>&sidx=<?php echo $sidx; ?>&sord=<?php echo $sord; ?>&category=<?php echo $category; ?>&query=<?php echo urlencode($query); ?>">1</a>
                    </li>
                    <?php if ($startPage > 2): ?>
                        <li class="page-item disabled">
                            <span class="page-link">...</span>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>

                <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                    <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                        <a class="page-link"
                            href="?page=<?php echo $i; ?>&rows=<?php echo $rows; ?>&sidx=<?php echo $sidx; ?>&sord=<?php echo $sord; ?>&category=<?php echo $category; ?>&query=<?php echo urlencode($query); ?>">
                            <?php echo $i; ?>
                        </a>
                    </li>
                <?php endfor; ?>

                <?php if ($endPage < $totalPages): ?>
                    <?php if ($endPage < $totalPages - 1): ?>
                        <li class="page-item disabled">
                            <span class="page-link">...</span>
                        </li>
                    <?php endif; ?>
                    <li class="page-item">
                        <a class="page-link"
                            href="?page=<?php echo $totalPages; ?>&rows=<?php echo $rows; ?>&sidx=<?php echo $sidx; ?>&sord=<?php echo $sord; ?>&category=<?php echo $category; ?>&query=<?php echo urlencode($query); ?>">
                            <?php echo $totalPages; ?>
                        </a>
                    </li>
                <?php endif; ?>

                <!-- Кнопка "Следующая" -->
                <li class="page-item <?php echo ($page == $totalPages) ? 'disabled' : ''; ?>">
                    <a class="page-link"
                        href="?page=<?php echo $page + 1; ?>&rows=<?php echo $rows; ?>&sidx=<?php echo $sidx; ?>&sord=<?php echo $sord; ?>&category=<?php echo $category; ?>&query=<?php echo urlencode($query); ?>"
                        aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>

    </div>
    <?php include 'footer.php'; ?>
</body>

</html>