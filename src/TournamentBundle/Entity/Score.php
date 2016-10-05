<?php

namespace TournamentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Score
 *
 * @ORM\Table(name="score")
 * @ORM\Entity(repositoryClass="TournamentBundle\Repository\ScoreRepository")
 */
class Score
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
     *
     * @ORM\OneToOne(targetEntity="UserBundle\Entity\User")
     */
    private $player;

    /**
     * @ORM\OneToOne(targetEntity="TournamentBundle\Entity\Team")
     */
    private $team;

    /**
     * @var int
     *
     * @ORM\Column(name="value", type="integer")
     */
    private $value;

    /**
     * @var int
     *
     * @ORM\Column(name="turn", type="integer")
     */
    private $turn;

    /**
     * @var int
     * @ORM\ManyToOne(targetEntity="TournamentBundle\Entity\Tournament", inversedBy="scores")
     */
    private $tournamentIn;

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
     * Set value
     *
     * @param integer $value
     *
     * @return Score
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set tournamentIn
     *
     * @param \TournamentBundle\Entity\Tournament $tournamentIn
     *
     * @return Score
     */
    public function setTournamentIn(\TournamentBundle\Entity\Tournament $tournamentIn = null)
    {
        $this->tournamentIn = $tournamentIn;

        return $this;
    }

    /**
     * Get tournamentIn
     *
     * @return \TournamentBundle\Entity\Tournament
     */
    public function getTournamentIn()
    {
        return $this->tournamentIn;
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

}
