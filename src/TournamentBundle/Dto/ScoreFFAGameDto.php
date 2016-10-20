<?php

namespace TournamentBundle\Dto;

use JMS\Serializer\Annotation\Type;
use TournamentBundle\TournamentBundle;
use TournamentBundle\Entity\Rule;

class ScoreFFAGameDto
{
    /**
     * @var string
     * @Type("string")
     */
    private $winner;

    /**
     * @var string
     * @Type("string")
     */
    private $looser;

    /**
     * @var boolean
     * @Type("boolean")
     */
    private $null;

    /**
     * @var string
     * @type("string")
     */
    private $description;

    /**
     * @var integer
     * @Type("integer")
     */
    private $tournamentId;

    /**
     * @return string
     */
    public function getWinner()
    {
        return $this->winner;
    }

    /**
     * @param string $winner
     * @return ScoreDto
     */
    public function setWinner($winner)
    {
        $this->winner = $winner;
        return $this;
    }

    /**
     * @return string
     */
    public function getLooser()
    {
        return $this->looser;
    }

    /**
     * @param string $looser
     * @return ScoreDto
     */
    public function setLooser($looser)
    {
        $this->looser = $looser;
        return $this;
    }

    /**
     * @return int
     */
    public function getTournamentId()
    {
        return $this->tournamentId;
    }

    /**
     * @param int $tournamentId
     * @return ScoreDto
     */
    public function setTournamentId($tournamentId)
    {
        $this->tournamentId = $tournamentId;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isNull()
    {
        return $this->null;
    }

    /**
     * @param boolean $null
     * @return ScoreFFAGameDto
     */
    public function setNull($null)
    {
        $this->null = $null;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return ScoreFFAGameDto
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

}

