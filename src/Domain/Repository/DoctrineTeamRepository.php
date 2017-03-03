<?php
/**
 * Created by PhpStorm.
 * User: lutfykumar
 * Date: 02/03/17
 * Time: 17:39
 */

namespace Jimmy\fifo\Domain\Repository;

use Doctrine\ORM\EntityRepository;
use Jimmy\fifo\Domain\Contracts\Repository\TeamRepositoryInterface;
use Jimmy\fifo\Domain\Entity\Team;

class DoctrineTeamRepository extends EntityRepository implements TeamRepositoryInterface
{
    /**
     * @param $id
     * @return Team
     */
    public function findById($id)
    {
        return $this->find($id);
    }
}
