<?php
/**
 * Created by PhpStorm.
 * User: jowy
 * Date: 06/12/16
 * Time: 13:46
 */

namespace Jimmy\fifo\Domain\Repository;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Jimmy\fifo\Domain\Contracts\Repository\BarangRepositoryInterface;
use Jimmy\fifo\Domain\Entity\Barang;

class DoctrineBarangRepository extends EntityRepository implements BarangRepositoryInterface
{

    /**
     * @param $id
     * @return Barang
     */
    public function findById($id)
    {
        return $this->find($id);
    }

    /**
     * @param $title
     * @return Barang
     */
    public function findByTitle($title)
    {
        return $this->findBy(['title' => $title]);
    }

    /**
     * @param $founder
     * @return Barang
     */
    public function findByFounder($founder)
    {
        return $this->findBy(['founder' => $founder]);
    }

    /**
     * @param $founderEmail
     * @return Barang
     */
    public function findByEmail($founderEmail)
    {
        return $this->findOneBy(['founderEmail' => $founderEmail]);
    }

    /**
     * @param $description
     * @return Barang
     */
    public function findByDescription($description)
    {
        // TODO: Implement findByDescription() method.
    }
}