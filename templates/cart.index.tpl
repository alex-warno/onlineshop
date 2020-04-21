{extends file="base.tpl"}
    {block name=content}
        <div class="b-cart__info b-cart__info_big">
        {assign var=cProducts value=$cart->getCartProducts()}
        {if count($cProducts) == 0}
            Корзина пуста
        {else}
            <span class="cart_count">{{count($cart->getProducts())}}</span> товаров
            на сумму <span class="cart_sum">{{$cart->getSum()}}</span> руб.
        {/if}
        </div>
        {foreach from=$cProducts item=$cProduct}
            {assign var=product value=$cProduct->product}
            <div class="b-cart-item">
                <img class="b-cart-item__image" src="/assets/img/products/{{$product->imagefile}}" alt="{{$product->name}}">
                <div class="b-cart-item__description">
                    <a href="/product/show/{{$product->id}}"><p>{{$product->name}}</p></a>
                    <p>{{$product->price}} руб.</p>
                    <div class="b-cart-item__plusminus">
                        <img class="b-cart-item__plusminus_button deleteCartButton minus" src="/assets/img/minus.png" id="delete{{$product->id}}" alt="Меньше">
                        <span class="product_amount{{$product->id}}">{{$cProduct->amount}}</span>
                        <input type="hidden" id="product{{$product->id}}" value="1">
                        <img class="addCartButton b-cart-item__plusminus_button" src="/assets/img/plus.png" id="add{{$product->id}}" alt="Больше">
                    </div>
                    <button class="b-button deleteCartButton" id="delete{{$product->id}}" value="{{$cProduct->amount}}">Удалить из корзины</button>
                </div>
            </div>
        {/foreach}
        {if count($cProducts) != 0}
            <a href="/cart/checkout/"><button class="b-button">Оформить заказ</button></a>
        {/if}
    {/block}