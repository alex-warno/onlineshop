<?php


namespace Shop\Models;


use DateTime;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Shop\Lib\EntityManagerInstance;
use Doctrine\ORM\Mapping as ORM;

class AbstractModel
{
    protected $em;

    /**
     * @var DateTime $created_at
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    public $created_at;

    /**
     * @var DateTime $updated_at
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    public $updated_at;

    public function __construct()
    {
        $this->em = EntityManagerInstance::getInstance();
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->created_at;
    }

    /**
     * @param DateTime $created_at
     */
    public function setCreatedAt(DateTime $created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updated_at;
    }

    /**
     * @param DateTime $updated_at
     */
    public function setUpdatedAt(DateTime $updated_at)
    {
        $this->updated_at = $updated_at;
    }

    public static function create() {
        $model_name = get_called_class();
        $entity = new $model_name();
        $entity->setCreatedAt(new DateTime());
        $entity->setUpdatedAt(new DateTime());
        return $entity;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save() {
        if (!$this->em) {
            $this->em = EntityManagerInstance::getInstance();
        }
        $this->em->persist($this);
        $this->em->flush($this);
    }

    public static function get($params = [], $cartBy = null, $limit=null, $offset=null) {
        $em = EntityManagerInstance::getInstance();
        return $em->getRepository(get_called_class())->findBy($params, $cartBy, $limit, $offset);
    }

    /**
     * @param $request
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function updateFromRequest($request) {
        $vars = get_class_vars(get_called_class());
        foreach ($request as $key => $value) {
            if (key_exists($key, $vars)) {
                $setter_name = 'set'.ucfirst($key);
                $this->$setter_name($value);
            }
        }
        $this->setUpdatedAt(new DateTime());
    }

    public static function getById($id) {
        $em = EntityManagerInstance::getInstance();
        return $em->getRepository(get_called_class())->find($id);
    }

    public function delete() {
        $this->em->remove($this);
        $this->em->flush();
    }
}