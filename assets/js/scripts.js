handleSuccessChangeCart = data => {
    let $cart_count = $('.cart_count'),
        $cart_sum = $('.cart_sum'),
        $product_amount = $('.product_amount' + data.cart.product_id);
    if ($cart_count.length > 0 && $cart_sum.length > 0 && data.cart.count > 0) {
        $cart_count.html(data.cart.count);
        $cart_sum.html(data.cart.sum);
    } else if (data.cart.count > 0) {
        $('.b-cart__info').html(
            '<span class="cart_count">' +
            data.cart.count +
            '</span> товаров на сумму <span class="cart_sum">' +
            data.cart.sum +
            '</span> руб.')
    } else {
        $('.b-cart__info').html('Корзина пуста')
    }

    if ($product_amount.length > 0) {
        if (data.cart.product_amount > 0) {
            $product_amount.html(data.cart.product_amount)
        } else {
            $product_amount.parents('.b-cart-item').remove();
        }
    }
}

$(function() {
    $('.addCartButton').on('click', e => {
        let $id = e.target.id.replace('add', ''),
            $count = $('#product' + $id).val(),
            $ajaxSettings = {
                type: 'POST',
                url: '/cart/addProduct/' + $id,
                data: {
                    count: $count
                },
                dataType: 'json',
            },
            $request = $.ajax($ajaxSettings);
        $request.done(handleSuccessChangeCart);
        $request.fail(addError('Произошла ошибка'));
    });

    $('.deleteCartButton').on('click', e => {
        let $id = e.target.id.replace('delete', ''),
            $count = $(e.target).hasClass('minus') ? "1" : $(e.target).val(),
            $ajaxSettings = {
                type: 'POST',
                url: '/cart/deleteProduct/' + $id,
                data: {
                    count: $count
                },
                dataType: 'json',
                error: addError('Произошла ошибка')
            },
            $request = $.ajax($ajaxSettings);
        $request.done(handleSuccessChangeCart);
    });
});

addMessage = $message => {
    console.log($message);
}

addError = $message => {
    console.log('error: ' + $message);
}

submitConfirm = form => {
    $('#address').val($('#address_div').html());
    console.log($('#address').val());
    form.submit();
}