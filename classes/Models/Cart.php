<?php


namespace Shop\Models;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Shop\Models\Product;

/**
 * Class cart
 * @package Shop\Models
 *
 * @ORM\Entity
 * @ORM\Table(name="cart")
 */
class Cart extends AbstractModel
{

    /**
     * @var int $id
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    public $id;

    /**
     * @var string $hashId
     *
     * @ORM\Column(name="hash_id", type="string", length=30, nullable=false)
     */
    public $hashId;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=30, nullable=false)
     */
    public $name = '';

    /**
     * @var string address
     *
     * @ORM\Column(name="address", type="string", length=100, nullable=false)
     */
    public $address = '';

    /**
     * @var string $mail
     *
     * @ORM\Column(name="mail", type="string", length=30, nullable=false)
     */
    public $mail = '';

    /**
     * @var string $phone
     *
     * @ORM\Column(name="phone", type="string", length=15, nullable=false)
     */
    public $phone = '';

    /**
     * @var DateTime $delivery
     *
     * @ORM\Column(name="delivery", type="datetime", nullable=true)
     */
    public $delivery;

    /**
     * @var string $status
     *
     * @ORM\Column(name="status", type="string", length=10, nullable=false)
     */
    public $status = 'new';

    /**
     * @var Collection $cartProducts
     *
     * @ORM\OneToMany(targetEntity="Cart_Product", mappedBy="cart", fetch="EAGER")
     */
    public $cartProducts;

    public function __construct()
    {
        $this->cartProducts = new ArrayCollection();
        parent::__construct();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $address
     */
    public function setAddress(string $address)
    {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @param string $mail
     */
    public function setMail(string $mail)
    {
        $this->mail = $mail;
    }

    /**
     * @return string
     */
    public function getMail(): string
    {
        return $this->mail;
    }

    /**
     * @param string $phone
     */
    public function setPhone(string $phone)
    {
        $this->phone = $phone;
    }

    /**
     * @param string $delivery
     * @throws Exception
     */
    public function setDelivery(string $delivery)
    {

        $this->delivery = new DateTime($delivery);
    }

    /**
     * @return DateTime
     */
    public function getDelivery(): DateTime
    {
        return $this->delivery;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status)
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $hashId
     */
    public function setHashId(string $hashId)
    {
        $this->hashId = $hashId;
    }

    /**
     * @return string
     */
    public function getHashId(): string
    {
        return $this->hashId;
    }

    /**
     * @param Collection $cartProducts
     */
    public function setCartProducts(Collection $cartProducts)
    {
        $this->cartProducts = $cartProducts;
    }

    /**
     * @return ArrayCollection
     */
    public function getCartProducts(): Collection
    {
        return $this->cartProducts;
    }

    public function getProducts() {
        $result = [];
        foreach ($this->getCartProducts() as $cartProduct) {
            for ($count = 1; $count <= $cartProduct->getAmount(); $count++) {
                $result[] = $cartProduct->getProduct();
            }
        }
        return $result;
    }

    public function getSum() {
        $sum = 0;
        foreach ($this->getProducts() as $product) {
            $sum += $product->getPrice();
        }
        return $sum;
    }

    public function validate() {
        $errors = [];
        if ($this->name == '') {
            $errors[] = 'Введите ФИО';
        }
        if ($this->address == '') {
            $errors[] = 'Введите адрес';
        }
        if ($this->phone == '') {
            $errors[] = 'Введите номер тефона';
        }
        if (preg_match('/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/', $this->phone) == false) {
            $errors[] = 'Некорректный номер телефона';
        }
        if ($this->mail == '') {
            $errors[] = 'Введите e-mail';
        }
        if (preg_match('/^\S+@\S+[.]\S+$/', $this->mail) == false) {
            $errors[] = 'Некорректный e-mail';
        }
        if (!$this->delivery || (new DateTime('tomorrow'))->modify('+ 10 hours') > $this->delivery) {
            $errors[] = 'Дата и время доставки некорректны';
        }
        return $errors;
    }
}