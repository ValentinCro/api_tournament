<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\UserRepository")
 */
class User
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="user_name", type="string", length=80)
     */
    private $userName;

    /**
     * @var string
     *
     * @ORM\Column(name="user_password", type="string", length=255)
     */
    private $userPassword;

    /**
     * @var string
     *
     * @ORM\Column(name="user_token", type="string", length=255)
     */
    private $userToken;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="user_date", type="date")
     */
    private $userDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="user_Token_Validity_Date", type="datetime")
     */
    private $userTokenValidityDate;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set userName
     *
     * @param string $userName
     *
     * @return User
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;

        return $this;
    }

    /**
     * Get userName
     *
     * @return string
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * Set userPassword
     *
     * @param string $userPassword
     *
     * @return User
     */
    public function setUserPassword($userPassword)
    {
        $this->userPassword = $userPassword;

        return $this;
    }

    /**
     * Get userPassword
     *
     * @return string
     */
    public function getUserPassword()
    {
        return $this->userPassword;
    }

    /**
     * Set userToken
     *
     * @param string $userToken
     *
     * @return User
     */
    public function setUserToken($userToken)
    {
        $this->userToken = $userToken;

        return $this;
    }

    /**
     * Get userToken
     *
     * @return string
     */
    public function getUserToken()
    {
        return $this->userToken;
    }

    public function setUserTokenValidityDate($userTokenValidityDate) {
        $this->userTokenValidityDate = $userTokenValidityDate;

        return $this;
    }

    public function getUserTokenValidityDate() {
        return $this->userTokenValidityDate;
    }

    /**
     * Set userDate
     *
     * @param \DateTime $userDate
     *
     * @return User
     */
    public function setUserDate($userDate)
    {
        $this->userDate = $userDate;

        return $this;
    }

    /**
     * Get userDate
     *
     * @return \DateTime
     */
    public function getUserDate()
    {
        return $this->userDate;
    }
}

