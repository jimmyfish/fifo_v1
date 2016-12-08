<?php
/**
 * Created by PhpStorm.
 * User: jimmyfish
 * Date: 11/14/16
 * Time: 8:23 AM
 */

namespace Jimmy\fifo\Domain\Entity;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class User
 * @package Jimmy\fifo\Domain\Entity
 * @Entity(repositoryClass="Jimmy\fifo\Domain\Repository\DoctrineUserRepository")
 * @HasLifecycleCallbacks
 * @Table(name="users",uniqueConstraints={@UniqueConstraint(name="users",columns={"email"})})
 */
class User
{
    /**
     * @Id
     * @Column(type="integer", nullable=false)
     * @var int
     * @GeneratedValue
     */
    private $id;

    /**
     * @Column(length=255, nullable=false, type="string")
     * @var string
     */
    private $email;

    /**
     * @Column(length=255, nullable=false, type="string")
     * @var string
     */
    private $password;

    /**
     * @Column(length=255, nullable=true, type="string", name="first_name")
     * @var string
     */
    private $firstName;

    /**
     * @Column(length=255, nullable=true, type="string", name="last_name")
     * @var string
     */
    private $lastName;

    /**
     * @Column(length=255, nullable=true, type="string", name="phone")
     * @var string
     */
    private $phone;

    /**
     * @Column(length=255, nullable=true, type="string", name="fb_link")
     * @var string
     */
    private $fbLink;

    /**
     * @Column(length=255, nullable=true, type="string", name="pin_bbm")
     * @var string
     */
    private $pinBBM;

    /**
     * @Column(length=65535, nullable=true, type="text", name="address")
     * @var string
     */
    private $address;

    /**
     * @Column(length=11, nullable=false, type="integer")
     * @var int
     */
    private $role;

    /**
     * @Column(type="integer", length=2, nullable=false, name="validate_state")
     * @var int
     */
    private $validateState;

    /**
     * @Column(type="string", length=255, nullable=true, name="secret_token")
     * @var string
     */
    private $secretToken;

    /**
     * @Column(type="text", length=65535, nullable=true)
     * @var string
     */
    private $picture;

    /**
     * @Column(type="integer", length=2, nullable=false)
     * @var int
     */
    private $status;

    /**
     * @Column(type="datetime", nullable=false, name="created_at")
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @Column(type="datetime", nullable=true, name="updated_at")
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @param $email
     * @param $password
     * @param $firstName
     * @param $lastName
     * @return User
     */
    public static function createUser($email, $password, $firstName, $lastName)
    {
        $user = new User();

        $user->setPassword($password);
        $user->setEmail($email);
        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $user->setRole(1);
        $user->setValidateState(0);
        $user->setSecretToken(sha1($email));
        $user->setCreatedAt(new \DateTime());
        $user->setStatus(0);

        return $user;
    }

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
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = md5($password);
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return int
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param int $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * @return int
     */
    public function getValidateState()
    {
        return $this->validateState;
    }

    /**
     * @param int $validateState
     */
    public function setValidateState($validateState)
    {
        $this->validateState = $validateState;
    }

    /**
     * @return string
     */
    public function getSecretToken()
    {
        return $this->secretToken;
    }

    /**
     * @param string $secretToken
     */
    public function setSecretToken($secretToken)
    {
        $this->secretToken = $secretToken;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @PrePersist
     * @return void
     */
    public function timestampableCreatedEvent()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * @PrePersist
     * @return void
     */
    public function timestampableUpdateEvent()
    {
        $this->updatedAt = new \DateTime();
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getFbLink()
    {
        return $this->fbLink;
    }

    /**
     * @param string $fbLink
     */
    public function setFbLink($fbLink)
    {
        $this->fbLink = $fbLink;
    }

    /**
     * @return string
     */
    public function getPinBBM()
    {
        return $this->pinBBM;
    }

    /**
     * @param string $pinBBM
     */
    public function setPinBBM($pinBBM)
    {
        $this->pinBBM = $pinBBM;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * @param $picture
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }
}