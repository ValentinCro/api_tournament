<?php

namespace InvitationBundle\Dto;

use JMS\Serializer\Annotation\Type;
use TournamentBundle\Entity\Tournament;
use TournamentBundle\TournamentBundle;
use TournamentBundle\Entity\Rule;
use UserBundle\Entity\User;

class InvitationDto
{
    /**
     * @var integer
     * @Type("integer")
     */
    private $id;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return InvitationDto
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

}
