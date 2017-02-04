<?php
/**
 * Created by PhpStorm.
 * User: jowy
 * Date: 05/02/17
 * Time: 0:04
 */

namespace Jimmy\fifo\Domain\Repository;

use Doctrine\ORM\EntityRepository;
use Jimmy\fifo\Domain\Contracts\Repository\VideoRepositoryInterface;
use Jimmy\fifo\Domain\Entity\Video;

class DoctrineVideoRepository extends EntityRepository implements VideoRepositoryInterface
{

    /**
     * @param $id
     * @return Video
     */
    public function findById($id)
    {
        return $this->find($id);
    }
}