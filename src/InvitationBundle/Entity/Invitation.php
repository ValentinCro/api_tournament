<?php

namespace InvitationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Invitation
 *
 * @ORM\Table(name="invitation")
 * @ORM\Entity(repositoryClass="TournamentBundle\Repository\InvitationRepository")
 */
class Invitation
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var bool
     *
     * @ORM\Column(name="accepted", type="boolean")
     */
    private $accepted;

    /**
     * @var bool
     *
     * @ORM\Column(name="declined", type="boolean")
     */
    private $declined;

    /**
     * @ORM\ManyToOne(targetEntity="TournamentBundle\Entity\Tournament")
     * @ORM\JoinColumn(name="tournament_id", referencedColumnName="id")
     */
    private $tournament;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(name="sender_id", referencedColumnName="id")
     */
    private $sender;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(name="receiver_id", referencedColumnName="id")
     */
    private $receiver;

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
     * Set accepted
     *
     * @param boolean $accepted
     *
     * @return Invitation
     */
    public function setAccepted($accepted)
    {
        $this->accepted = $accepted;

        return $this;
    }

    /**
     * Get accepted
     *
     * @return bool
     */
    public function getAccepted()
    {
        return $this->accepted;
    }

    /**
     * Set tournament
     *
     * @param \TournamentBundle\Entity\Tournament $tournament
     *
     * @return Invitation
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
     * Set sender
     *
     * @param \UserBundle\Entity\User $sender
     *
     * @return Invitation
     */
    public function setSender(\UserBundle\Entity\User $sender = null)
    {
        $this->sender = $sender;

        return $this;
    }

    /**
     * Get sender
     *
     * @return \UserBundle\Entity\User
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * Set receiver
     *
     * @param \UserBundle\Entity\User $receiver
     *
     * @return Invitation
     */
    public function setReceiver(\UserBundle\Entity\User $receiver = null)
    {
        $this->receiver = $receiver;

        return $this;
    }

    /**
     * Get receiver
     *
     * @return \UserBundle\Entity\User
     */
    public function getReceiver()
    {
        return $this->receiver;
    }

    /**
     * Set declined
     *
     * @param boolean $declined
     *
     * @return Invitation
     */
    public function setDeclined($declined)
    {
        $this->declined = $declined;

        return $this;
    }

    /**
     * Get declined
     *
     * @return boolean
     */
    public function getDeclined()
    {
        return $this->declined;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Invitation
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }
}
