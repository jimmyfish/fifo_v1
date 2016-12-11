<?php
/**
 * Created by PhpStorm.
 * User: jimmyfish
 * Date: 11/14/16
 * Time: 6:54 PM
 */

namespace Jimmy\fifo\Domain\Contracts\Repository;

use Jimmy\fifo\Domain\Entity\User;

interface UserRepositoryInterface
{
    /**
     * @param $id
     * @return User
     */
    public function findById($id);

    /**
     * @param $email
     * @return User
     */
    public function findByEmail($email);

    /**
     * @param $role
     * @return User
     */
    public function findByRole($role);

    /**
     * @param $secretToken
     * @return User
     */
    public function findByToken($secretToken);
}