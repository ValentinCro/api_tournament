<?php

namespace TournamentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rule
 *
 * @ORM\Table(name="rule")
 * @ORM\Entity
 */
class Rule
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
     * @ORM\OneToOne(targetEntity="TournamentBundle\Entity\Tournament")
     * @ORM\JoinColumn(name="tournament_id", referencedColumnName="id")
     */
    private $tournament;

    /**
     * @ORM\OneToMany(targetEntity="TournamentBundle\Entity\RuleFFA", mappedBy="rule", cascade={"persist"})
     */
    private $rulesFFA;

    /**
     * @ORM\OneToMany(targetEntity="TournamentBundle\Entity\RuleFFAGame", mappedBy="rule", cascade={"persist"})
     */
    private $rulesFFAGame;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->rulesFFA = new \Doctrine\Common\Collections\ArrayCollection();
        $this->rulesFFAGame = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set tournament
     *
     * @param \TournamentBundle\Entity\Tournament $tournament
     *
     * @return Rule
     */
    public function setTournament(\TournamentBundle\Entity\Tournament $tournament = null)
    {
        $this->tournament = $tournament;

        return $this;
    }

    /**
     * Get tournament
     *
     * @return \TournamentBundle\Entity\Tournament
     */
    public function getTournament()
    {
        return $this->tournament;
    }

    /**
     * Add rulesFFA
     *
     * @param \TournamentBundle\Entity\RuleFFA $rulesFFA
     *
     * @return Rule
     */
    public function addRulesFFA(\TournamentBundle\Entity\RuleFFA $rulesFFA)
    {
        $this->rulesFFA[] = $rulesFFA;

        return $this;
    }

    /**
     * Remove rulesFFA
     *
     * @param \TournamentBundle\Entity\RuleFFA $rulesFFA
     */
    public function removeRulesFFA(\TournamentBundle\Entity\RuleFFA $rulesFFA)
    {
        $this->rulesFFA->removeElement($rulesFFA);
    }

    /**
     * Get rulesFFA
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRulesFFA()
    {
        return $this->rulesFFA;
    }

    /**
     * Add rulesFFAGame
     *
     * @param \TournamentBundle\Entity\RuleFFAGame $rulesFFAGame
     *
     * @return Rule
     */
    public function addRulesFFAGame(\TournamentBundle\Entity\RuleFFAGame $rulesFFAGame)
    {
        $this->rulesFFAGame[] = $rulesFFAGame;

        return $this;
    }

    /**
     * Remove rulesFFAGame
     *
     * @param \TournamentBundle\Entity\RuleFFAGame $rulesFFAGame
     */
    public function removeRulesFFAGame(\TournamentBundle\Entity\RuleFFAGame $rulesFFAGame)
    {
        $this->rulesFFAGame->removeElement($rulesFFAGame);
    }

    /**
     * Get rulesFFAGame
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRulesFFAGame()
    {
        return $this->rulesFFAGame;
    }
}
