<?php
/**
 * Created by PhpStorm.
 * User: jowy
 * Date: 05/02/17
 * Time: 0:00
 */

namespace Jimmy\fifo\Domain\Contracts\Repository;


use Jimmy\fifo\Domain\Entity\Video;

interface VideoRepositoryInterface
{
    /**
     * @param $id
     * @return Video
     */
    public function findById($id);
}