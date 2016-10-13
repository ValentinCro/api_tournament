<?php

namespace TournamentBundle\Dto;

use JMS\Serializer\Annotation\Type;
use TournamentBundle\TournamentBundle;
use TournamentBundle\Entity\Rule;

class TabScoreDto
{
    /**
     * @var array
     * @Type("array<TournamentBundle\Dto\ScoreDto>")
     */
    private $scores;

    /**
     * @var integer
     * @Type("integer")
     */
    private $tournamentId;

    /**
     * @var integer
     * @Type("integer")
     */
    private $turn;

    /**
     * @return array
     */
    public function getScores()
    {
        return $this->scores;
    }

    /**
     * @param array $scores
     * @return ScoreDto
     */
    public function setScores($scores)
    {
        $this->scores = $scores;
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
     * @return int
     */
    public function getTurn()
    {
        return $this->turn;
    }

    /**
     * @param int $turn
     * @return ScoreDto
     */
    public function setTurn($turn)
    {
        $this->turn = $turn;
        return $this;
    }

}

