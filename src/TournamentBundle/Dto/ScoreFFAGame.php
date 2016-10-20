<?php

namespace TournamentBundle\Dto;

use JMS\Serializer\Annotation\Type;
use UserBundle\Dto\User;

class ScoreFFAGame extends Score
{

    /**
     * @var User
     * @Type("UserBundle\Dto\User")
     */
    private $winner;

    /**
     * @var User
     * @Type("UserBundle\Dto\User")
     */
    private $looser;

    /**
     * @var int
     * @type("integer")
     */
    private $looseValue;


    /**
     * @var boolean
     * @type("boolean")
     */
    private $null;

    /**
     * @var int
     * @type("integer")
     */
    private $nullValue;

    public function entityToDto(\TournamentBundle\Entity\ScoreFFAGame $score) {
        $this->setId($score->getId());
        $this->setValue($score->getValue());
        $this->setDescription($score->getDescription());
        $winner = new \UserBundle\Dto\User();
        $winner->entityToDto($score->getWinner());
        $this->setWinner($winner);
        $looser = new \UserBundle\Dto\User();
        $looser->entityToDto($score->getLooser());
        $this->setLooser($winner);
        $this->setLooseValue($score->getLooseValue());
        $this->setNull($score->getNull());
        $this->setNullValue($score->getNullValue());
    }

    /**
     * @return User
     */
    public function getWinner()
    {
        return $this->winner;
    }

    /**
     * @param User $winner
     * @return ScoreFFAGame
     */
    public function setWinner($winner)
    {
        $this->winner = $winner;
        return $this;
    }

    /**
     * @return User
     */
    public function getLooser()
    {
        return $this->looser;
    }

    /**
     * @param User $looser
     * @return ScoreFFAGame
     */
    public function setLooser($looser)
    {
        $this->looser = $looser;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLooseValue()
    {
        return $this->looseValue;
    }

    /**
     * @param mixed $looseValue
     * @return ScoreFFAGame
     */
    public function setLooseValue($looseValue)
    {
        $this->looseValue = $looseValue;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNull()
    {
        return $this->null;
    }

    /**
     * @param mixed $null
     * @return ScoreFFAGame
     */
    public function setNull($null)
    {
        $this->null = $null;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNullValue()
    {
        return $this->nullValue;
    }

    /**
     * @param mixed $nullValue
     * @return ScoreFFAGame
     */
    public function setNullValue($nullValue)
    {
        $this->nullValue = $nullValue;
        return $this;
    }

}
