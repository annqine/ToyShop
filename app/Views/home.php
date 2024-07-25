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
    <style>
        .card-img-top {
            width: 100%;
            height: 200px;
            /* Фиксированная высота */
            object-fit: cover;
            /* Обрезка по центру */
            object-position: center;
            /* Центрирование изображения */
        }

        .card-title {
            font-size: 1rem;
            font-weight: 500;
            line-height: 1.2;
            height: 3.6em;
            /* Высота для трех строк */
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 3;
            overflow: hidden;
            text-align: center;
            word-wrap: break-word;
            text-overflow: ellipsis;
        }

        .price-button-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1rem;
        }

        .price {
            margin-bottom: 0;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .btn-cart {
            padding: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #ff69b4;
            /* Розовый цвет */
            color: white;
            border: none;
            border-radius: 0.25rem;
            cursor: pointer;
        }

        .btn-cart img {
            width: 20px;
            height: 20px;
        }

        .btn-cart:hover {
            background-color: #ff1493;
            /* Темно-розовый цвет при наведении */
        }

        .card-body {
            text-align: center;
        }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>
    <?php $defaultImage = '/images/default.png'; ?>
    <div class="container">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-3">
            <?php if (!empty($data['toys'])): ?>
                <?php foreach ($data['toys'] as $toy):
                    $imageUrl = !empty($toy['photo_url']) ? htmlspecialchars($toy['photo_url']) : $defaultImage;
                    ?>
                    <div class="col">
                        <div class="card shadow-sm">
                            <img class="bd-placeholder-img card-img-top" src="<?php echo $imageUrl; ?>"
                                alt="<?php echo htmlspecialchars($toy['name_toys']); ?>"
                                onerror="this.onerror=null;this.src='<?php echo $defaultImage; ?>';">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($toy['name_toys']); ?></h5>
                                <div class="price-button-container">
                                    <p class="price">Price: <?php echo htmlspecialchars($toy['price']); ?></p>
                                    <button class="btn-cart">
                                        <img src="/images/cart-icon.png" alt="Cart">
                                    </button>
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