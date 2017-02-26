<?php
/**
 * Created by PhpStorm.
 * User: jowy
 * Date: 26/02/17
 * Time: 16:06
 */

namespace Jimmy\fifo\Domain\Entity;

/**
 * Class Faq
 * @package Jimmy\fifo\Domain\Entity
 * @Entity(repositoryClass="Jimmy\fifo\Domain\Repository\DoctrineFaqRepository")
 * @HasLifecycleCallbacks
 * @Table(name="faq")
 */
class Faq
{
    /**
     * @Id
     * @GeneratedValue
     * @Column(nullable=false, type="integer")
     * @var int
     */
    private $id;

    /**
     * @Column(length=65535, type="text", nullable=false)
     * @var string
     */
    private $question;

    /**
     * @Column(type="text", length=65535, nullable=false)
     * @var string
     */
    private $answer;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * @param string $question
     */
    public function setQuestion($question)
    {
        $this->question = $question;
    }

    /**
     * @return string
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * @param string $answer
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;
    }


}