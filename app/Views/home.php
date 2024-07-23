<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>All Toys</title>
</head>

<body>
    <?php include 'header.php'; ?>
    <?php if (!empty($data['toys'])): ?>
        <?php foreach ($data['toys'] as $toy): ?>
            <div>
                <h2><?php echo htmlspecialchars($toy['name_toys']); ?></h2>
                <p>Price: <?php echo htmlspecialchars($toy['price']); ?></p>
                <img width="200" src="<?php echo htmlspecialchars($toy['photo_url']); ?>"
                    alt="<?php echo htmlspecialchars($toy['name_toys']); ?>">
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No toys found.</p>
    <?php endif; ?>

    <?php include 'footer.php'; ?>
</body>

</html>