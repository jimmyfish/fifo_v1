<?php
/**
 * Created by PhpStorm.
 * User: lutfykumar
 * Date: 02/03/17
 * Time: 17:22
 */

namespace Jimmy\fifo\Domain\Contracts\Repository;

use Jimmy\fifo\Domain\Entity\Member;
interface MemberRepositoryInterface
{
    /**
     * @param $id
     * @return Member
     */
    public function findById($id);

}