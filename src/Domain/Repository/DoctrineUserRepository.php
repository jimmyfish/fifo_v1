<?php
/**
 * Created by PhpStorm.
 * User: jimmyfish
 * Date: 11/14/16
 * Time: 6:56 PM
 */

namespace Jimmy\fifo\Domain\Repository;


use Doctrine\ORM\EntityRepository;
use Jimmy\fifo\Domain\Contracts\Repository\UserRepositoryInterface;
use Jimmy\fifo\Domain\Entity\User;

class DoctrineUserRepository extends EntityRepository implements UserRepositoryInterface
{

    /**
     * @param $id
     * @return User
     */
    public function findById($id)
    {
        return $this->find($id);
    }

    /**
     * @param $email
     * @return User
     */
    public function findByEmail($email)
    {
        return $this->findOneBy(['email' => $email]);
    }

    /**
     * @param $role
     * @return User
     */
    public function findByRole($role)
    {
        return $this->findBy(['role' => $role]);
    }

    /**
     * @param $secretToken
     * @return User
     */
    public function findByToken($secretToken)
    {
        return $this->findOneBy(['secretToken' => $secretToken]);
    }
}