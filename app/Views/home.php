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

<body>
    <?php include 'header.php'; ?>
    <?php $defaultImage = '/images/default.png';
    $cartImage = '/images/cart-icon.png'; ?>
    <div class="container">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-3">
            <?php if (!empty($data['toys'])): ?>
                <?php foreach ($data['toys'] as $toy): ?>
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
                                    <a href="#" class="btn-cart <?php echo empty($cartImage) ? 'no-img' : ''; ?>">
                                        <?php if (!empty($cartImage)): ?>
                                            <img src="<?php echo htmlspecialchars($cartImage); ?>" alt="Cart">
                                        <?php else: ?>
                                            <span>Cart</span>
                                        <?php endif; ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No toys found.</p>
            <?php endif; ?>
        </div>
        <!-- Pagination -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <?php if ($data['page'] > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $data['page'] - 1; ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $data['total']; $i++): ?>
                    <li class="page-item <?php echo $i == $data['page'] ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($data['page'] < $data['total']): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $data['page'] + 1; ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
    <?php include 'footer.php'; ?>
</body>

</html>