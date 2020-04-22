<html>
{block name=head}
<head>
    <title>Online Shop</title>
    <link rel="stylesheet" type="text/css" href="/assets/css/styles.css">
    <script src="/assets/js/jquery-3.5.0.min.js"></script>
    <script src="/assets/js/scripts.js"></script>
</head>
{/block}
<body>

<div class="b-header">
{block name=header}
    <a href="/"><img class="b-header__logo" src="/assets/img/logo.png" alt="Online Shop"></a>
    <a href="/cart/" class="b-header__cart">
        <img class="b-header__cart-img" src="/assets/img/cart.png" alt="Корзина">
        <div class="b-cart__description">
            <p>Корзина</p>
            <p class="b-cart__info">
                {if count($cart->getProducts()) == 0}
                    Корзина пуста
                {else}
                    <span class="cart_count">{{count($cart->getProducts())}}</span> товаров
                    на сумму <span class="cart_sum">{{$cart->getSum()}}</span> руб.
                {/if}
            </p>
        </div>
    </a>
{/block}
</div>

<div class="b-content">
    <div class="b-messages_wrapper">
        <div class="b-messages b-messages_success {if count($messages) eq 0}b-messages_hide{/if}">
            {foreach from=$messages item=$message}
                <p>{{$message}}</p>
            {/foreach}
        </div>

        <div class="b-messages b-messages_errors {if count($errors) eq 0}b-messages_hide{/if}">
            {foreach from=$errors item=$error}
                <p>{{$error}}</p>
            {/foreach}
        </div>
    </div>

    {block name=content}
        Content here
    {/block}
    </div>
</div>

<div class="b-footer">
{block name=footer}
    Created by Alex Warno, 2020
{/block}
</div>

</body>
</html>