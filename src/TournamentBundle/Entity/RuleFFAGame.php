<?php

namespace TournamentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rule
 *
 * @ORM\Table(name="ruleFFAGame")
 * @ORM\Entity(repositoryClass="TournamentBundle\Repository\RuleFFARepository")
 */
class RuleFFAGame extends Rule
{
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
}
