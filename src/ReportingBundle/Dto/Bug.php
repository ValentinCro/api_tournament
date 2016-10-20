<?php

namespace ReportingBundle\Dto;

use JMS\Serializer\Annotation\Type;


/**
 * Bug
 */
class Bug
{
    /**
     * @var string
     * @type("string")
     */
    private $subject;

    /**
     * @var string
     * @type("string")
     */
    private $description;

    /**
     * @var string
     * @type("string")
     */
    private $author;

    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param mixed $subject
     * @return Bug
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     * @return Bug
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     * @return Bug
     */
    public function setAuthor($author)
    {
        $this->author = $author;
        return $this;
    }
}

