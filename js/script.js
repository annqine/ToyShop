// public/js/script.js
/*
$(document).ready(function() {
    // Пример: обработка нажатия на кнопку "Добавить в корзину"
    $('.add-to-cart-btn').click(function() {
        var toyId = $(this).data('toy-id');
        var quantity = parseInt($('#quantity').val()); // предполагается, что количество задается пользователем на странице
        $.ajax({
            url: 'addToCart.php', // адрес обработчика для добавления в корзину
            method: 'POST',
            data: { toy_id: toyId, quantity: quantity },
            success: function(response) {
                alert('Товар успешно добавлен в корзину!');
            },
            error: function(xhr, status, error) {
                alert('Произошла ошибка при добавлении товара в корзину.');
                console.error(xhr.responseText);
            }
        });
    });

    // Пример: обновление содержимого корзины при загрузке страницы
    $('#cart-content').load('cart.php'); // предполагается, что содержимое корзины загружается через AJAX при загрузке страницы
});*/
