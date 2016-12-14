<?php
/**
 * Created by PhpStorm.
 * User: jowy
 * Date: 14/12/16
 * Time: 2:20
 */

namespace Jimmy\fifo\Domain\Entity;

/**
 * Class Category
 * @package Jimmy\fifo\Domain\Entity
 * @Entity(repositoryClass="Jimmy\fifo\Domain\Repository\DoctrineCategoryRepository")
 * @HasLifecycleCallbacks
 * @Table(name="category")
 */
class Category
{

    /**
     * @Id
     * @Column(type="integer", nullable=false)
     * @var int
     * @GeneratedValue
     */
    private $id;

    /**
     * @Column(type="string", nullable=false)
     * @var string
     */
    private $name;

    public static function create($name)
    {
        $info = new Category();

        $info->setName($name);

        return $info;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }


}