{extends file="base.tpl"}
    {block name=content}
        <form action="/admin/login" method="post">
            <p>Для доступа в этот раздел необходима авторизация></p>
            <label for="login">Login</label><input name="login" id="login">
            <label for="password">Password</label><input type="password" name="password" id="password">
            <button type="submit">Log in</button>
        </form>
    {/block}