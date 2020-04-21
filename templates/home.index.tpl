{extends file="base.tpl"}
    {block name=content}
        {include file="path.tpl"}
        <h2>Разделы</h2>
        <div class="b-sections">
            {foreach from=$sections item=$section}
                <div class="b-sections__item">
                    <a class="b-sections__link" href="?sect={{$section->tag}}">
                        <img class="b-sections__image" src="/assets/img/sections/{{$section->imagefile}}" alt="{{$section->humanName}}">
                        <p>{{$section->humanName}}</p>
                    </a>
                </div>
            {/foreach}
        </div>
        <h2>Товары</h2>
        <div class="b-products">
            {foreach from=$products item=$product}
                    <div class="b-products__item">
                        <img class="b-products__image" src="/assets/img/products/{{$product->imagefile}}" alt="{{$product->name}}">
                        <div class="b-products__description">
                            <a href="/product/show/{{$product->id}}/"><p>{{$product->name}}</p></a>
                            <p>Стоимость: {{$product->price}} руб.</p>
                            <p><label for="product{{$product->id}}">Количество</label><input type="number" id="product{{$product->id}}" value="1"></p>
                            <p><button class="addCartButton b-button" id="add{{$product->id}}">В корзину</button></p>
                        </div>
                    </div>
            {/foreach}
            {if $pages gt 1}
                <div class="b-paginator">
                    {for $foo=1 to $pages}
                        <a class="b-paginator__item">{{$foo}}</a>
                    {/for}
                </div>
            {/if}
        </div>
    {/block}
