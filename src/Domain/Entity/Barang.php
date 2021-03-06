<?php
/**
 * Created by PhpStorm.
 * User: jowy
 * Date: 06/12/16
 * Time: 13:28
 */

namespace Jimmy\fifo\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Barang
 * @package Jimmy\fifo\Domain\Entity
 * @Entity(repositoryClass="Jimmy\fifo\Domain\Repository\DoctrineBarangRepository")
 * @HasLifecycleCallbacks
 * @Table(name="barang")
 */
class Barang
{
    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer", nullable=false)
     * @var int
     */
    private $id;

    /**
     * @ManyToOne(targetEntity="Jimmy\fifo\Domain\Entity\User", inversedBy="barang")
     * @JoinColumn(name="founder", referencedColumnName="id")
     * @var User
     */
    private $founder;

    /**
     * @Column(type="string", nullable=true, length=255, name="founder_number")
     * @var string
     */
    private $founderNumber;

    /**
     * @Column(type="string", nullable=false, length=255, name="founder_email")
     * @var string
     */
    private $founderEmail;

    /**
     * @Column(type="string", nullable=true, length=255, name="founder_facebook")
     * @var string
     */
    private $founderFacebook;

    /**
     * @Column(type="string", nullable=true, length=255, name="founder_pin")
     * @var string
     */
    private $founderPin;

    /**
     * @Column(type="text", nullable=true, length=65535, name="founder_address")
     * @var string
     */
    private $founderAddress;

    /**
     * @Column(type="string", nullable=true, length=255)
     * @var string
     */
    private $title;

    /**
     * @Column(type="text", nullable=false, length=65535)
     * @var string
     */
    private $description;

    /**
     * @ManyToOne(targetEntity="Jimmy\fifo\Domain\Entity\Category")
     * @JoinColumn(name="category_id", referencedColumnName="id")
     * @var int
     */
    private $categoryId;

    /**
     * @Column(type="integer", nullable=false, length=10)
     * @var int
     */
    private $views;
    
    /**
    * @Column(type="integer", nullable=true, length=2)
    * @var int
    */
    private $type;

    /**
     * @Column(type="datetime", nullable=false, name="created_at")
     * @var \DateTime
     */
    private $createdAt;
    
    public function __construct()
    {
        $this->founder = new ArrayCollection();
    }

    public static function create(User $founder, $founderNumber, $founderEmail, $founderAddress, $description, $title, Category $categoryId, $type)
    {
        // return var_dump($categoryId);
        $info = new Barang();
        $info->setTitle($title);
        $info->setFounder($founder);
        $info->setFounderNumber($founderNumber);
        $info->setFounderEmail($founderEmail);
        $info->setFounderAddress($founderAddress);
        $info->setDescription($description);
        $info->setCategoryId($categoryId);
        $info->setCreatedAt(new \DateTime());
        $info->setViews(0);
        $info->setType($type);

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
    public function getFounder()
    {
        return $this->founder;
    }

    /**
     * @param User|string $founder
     */
    public function setFounder(User $founder)
    {
        $this->founder = $founder;
    }

    /**
     * @return string
     */
    public function getFounderNumber()
    {
        return $this->founderNumber;
    }

    /**
     * @param string $founderNumber
     */
    public function setFounderNumber($founderNumber)
    {
        $this->founderNumber = $founderNumber;
    }

    /**
     * @return string
     */
    public function getFounderEmail()
    {
        return $this->founderEmail;
    }

    /**
     * @param string $founderEmail
     */
    public function setFounderEmail($founderEmail)
    {
        $this->founderEmail = $founderEmail;
    }

    /**
     * @return string
     */
    public function getFounderFacebook()
    {
        return $this->founderFacebook;
    }

    /**
     * @param string $founderFacebook
     */
    public function setFounderFacebook($founderFacebook)
    {
        $this->founderFacebook = $founderFacebook;
    }

    /**
     * @return string
     */
    public function getFounderPin()
    {
        return $this->founderPin;
    }

    /**
     * @param string $founderPin
     */
    public function setFounderPin($founderPin)
    {
        $this->founderPin = $founderPin;
    }

    /**
     * @return string
     */
    public function getFounderAddress()
    {
        return $this->founderAddress;
    }

    /**
     * @param string $founderAddress
     */
    public function setFounderAddress($founderAddress)
    {
        $this->founderAddress = $founderAddress;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return int
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * @param int $views
     */
    public function setViews($views)
    {
        $this->views = $views;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return int
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * @param int $categoryId
     */
    public function setCategoryId(Category $categoryId)
    {
        $this->categoryId = $categoryId;
    }
    
    /**
    * @return int
    */
    public function getType()
    {
        return $this->type;
    }
    
    /**
    * @param int $type
    */
    public function setType($type)
    {
        $this->type = $type;
    }



}