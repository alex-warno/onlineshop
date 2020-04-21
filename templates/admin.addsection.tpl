{extends file="base.tpl"}
    {block name=content}
        <form enctype="multipart/form-data" action="" method="post">
            <p><label for="tag">Машиночитаемый тэг: </label><input name="tag" id="tag"></p>
            <p><label for="HumanName">Человекочитаемое название: </label><input name="humanName" id="human_name">
            <p>
                <label for="parent">Родительский раздел: </label>
                <select name="parent" id="parent">
                <option selected value="0">Нет</option>
                {foreach from=$sections item=$section}
                    <option value="{{$section->id}}">{{$section->humanName}}</option>
                {/foreach}
                </select>
            </p>
            <input type="hidden" name="MAX_FILE_SIZE" value="5000000"
            <p><label for="image">Изображение: </label><input type="file" name="image" id="image"></p>
            <button type="submit">Создать</button>
        </form>
    {/block}