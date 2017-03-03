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
}