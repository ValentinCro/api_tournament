<?php

namespace AppBundle\Dto;

use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationList;

class ConstraintViolationError
{
    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $message;

    /**
     * @param ConstraintViolationInterface $constraintViolation
     * @return ConstraintViolationError
     */
    public static function fromConstraintViolation(ConstraintViolationInterface $constraintViolation) {
        $error = new ConstraintViolationError();
        $error->setCode($constraintViolation->getMessageTemplate());
        $error->setMessage($constraintViolation->getMessage());
        return $error;
    }

    /**
     * @param ConstraintViolationList $constraintViolationList
     * @return array of ConstraintViolationError
     */
    public static function fromConstraintViolationList(ConstraintViolationList $constraintViolationList)
    {
        $errors = [];
        foreach ($constraintViolationList as $violation) {
            $errors[] = static::fromConstraintViolation($violation);
        }
        return $errors;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     * @return Error
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return Error
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }
}