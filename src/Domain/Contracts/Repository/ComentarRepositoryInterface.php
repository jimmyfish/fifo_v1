<?php
/**
 * Created by PhpStorm.
 * User: jowy
 * Date: 06/12/16
 * Time: 14:25
 */

namespace Jimmy\fifo\Domain\Contracts\Repository;


use Jimmy\fifo\Domain\Entity\Comentar;

interface ComentarRepositoryInterface
{
    /**
     * @param $id
     * @return Comentar
     */
    public function findById($id);

    /**
     * @param $idBarang
     * @return Comentar
     */
    public function findByIdBarang($idBarang);

    /**
     * @param $idUser
     * @return Comentar
     */
    public function findByIdUser($idUser);
}