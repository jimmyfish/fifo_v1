<?php
/**
 * Created by PhpStorm.
 * User: lutfykumar
 * Date: 02/03/17
 * Time: 17:25
 */

namespace Jimmy\fifo\Domain\Repository;

use Doctrine\ORM\EntityRepository;
use Jimmy\fifo\Domain\Contracts\Repository\MemberRepositoryInterface;
use Jimmy\fifo\Domain\Entity\Member;
class DoctrineMemberRepository extends EntityRepository implements MemberRepositoryInterface
{
    /**
     * @param $id
     * @return Member
     */
    public function findById($id)
    {
        return $this->find($id);
    }
}