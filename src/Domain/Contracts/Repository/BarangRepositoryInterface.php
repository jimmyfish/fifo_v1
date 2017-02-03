<?php
/**
 * Created by PhpStorm.
 * User: jowy
 * Date: 06/12/16
 * Time: 13:45
 */

namespace Jimmy\fifo\Domain\Contracts\Repository;


use Jimmy\fifo\Domain\Entity\Barang;

interface BarangRepositoryInterface
{
    /**
     * @param $id
     * @return Barang
     */
    public function findById($id);

    /**
     * @param $title
     * @return Barang
     */
    public function findByTitle($title);

    /**
     * @param $founder
     * @return Barang
     */
    public function findByFounder($founder);

    /**
     * @param $founderEmail
     * @return Barang
     */
    public function findByEmail($founderEmail);

    /**
     * @param $description
     * @return Barang
     */
    public function findByDescription($description);

    public function findByAllDescending();
    
    public function findByType($type);
}