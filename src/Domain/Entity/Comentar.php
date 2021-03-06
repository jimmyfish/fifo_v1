<?php
/**
 * Created by PhpStorm.
 * User: jowy
 * Date: 06/12/16
 * Time: 14:21
 */

namespace Jimmy\fifo\Domain\Entity;

/**
 * Class Comentar
 * @package Jimmy\fifo\Domain\Entity
 * @Entity(repositoryClass="Jimmy\fifo\Domain\Repository\DoctrineComentarRepository")
 * @Table(name="comentar")
 * @HasLifecycleCallbacks
 */
class Comentar
{
    /**
     * @Id
     * @Column(type="integer", nullable=false)
     * @GeneratedValue
     * @var int
     */
    private $id;

    /**
     * @ManyToOne(targetEntity="Jimmy\fifo\Domain\Entity\Barang")
     * @JoinColumn(name="id_barang", referencedColumnName="id")
     * @var int
     */
    private $idBarang;

    /**
     * @ManyToOne(targetEntity="Jimmy\fifo\Domain\Entity\User")
     * @JoinColumn(name="id_user", referencedColumnName="id")
     * @var int
     */
    private $idUser;

    /**
     * @Column(type="text", length=65535, nullable=false)
     * @var string
     */
    private $content;

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
    public function setIdBarang(Barang $idBarang)
    {
        $this->idBarang = $idBarang;
    }

    /**
     * @return int
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @param int $idUser
     */
    public function setIdUser(User $idUser)
    {
        $this->idUser = $idUser;
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
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }


}