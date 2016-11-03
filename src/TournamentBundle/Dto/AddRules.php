<?php

namespace TournamentBundle\Dto;

use JMS\Serializer\Annotation\Type;
use TournamentBundle\TournamentBundle;
use TournamentBundle\Entity\Rule;

class AddRules
{
    /**
     * @var array
     * @Type("array<TournamentBundle\Entity\RuleFFA>")
     */
    private $rulesFFA;

    /**
     * @var array
     * @Type("array<TournamentBundle\Entity\RuleFFAGame>")
     */
    private $rulesFFAGame;

    /**
     * @var integer
     * @Type("integer")
     */
    private $tournamentId;

    /**
     * @return int
     */
    public function getTournamentId()
    {
        return $this->tournamentId;
    }

    /**
     * @param int $tournamentId
     */
    public function setTournamentId($tournamentId)
    {
        $this->tournamentId = $tournamentId;
    }

    /**
     * @return array
     */
    public function getRulesFFA()
    {
        return $this->rulesFFA;
    }

    /**
     * @param array $rulesFFA
     * @return AddRules
     */
    public function setRulesFFA($rulesFFA)
    {
        $this->rulesFFA = $rulesFFA;
        return $this;
    }

    /**
     * @return array
     */
    public function getRulesFFAGame()
    {
        return $this->rulesFFAGame;
    }

    /**
     * @param array $rulesFFAGame
     * @return AddRules
     */
    public function setRulesFFAGame($rulesFFAGame)
    {
        $this->rulesFFAGame = $rulesFFAGame;
        return $this;
    }

}

