<?php


namespace Shop\Models;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Product
 * @package Shop\Models
 *
 * @ORM\Entity
 * @ORM\Table(name="product")
 */
class Product extends AbstractModel
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
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    public $name;

    /**
     * @var string $description
     *
     * @ORM\Column(name="description", type="string", length=20000, nullable=false)
     */
    public $description;

    /**
     * @var float $price
     *
     * @ORM\Column(name="price", type="float", nullable=false)
     */
    public $price;

    /**
     * @var int $amount
     *
     * @ORM\Column(name="amount", type="float", nullable=false)
     */
    public $amount;

    /**
     * @var string $imagefile
     *
     * @ORM\Column(name="imagefile", type="string", length=30, nullable=true)
     */
    public $imagefile;

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
     * @var Section $section
     *
     * @ORM\ManyToOne(targetEntity="Section", inversedBy="products")
     * @ORM\JoinColumn(name="section", referencedColumnName="id")
     */
    public $section;

    /**
     * @var Collection $cartProducts
     *
     * @ORM\OneToMany(targetEntity="Cart_Product", mappedBy="product")
     */
    public $cartProducts;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price)
    {
        $this->price = $price;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
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

    /**
     * @param string $imagefile
     */
    public function setImagefile(string $imagefile)
    {
        $this->imagefile = $imagefile;
    }

    /**
     * @return string
     */
    public function getImagefile(): string
    {
        return $this->imagefile;
    }

    /**
     * @param int $section
     */
    public function setSection(int $section)
    {
        $this->section = $this->em->getRepository(Section::class)->find($section);
    }

    /**
     * @return Section
     */
    public function getSection(): Section
    {
        return $this->section;
    }
}