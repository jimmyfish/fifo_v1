<?php
/**
 * Created by PhpStorm.
 * User: lutfykumar
 * Date: 02/03/17
 * Time: 17:37
 */

namespace Jimmy\fifo\Domain\Contracts\Repository;

use Jimmy\fifo\Domain\Entity\Team;

interface TeamRepositoryInterface
{
    /**
     * @param $id
     * @return Team
     */
    public function findById($id);
}