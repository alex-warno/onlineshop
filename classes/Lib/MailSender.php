<?php


namespace Shop\Lib;


use Shop\Models\Cart;
use Shop\View;

/**
 * Здесь бы подключить рассыльщик типа SendGrid, но...
 *
 * Class MailSender
 * @package Shop\Lib
 */
class MailSender
{

    /**
     * @param Cart $cart
     */
    public static function sendConfirmMails($cart) {
        $mail_sender = Config::getConfig('mail:sender');
        $subject_customer = 'Ваш заказ оформлен';
        $mail_customer = $cart->getMail();
        $subject_admin = 'Получен заказ';
        $mail_admin = Config::getConfig('mail:adminMail');
        $view = new View();
        $text_customer = $view->fetch('mail/customers/order_confirmed.tpl');
        mail($mail_customer, $subject_customer, $text_customer, ['FROM: '.$mail_sender]);
        $text_admin = $view->fetch('mail/admins/order_confirmed.tpl');
        mail($mail_admin, $subject_admin, $text_admin, ['FROM: '.$mail_sender]);
    }

}