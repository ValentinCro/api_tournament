<?php

namespace InvitationBundle\Dto;

use JMS\Serializer\Annotation\Type;
use TournamentBundle\Entity\Tournament;
use TournamentBundle\TournamentBundle;
use TournamentBundle\Entity\Rule;
use UserBundle\Entity\User;

class InviteDto
{
    /**
     * @var string
     * @Type("string")
     */
    private $senderName;

    /**
     * @var string
     * @Type("string")
     */
    private $receiverName;

    /**
     * @var integer
     * @Type("integer")
     */
    private $tournamentId;

    /**
     * @return string
     */
    public function getSenderName()
    {
        return $this->senderName;
    }

    /**
     * @param string $senderName
     */
    public function setSenderName($senderName)
    {
        $this->senderName = $senderName;
    }

    /**
     * @return string
     */
    public function getReceiverName()
    {
        return $this->receiverName;
    }

    /**
     * @param string $receiverName
     */
    public function setReceiverName($receiverName)
    {
        $this->receiverName = $receiverName;
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
