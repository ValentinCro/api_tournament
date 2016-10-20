<?php

namespace TournamentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ScoreFFA
 *
 * @ORM\Table(name="scoreFFA")
 * @ORM\Entity
 */
class ScoreFFA extends Score
{

    /**
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     */
    private $player;

    /**
     * @ORM\ManyToOne(targetEntity="TournamentBundle\Entity\Team")
     */
    private $team;

    /**
     * @var int
     *
     * @ORM\Column(name="position", type="integer")
     */
    private $position;

    /**
     * @var int
     *
     * @ORM\Column(name="turn", type="integer")
     */
    private $turn;

    /**
     * Set player
     *
     * @param \stdClass $player
     *
     * @return Score
     */
    public function setPlayer($player)
    {
        $this->player = $player;

        return $this;
    }

    /**
     * Get player
     *
     * @return \stdClass
     */
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * Set team
     *
     * @param \stdClass $team
     *
     * @return Score
     */
    public function setTeam($team)
    {
        $this->team = $team;

        return $this;
    }

    /**
     * Get team
     *
     * @return \stdClass
     */
    public function getTeam()
    {
        return $this->team;
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
     * @return Score
     */
    public function setTurn($turn)
    {
        $this->turn = $turn;
        return $this;
    }


    /**
     * Set position
     *
     * @param integer $position
     *
     * @return Score
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
    }
}
