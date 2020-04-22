<?php


namespace Shop\Lib;


use Exception;
use SendGrid\Mail\Mail;
use SendGrid\Mail\TypeException;
use Shop\Models\Cart;
use Shop\View;
use SmartyException;
use Shop\Lib\Exceptions\ServerErrorException;

class MailSender
{

    /**
     * @param Cart $cart
     * @throws ServerErrorException
     * @throws SmartyException
     * @throws TypeException
     */
    public static function sendConfirmMails($cart) {
        $view = new View();
        $view->assign('cart', $cart);

        $mail_customer = new Mail();
        $mail_customer->setFrom(Config::getConfig('mail:sender'));
        $mail_customer->setSubject('Ваш заказ оформлен');
        $mail_customer->addTo($cart->getMail());
        $mail_customer->addContent("text/html", $view->fetch('mail/customers/order_confirmed.tpl'));

        $mail_admin = new Mail();
        $mail_admin->setFrom(Config::getConfig('mail:sender'));
        $mail_admin->setSubject('Новый заказ!');
        $mail_admin->addTo(Config::getConfig('mail:adminMail'));
        $mail_admin->addContent('text/html', $view->fetch('mail/admins/order_confirmed.tpl'));

        $sendgrid = new \SendGrid(Config::getConfig('mail:sendgridKey'));
        try {
            $response_c = $sendgrid->send($mail_customer);
            $response_a = $sendgrid->send($mail_admin);
        } catch (Exception $e) {
            //log this
        }
    }

}