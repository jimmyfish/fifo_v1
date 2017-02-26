<?php
/**
 * Created by PhpStorm.
 * User: jowy
 * Date: 26/02/17
 * Time: 16:14
 */

namespace Jimmy\fifo\Domain\Contracts\Repository;


use Jimmy\fifo\Domain\Entity\Faq;

interface FaqRepositoryInterface
{
    /**
     * @param $id
     * @return Faq
     */
    public function findById($id);
}