<?php
/**
 * Created by PhpStorm.
 * User: lutfykumar
 * Date: 02/03/17
 * Time: 17:29
 */

namespace Jimmy\fifo\Domain\Entity;

/**
 * Class Team
 * @package Jimmy\fifo\Domain\Entity
 * @Entity(repositoryClass="Jimmy\fifo\Domain\Repository\DoctrineTeamRepository")
 * @HasLifecycleCallbacks
 * @Table(name="team")
 */
class Team
{
    /**
     * @Id
     * @GeneratedValue
     * @Column(nullable=false, type="integer")
     * @var int
     */
    Private $id;

    /**
     * @Column(type="string", nullable=true, length=255)
     * @var string
     */
    private $title;

    /**
     * @ManyToOne(targetEntity="Jimmy\fifo\Domain\Entity\User")
     * @JoinColumn(name="user_id", referencedColumnName="id")
     * @var User
     */
    private $userId;


    /**
     * @Column(type="text", nullable=false, length=65535)
     * @var string
     */
    Private $description;

    /**
     * @Column(type="string", length=255, nullable=true)
     * @var string
     */
    Private $images;

    /**
     * @Column(type="datetime", nullable=false, name="created_at")
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @Column(type="datetime", nullable=true, name="updated_at")
     * @var \DateTime
     */
    private $updatedAt;

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
    public function getUserId()
    {
        return $this->userId;
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
     * @return string
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param string $images
     */
    public function setImages($images)
    {
        $this->images = $images;
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
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }
}