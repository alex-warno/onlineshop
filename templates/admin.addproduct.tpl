{extends file="base.tpl"}
    {block name=path}

    {/block}
    {block name=content}
        <form enctype="multipart/form-data" action="" method="post">
            <p><label for="name">Название: </label><input name="name" id="name"></p>
            <p><label for="description">Описание: </label><textarea name="description" id="description"></textarea></p>
            <p><label for="price">Стоимость: </label><input name="price" id="price"></p>
            <p><label for="section">Раздел: </label>
                <select name="section" id="section">
                    {foreach from=$sections item=$section}
                        <option value="{{$section->id}}">{{$section->humanName}}</option>
                    {/foreach}
                </select>
            </p>
            <label for="amount">Количество: </label><input type="number" name="amount" id="amount">
            <input type="hidden" name="MAX_FILE_SIZE" value="5000000">
            <p><label for="image">Изображение: </label><input type="file" name="image" id="image"></p>
            <button type="submit">Добавить товар</button>
        </form>
    {/block}