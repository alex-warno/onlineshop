<?php


namespace Shop\Models;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;
use Shop\Lib\Config;

/**
 * Class Section
 * @package Shop\Models
 *
 * @ORM\Entity
 * @ORM\Table(name="section")
 */
class Section extends AbstractModel
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
     * @var string $tag
     *
     * @ORM\Column(name="tag", type="string", length=30, nullable=false)
     */
    public $tag;

    /**
     * @var string $humanName
     *
     * @ORM\Column(name="human_name", type="string", length=30, nullable=false)
     */
    public $humanName;

    /**
     * @var int $parent
     *
     * @ORM\Column(name="parent", type="integer", nullable=false)
     */
    public $parent = 0;

    /**
     * @var string $imagefile
     *
     * @ORM\Column(name="imagefile", type="string", length=30, nullable=false)
     */
    public $imagefile;

    /**
     * @var Collection $products
     *
     * @ORM\OneToMany(targetEntity="Product", mappedBy="section")
     */
    public $products;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param string $tag
     */
    public function setTag(string $tag)
    {
        $this->tag = $tag;
    }

    /**
     * @return string
     */
    public function getTag(): string
    {
        return $this->tag;
    }

    /**
     * @param string $humanName
     */
    public function setHumanName(string $humanName)
    {
        $this->humanName = $humanName;
    }

    /**
     * @return string
     */
    public function getHumanName(): string
    {
        return $this->humanName;
    }

    /**
     * @param int $parent
     */
    public function setParent(int $parent)
    {
        $this->parent = $parent;
    }

    /**
     * @return int
     */
    public function getParent(): int
    {
        return $this->parent;
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
     * @param $limit
     * @param $offset
     * @return array
     */
    public function getProducts($offset = 0, $limit = 10) {
        $childs = $this->getChilds();
        return Product::get(['section'=>array_merge($childs, [$this])], ['name'=>'ASC'], $limit, $offset);
    }

    public function getChilds()
    {
        $childs = $this::get(['parent' => $this->getId()]);
        if (!empty($childs)) {
            foreach ($childs as $child) {
                $childs = array_merge($childs, $child->getChilds());
            }
        }
        return $childs;
    }
}