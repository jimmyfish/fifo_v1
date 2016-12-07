<?php
/**
 * Created by PhpStorm.
 * User: jowy
 * Date: 06/12/16
 * Time: 14:17
 */

namespace Jimmy\fifo\Domain\Entity;

/**
 * Class Photo
 * @package Jimmy\fifo\Domain\Entity
 * @Entity(repositoryClass="Jimmy\fifo\Domain\Repository\DoctrinePhotoRepository")
 * @Table(name="photo")
 * @HasLifecycleCallbacks
 */
class Photo
{
    /**
     * @Id
     * @Column(type="integer", nullable=false)
     * @var int
     * @GeneratedValue
     */
    private $id;

    /**
     * @Column(type="integer", nullable=false, name="id_barang")
     * @var int
     */
    private $idBarang;

    /**
     * @Column(type="string", nullable=false, length=255)
     * @var string
     */
    private $filename;

    /**
     * @Column(type="datetime", nullable=false, name="created_at")
     * @var \DateTime
     */
    private $createdAt;

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
     * @return int
     */
    public function getIdBarang()
    {
        return $this->idBarang;
    }

    /**
     * @param int $idBarang
     */
    public function setIdBarang($idBarang)
    {
        $this->idBarang = $idBarang;
    }

    /**
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @param string $filename
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
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



}