<?php

namespace TournamentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rule
 *
 * @ORM\Table(name="ruleFFAGame")
 * @ORM\Entity(repositoryClass="TournamentBundle\Repository\RuleFFARepository")
 */
class RuleFFAGame
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
     * @var boolean
     *
     * @ORM\Column(name="win", type="boolean")
     */
    private $win;

    /**
     * @var boolean
     *
     * @ORM\Column(name="loose", type="boolean")
     */
    private $loose;

    /**
     * @ORM\ManyToOne(targetEntity="TournamentBundle\Entity\Rule", inversedBy="rulesFFAGame")
     */
    private $rule;

    /**
     * @var int
     *
     * @ORM\Column(name="earnedScore", type="integer")
     */
    private $earnedScore;

    /**
     * Set win
     *
     * @param boolean $win
     *
     * @return RuleFFAGame
     */
    public function setWin($win)
    {
        $this->win = $win;

        return $this;
    }

    /**
     * Get win
     *
     * @return boolean
     */
    public function getWin()
    {
        return $this->win;
    }

    /**
     * Set loose
     *
     * @param boolean $loose
     *
     * @return RuleFFAGame
     */
    public function setLoose($loose)
    {
        $this->loose = $loose;

        return $this;
    }

    /**
     * Get loose
     *
     * @return boolean
     */
    public function getLoose()
    {
        return $this->loose;
    }

    /**
     * Set rule
     *
     * @param \TournamentBundle\Entity\Rule $rule
     *
     * @return RuleFFAGame
     */
    public function setRule(\TournamentBundle\Entity\Rule $rule = null)
    {
        $this->rule = $rule;

        return $this;
    }

    /**
     * Get rule
     *
     * @return \TournamentBundle\Entity\Rule
     */
    public function getRule()
    {
        return $this->rule;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set earnedScore
     *
     * @param integer $earnedScore
     *
     * @return RuleFFAGame
     */
    public function setEarnedScore($earnedScore)
    {
        $this->earnedScore = $earnedScore;

        return $this;
    }

    /**
     * Get earnedScore
     *
     * @return integer
     */
    public function getEarnedScore()
    {
        return $this->earnedScore;
    }
}
