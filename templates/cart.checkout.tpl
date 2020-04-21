{extends file="base.tpl"}
    {block name=content}
        {include file="order.tpl"}
        <form class="b-form" action="" method="post" onsubmit="submitConfirm(this); return false;">
            <h2>Заполните данные для оформления заказа</h2>
            <p class="b-form-field"><label class="b-form-field__label" for="name">ФИО: </label><input class="b-form-field__input" name="name" id="name"></p>
            <p class="b-form-field"><label class="b-form-field__label" for="mail">Эл. почта: </label><input class="b-form-field__input" type="email" name="mail" id="mail"></p>
            <p class="b-form-field"><label class="b-form-field__label" for="phone">Телефон: </label><input class="b-form-field__input" name="phone" id="phone" type="tel"></p>
            <div class="b-form-field"><span class="b-form-field__label">Адрес доставки: </span><div class="b-form-field__input" id="address_div" contenteditable="true"></div></div>
            <input type="hidden" name="address" id="address">
            <p class="b-form-field"><label class="b-form-field__label" for="delivery">Дата и время доставки: </label><input  class="b-form-field__input" type="datetime-local" name="delivery" id="delivery" min="{{"+ 1 days"|date_format:"%Y-%m-%dT%H:%M"}}" value="{{"+ 1 days"|date_format:"%Y-%m-%dT%H:%M"}}"></p>
            <button class="b-button confirmOrderButton" type="submit" name="submit">Отправить</button>
        </form>
    {/block}