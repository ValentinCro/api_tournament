<?php

namespace TournamentBundle\Dto;

use JMS\Serializer\Annotation\Type;
use TournamentBundle\TournamentBundle;
use UserBundle\Entity\User;

class TournamentCreate
{
    /**
     * @var string
     * @Type("string")
     */
    private $name;

    /**
     * @var integer
     * @Type("integer")
     */
    private $creatorId;

    /**
     * @var boolean
     * @Type("boolean")
     */
    private $private;

    /**
     * @var boolean
     * @Type("boolean")
     */
    private $inTeam;

    /**
     * @var string
     * @Type("string")
     */
    private $password;

    /**
     * Set name
     *
     * @param string $name
     *
     * @return TournamentCreate
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return integer
     */
    public function getCreatorId()
    {
        return $this->creatorId;
    }

    /**
     * @param integer $creator
     * @return TournamentCreate
     */
    public function setCreatorId($creatorId)
    {
        $this->creatorId = $creatorId;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isPrivate()
    {
        return $this->private;
    }

    /**
     * @param boolean $private
     * @return TournamentCreate
     */
    public function setPrivate($private)
    {
        $this->private = $private;
        return $this;
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
     * @return TournamentCreate
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isInTeam()
    {
        return $this->inTeam;
    }

    /**
     * @param boolean $inTeam
     * @return TournamentCreate
     */
    public function setInTeam($inTeam)
    {
        $this->inTeam = $inTeam;
        return $this;
    }

}

