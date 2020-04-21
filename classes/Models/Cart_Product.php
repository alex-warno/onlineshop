<?php


namespace Shop\Models;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class cart_Product
 * @package Shop\Models
 *
 * @ORM\Entity
 * @ORM\Table(name="cart_product")
 */
class Cart_Product extends AbstractModel
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
     * @var Cart $cart
     *
     * @ORM\ManyToOne(targetEntity="Cart", inversedBy="cartProducts")
     */
    public $cart;

    /**
     * @var Product $product
     *
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="cartProducts")
     */
    public $product;

    /**
     * @var int $amount
     *
     * @ORM\Column(name="amount", type="integer", nullable=false)
     */
    public $amount = 0;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param Product $product
     */
    public function setProduct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @param Cart $cart
     */
    public function setCart(Cart $cart)
    {
        $this->cart = $cart;
    }

    /**
     * @return Cart
     */
    public function getCart(): Cart
    {
        return $this->cart;
    }

    /**
     * @param int $amount
     */
    public function setAmount(int $amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    public function deleteProduct(Product $product)
    {

    }
}