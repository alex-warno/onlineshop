{extends file='base.tpl'}
    {block name=content}
        <h1>Ваш заказ оформлен!</h1>
        <p>В ближайшее время с Вами свяжется менеджер магазина.</p>
        {block name=order}
            <div class="b-order">
                <h1>Состав Вашего заказа:</h1>
                {assign var=cProducts value=$confirmedCart->getCartProducts()}
                {foreach from=$cProducts item=$cProduct}
                    {assign var=product value=$cProduct->product}
                    <div class="b-order__item">
                        <p class="b-order__item_name">{{$product->name}}</p>
                        <p class="b-order__item_amount">{{$cProduct->amount}} шт.</p>
                    </div>
                {/foreach}
                <h1>Стоимость: {{$confirmedCart->getSum()}} руб.</h1>
            </div>
        {/block}
    {/block}