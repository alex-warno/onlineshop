{block name=path}
    <div class="b-path">
        {foreach from=$path item=$item name=loop}
            <a href="/?sect={{$item->tag}}">{{$item->humanName}}</a>{if !$smarty.foreach.loop.last} -> {/if}
        {/foreach}
    </div>
{/block}