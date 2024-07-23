<?php /*include ("header.php") ?>
<div class="container">
    <h1>Cart</h1>
    <div class="row">
        <div class="col-md-12">
            <table class="table">
                <thead>
                    <tr>
                        <th>Toy</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cartContents as $toyId => $quantity): ?>
                        <tr>
                            <td>
                                <?php echo $toyName; ?>
                            </td>
                            <td>$
                                <?php echo $toyPrice; ?>
                            </td>
                            <td>
                                <?php echo $quantity; ?>
                            </td>
                            <td>$
                                <?php echo $totalPrice; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <p>Total: $
                <?php echo $cartTotal; ?>
            </p>
        </div>
    </div>
</div>

<?php include ("footer.php") ?>