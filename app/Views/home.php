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
    <?php $defaultImage = '/images/default.png'; ?>
    <div class="container">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-3">
            <?php if (!empty($data['toys'])): ?>
                <?php foreach ($data['toys'] as $toy): ?>
                    <?php $imageUrl = !empty($toy['photo_url']) ? htmlspecialchars($toy['photo_url']) : $defaultImage; ?>
                    <div class="col">
                        <div class="card shadow-sm">
                            <img class="bd-placeholder-img card-img-top" src="<?php echo $imageUrl; ?>"
                                alt="<?php echo htmlspecialchars($toy['name_toys']); ?>"
                                onerror="this.onerror=null;this.src='<?php echo $defaultImage; ?>';">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($toy['name_toys']); ?></h5>
                                <div class="price-button-container">
                                    <p class="price">Price: <?php echo htmlspecialchars($toy['price']); ?></p>
                                    <a href="#" class="btn-cart <?php echo empty($cartImage) ? 'no-img' : ''; ?>">
                                        <?php if (!empty($cartImage)): ?>
                                            <img src="<?php echo htmlspecialchars($cartImage); ?>" alt="Cart">
                                        <?php else: ?>
                                            <span>Cart</span> <!-- Текст, если изображение отсутствует -->
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
    </div>
    <?php include 'footer.php'; ?>
</body>

</html>