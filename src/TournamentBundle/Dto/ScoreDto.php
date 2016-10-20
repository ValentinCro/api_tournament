<?php

namespace TournamentBundle\Dto;

use JMS\Serializer\Annotation\Type;
use TournamentBundle\TournamentBundle;
use TournamentBundle\Entity\Rule;

class ScoreDto
{
    /**
     * @var integer
     * @Type("integer")
     */
    private $playerId;

    /**
     * @var integer
     * @Type("integer")
     */
    private $teamId;

    /**
     * @var integer
     * @Type("integer")
     */
    private $position;

    /**
     * @var string
     * @Type("string")
     */
    private $description;

    /**
     * @return int
     */
    public function getPlayerId()
    {
        return $this->playerId;
    }

    /**
     * @param int $playerId
     * @return ScoreDto
     */
    public function setPlayerId($playerId)
    {
        $this->playerId = $playerId;
        return $this;
    }

    /**
     * @return int
     */
    public function getTeamId()
    {
        return $this->teamId;
    }

    /**
     * @param int $teamId
     * @return ScoreDto
     */
    public function setTeamId($teamId)
    {
        $this->teamId = $teamId;
        return $this;
    }

    /**
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param int $position
     * @return ScoreDto
     */
    public function setPosition($position)
    {
        $this->position = $position;
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
     * @return ScoreDto
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

}

