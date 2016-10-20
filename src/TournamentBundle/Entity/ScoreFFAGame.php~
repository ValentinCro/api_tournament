<?php

namespace TournamentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ScoreFFAGame
 *
 * @ORM\Table(name="scoreFFAGame")
 * @ORM\Entity(repositoryClass="TournamentBundle\Repository\ScoreFFAGameRepository")
 */
class ScoreFFAGame extends Score
{

    /**
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     */
    private $winner;

    /**
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     */
    private $looser;

    /**
     * @var int
     *
     * @ORM\Column(name="looseValue", type="integer")
     */
    private $looseValue;


    /**
     * @var boolean
     *
     * @ORM\Column(name="null", type="boolean")
     */
    private $null;

    /**
     * @var int
     *
     * @ORM\Column(name="$nullValue", type="integer")
     */
    private $nullValue;
    

    /**
     * Set winner
     *
     * @param \UserBundle\Entity\User $winner
     *
     * @return ScoreFFAGame
     */
    public function setWinner(\UserBundle\Entity\User $winner = null)
    {
        $this->winner = $winner;

        return $this;
    }

    /**
     * Get winner
     *
     * @return \UserBundle\Entity\User
     */
    public function getWinner()
    {
        return $this->winner;
    }

    /**
     * Set looser
     *
     * @param \UserBundle\Entity\User $looser
     *
     * @return ScoreFFAGame
     */
    public function setLooser(\UserBundle\Entity\User $looser = null)
    {
        $this->looser = $looser;

        return $this;
    }

    /**
     * Get looser
     *
     * @return \UserBundle\Entity\User
     */
    public function getLooser()
    {
        return $this->looser;
    }

    /**
     * Set looseValue
     *
     * @param integer $looseValue
     *
     * @return ScoreFFAGame
     */
    public function setLooseValue($looseValue)
    {
        $this->looseValue = $looseValue;

        return $this;
    }

    /**
     * Get looseValue
     *
     * @return integer
     */
    public function getLooseValue()
    {
        return $this->looseValue;
    }

    /**
     * Set null
     *
     * @param boolean $null
     *
     * @return ScoreFFAGame
     */
    public function setNull($null)
    {
        $this->null = $null;

        return $this;
    }

    /**
     * Get null
     *
     * @return boolean
     */
    public function getNull()
    {
        return $this->null;
    }

    /**
     * Set nullValue
     *
     * @param integer $nullValue
     *
     * @return ScoreFFAGame
     */
    public function setNullValue($nullValue)
    {
        $this->nullValue = $nullValue;

        return $this;
    }

    /**
     * Get nullValue
     *
     * @return integer
     */
    public function getNullValue()
    {
        return $this->nullValue;
    }
}
