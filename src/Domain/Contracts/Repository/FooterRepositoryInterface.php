<?php
/**
 * Created by PhpStorm.
 * User: jowy
 * Date: 16/02/17
 * Time: 22:10
 */

namespace Jimmy\fifo\Domain\Contracts\Repository;


use Jimmy\fifo\Domain\Entity\Footer;

interface FooterRepositoryInterface
{
    /**
     * @param $id
     * @return Footer
     */
    public function findById($id);
}