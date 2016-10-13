<?php

namespace TournamentBundle\Dto;

use JMS\Serializer\Annotation\Type;
use TournamentBundle\TournamentBundle;
use TournamentBundle\Entity\Rule;

class PlayerDto
{

    /**
     * @var string
     * @Type("string")
     */
    private $name;

    /**
     * @var integer
     * @Type("integer")
     */
    private $tournamentId;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return PlayerDto
     */
    public function setName($name)
    {
        $this->name = $name;
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
     */
    public function setTournamentId($tournamentId)
    {
        $this->tournamentId = $tournamentId;
    }
}

