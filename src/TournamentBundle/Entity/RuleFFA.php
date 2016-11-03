<?php

namespace TournamentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rule
 *
 * @ORM\Table(name="ruleFFA")
 * @ORM\Entity(repositoryClass="TournamentBundle\Repository\RuleFFARepository")
 */
class RuleFFA
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
     * @var int
     *
     * @ORM\Column(name="position", type="integer")
     */
    private $position;

    /**
     * @ORM\ManyToOne(targetEntity="TournamentBundle\Entity\Rule", inversedBy="rulesFFA")
     */
    private $rule;

    /**
     * @var int
     *
     * @ORM\Column(name="earnedScore", type="integer")
     */
    private $earnedScore;

    /**
     * Set position
     *
     * @param integer $position
     *
     * @return Rule
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set rule
     *
     * @param \TournamentBundle\Entity\Rule $rule
     *
     * @return RuleFFA
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
     * @return RuleFFA
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
