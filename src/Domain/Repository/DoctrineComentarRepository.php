<?php
/**
 * Created by PhpStorm.
 * User: jowy
 * Date: 06/12/16
 * Time: 14:26
 */

namespace Jimmy\fifo\Domain\Repository;


use Doctrine\ORM\EntityManager;
use Jimmy\fifo\Domain\Contracts\Repository\ComentarRepositoryInterface;
use Jimmy\fifo\Domain\Entity\Comentar;

class DoctrineComentarRepository extends EntityManager implements ComentarRepositoryInterface
{

    /**
     * @param $id
     * @return Comentar
     */
    public function findById($id)
    {
        // TODO: Implement findById() method.
    }

    /**
     * @param $idBarang
     * @return Comentar
     */
    public function findByIdBarang($idBarang)
    {
        // TODO: Implement findByIdBarang() method.
    }

    /**
     * @param $idUser
     * @return Comentar
     */
    public function findByIdUser($idUser)
    {
        // TODO: Implement findByIdUser() method.
    }
}