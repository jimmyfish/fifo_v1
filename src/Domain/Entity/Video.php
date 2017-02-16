<?php
/**
 * Created by PhpStorm.
 * User: jowy
 * Date: 04/02/17
 * Time: 23:49
 */

namespace Jimmy\fifo\Domain\Entity;

/**
 * Class Video
 * @package Jimmy\fifo\Domain\Entity
 * @Entity(repositoryClass="Jimmy\fifo\Domain\Repository\DoctrineVideoRepository")
 * @HasLifecycleCallbacks
 * @Table(name="video")
 */
class Video
{
    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer", nullable=false)
     * @var int
     */
    private $id;

    /**
     * @Column(type="string", nullable=false, length=255)
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
     * @Column(type="string", nullable=false, length=255, name="link_video")
     * @var string
     */
    private $linkVideo;

    /**
     * @Column(type="text", length=65535, nullable=true)
     * @var string
     */
    private $description;

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
     * @param $title
     * @param $subtitle
     * @param $linkVideo
     * @param $description
     * @return Video
     */
    public static function create($title, User $user, $linkVideo, $description)
    {
        $data = new Video();

        $data->setTitle($title);
        $data->setUserId($user);
        $data->setLinkVideo($linkVideo);
        $data->setDescription($description);
        $data->setCreatedAt(new \DateTime());

        return $data;
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
     * @param string $subtitle
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function getLinkVideo()
    {
        return $this->linkVideo;
    }

    /**
     * @param string $linkVideo
     */
    public function setLinkVideo($linkVideo)
    {
        $this->linkVideo = $linkVideo;
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