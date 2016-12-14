<?php
/**
 * Created by PhpStorm.
 * User: jowy
 * Date: 06/12/16
 * Time: 14:26
 */

namespace Jimmy\fifo\Domain\Repository;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Jimmy\fifo\Domain\Contracts\Repository\PhotoRepositoryInterface;
use Jimmy\fifo\Domain\Entity\Photo;

class DoctrinePhotoRepository extends EntityRepository implements PhotoRepositoryInterface
{

    /**
     * @param $id
     * @return Photo
     */
    public function findById($id)
    {
        // TODO: Implement findById() method.
    }

    /**
     * @param $idBarang
     * @return Photo
     */
    public function findByIdBarang($idBarang)
    {
        return $this->findBy(['idBarang' => $idBarang]);
    }

    /**
     * @param $filename
     * @return Photo
     */
    public function findByFilename($filename)
    {
        // TODO: Implement findByFilename() method.
    }
}