{extends file="base.tpl"}
{block name=content}
    {include file="path.tpl"}
    <div class="b-product">
        <img src="/assets/img/products/{{$product->imagefile}}" class="b-product__image" alt="{{$product->name}}">
        <h1>{{$product->name}}</h1>
        <h2>{{$product->price}} руб.</h2>
        <p>{{$product->description}}</p>
    </div>
    <div class="b-product__add-block">
        {if $product->getAmount() gt 0}
            <p><label for="product{{$product->id}}">Количество: </label><input type="number" id="product{{$product->id}}" value="1"></p>
            <p><button class="addCartButton b-button" id="add{{$product->id}}">В корзину</button></p>
        {else}
            <p>Товар закончился</p>
        {/if}
    </div>
{/block}