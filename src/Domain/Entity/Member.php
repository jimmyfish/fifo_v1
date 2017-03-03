<?php
/**
 * Created by PhpStorm.
 * User: lutfykumar
 * Date: 02/03/17
 * Time: 17:18
 */

namespace Jimmy\fifo\Domain\Entity;

/**
 * Class Member
 * @package Jimmy\fifo\Domain\Entity
 * @Entity(repositoryClass="Jimmy\fifo\Domain\Repository\DoctrineMemberRepository")
 * @HasLifecycleCallbacks
 * @Table(name="member")
 */
class Member
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
     * @Column(type="string", nullable=true, length=255)
     * @var string
     */
    private $job;

    /**
     * @Column(type="text", nullable=false, length=65535)
     * @var string
     */
    Private $description;

    /**
     * @Column(length=255, nullable=true, type="string", name="fb_link")
     * @var string
     */
    private $fbLink;

    /**
     * @Column(length=255, nullable=true, type="string", name="ig_link")
     * @var string
     */
    private $igLink;

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
    public function getJob()
    {
        return $this->job;
    }

    /**
     * @param string $job
     */
    public function setJob($job)
    {
        $this->job = $job;
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
    public function getFbLink()
    {
        return $this->fbLink;
    }

    /**
     * @param string $fbLink
     */
    public function setFbLink($fbLink)
    {
        $this->fbLink = $fbLink;
    }

    /**
     * @return string
     */
    public function getIgLink()
    {
        return $this->igLink;
    }

    /**
     * @param string $igLink
     */
    public function setIgLink($igLink)
    {
        $this->igLink = $igLink;
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