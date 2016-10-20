<?php

namespace TournamentBundle\Dto;

use JMS\Serializer\Annotation\Type;
use UserBundle\Dto\User;

class Score
{
    /**
     * @var integer
     * @type("integer")
     */
    private $id;

    /**
     * @var int
     * @type("integer")
     */
    private $value;

    /**
     * @var string
     * @type("string")
     */
    private $description;

    public function entityToDto(\TournamentBundle\Entity\Score $score) {
        $this->setId($score->getId());
        $this->setValue($score->getValue());
        $this->setDescription($score->getDescription());
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Score
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }
}
