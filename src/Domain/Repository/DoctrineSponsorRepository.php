<?php
/**
 * Created by PhpStorm.
 * User: lutfykumar
 * Date: 12/03/17
 * Time: 15:39
 */

namespace Jimmy\fifo\Domain\Repository;

use Doctrine\ORM\EntityRepository;
use Jimmy\fifo\Domain\Contracts\Repository\SponsorRepositoryInterface;
use Jimmy\fifo\Domain\Entity\Sponsor;

class DoctrineSponsorRepository extends EntityRepository implements SponsorRepositoryInterface
{
    /**
     * @param $id
     * @return Sponsor
     */
    public function findById($id)
    {
        return $this->find($id);
    }
}