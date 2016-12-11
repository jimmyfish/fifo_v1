<?php
/**
 * Created by PhpStorm.
 * User: jowy
 * Date: 06/12/16
 * Time: 14:23
 */

namespace Jimmy\fifo\Domain\Contracts\Repository;


use Jimmy\fifo\Domain\Entity\Photo;

interface PhotoRepositoryInterface
{
    /**
     * @param $id
     * @return Photo
     */
    public function findById($id);

    /**
     * @param $idBarang
     * @return Photo
     */
    public function findByIdBarang($idBarang);

    /**
     * @param $filename
     * @return Photo
     */
    public function findByFilename($filename);
}