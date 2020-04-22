<head>

</head>
<body>
    <p style="text-align: center">Поступил заказ</p>
    <div>
        <h1>Состав заказа:</h1>
        {assign var=cProducts value=$cart->getCartProducts()}
        {foreach from=$cProducts item=$cProduct}
            {assign var=product value=$cProduct->product}
            <div style="display: flex; justify-content: space-between;">
                <p style="width: 90%; padding: 10px; margin: 3px 0; border: 1px solid lightgray; box-sizing: border-box;">{{$product->name}}</p>
                <p style="width: 10%; text-align: center; padding: 10px; margin: 3px 0; border: 1px solid lightgray; box-sizing: border-box;">{{$cProduct->amount}} шт.</p>
            </div>
        {/foreach}
        <h1>Стоимость: {{$cart->getSum()}} руб.</h1>
    </div>
    <div>
        <h1>Информация о заказе</h1>
        <p>Идентификатор заказа: {{$cart->id}}</p>
        <p>ФИО: {{$cart->name}}</p>
        <p>Телефон: {{$cart->phone}}</p>
        <p>Адрес: {{$cart->address}}</p>
        <p>Дата и время доставки: {{$cart->delivery|date_format: '%e/%m/%Y %H:%M'}}</p>
    </div>
</body>