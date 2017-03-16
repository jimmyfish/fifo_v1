<?php
/**
 * Created by PhpStorm.
 * User: lutfykumar
 * Date: 12/03/17
 * Time: 15:38
 */

namespace Jimmy\fifo\Domain\Contracts\Repository;

use Jimmy\fifo\Domain\Entity\Sponsor;
interface SponsorRepositoryInterface
{
    /**
     * @param $id
     * @return Sponsor
     */
    public function findById($id);
}