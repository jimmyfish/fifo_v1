<?php
/**
 * Created by PhpStorm.
 * User: jowy
 * Date: 16/02/17
 * Time: 22:00
 */

namespace Jimmy\fifo\Domain\Entity;

/**
 * Class Footer
 * @package Jimmy\fifo\Domain\Entity
 * @Entity(repositoryClass="Jimmy\fifo\Domain\Repository\DoctrineFooterRepository")
 * @HasLifecycleCallbacks
 * @Table(name="footer")
 */
class Footer
{

    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer", nullable=false)
     * @var int
     */
    private $id;

    /**
     * @Column(type="string", nullable=true, length=255, name="donasi_umum")
     * @var string
     */
    private $donasiUmum;

    /**
     * @Column(type="text", nullable=true, length=65355, name="didukung_oleh")
     * @var string
     */
    private $didukungOleh;

    /**
     * @Column(type="string", nullable=true, length=255, name="facebook")
     * @var string
     */
    private $facebook;

    /**
     * @Column(type="string", nullable=true, length=255, name="instagram")
     * @var string
     */
    private $instagram;

    /**
     * @Column(type="string", nullable=true, length=255, name="google_plus")
     * @var string
     */
    private $googlePlus;

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

    public static function init()
    {
        $data = new Footer();

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
    public function getDonasiUmum()
    {
        return $this->donasiUmum;
    }

    /**
     * @param string $donasiUmum
     */
    public function setDonasiUmum($donasiUmum)
    {
        $this->donasiUmum = $donasiUmum;
    }

    /**
     * @return string
     */
    public function getDidukungOleh()
    {
        return $this->didukungOleh;
    }

    /**
     * @param string $didukungOleh
     */
    public function setDidukungOleh($didukungOleh)
    {
        $this->didukungOleh = $didukungOleh;
    }

    /**
     * @return string
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * @param string $facebook
     */
    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;
    }

    /**
     * @return string
     */
    public function getInstagram()
    {
        return $this->instagram;
    }

    /**
     * @param string $instagram
     */
    public function setInstagram($instagram)
    {
        $this->instagram = $instagram;
    }

    /**
     * @return string
     */
    public function getGooglePlus()
    {
        return $this->googlePlus;
    }

    /**
     * @param string $googlePlus
     */
    public function setGooglePlus($googlePlus)
    {
        $this->googlePlus = $googlePlus;
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