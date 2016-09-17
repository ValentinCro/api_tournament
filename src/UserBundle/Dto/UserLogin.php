<?php

namespace UserBundle\Dto;

use JMS\Serializer\Annotation\Type;

class UserLogin
{
    /**
     * @var string
     * @Type("string")
     */
    private $userName;

    /**
     * @var string
     * @Type("string")
     */
    private $userPassword;

    /**
     * Set userName
     *
     * @param string $userName
     *
     * @return UserLogin
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
     * @return UserLogin
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
}

