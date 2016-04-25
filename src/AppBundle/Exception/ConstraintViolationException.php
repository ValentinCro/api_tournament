<?php

namespace AppBundle\Exception;

use AppBundle\Dto\ConstraintViolationError;
use JMS\Serializer\Serializer;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ConstraintViolationException extends HttpException
{
    /**
     * Constructor.
     *
     * @param string     $message  The json exception message
     * @param \Exception $previous The previous exception
     * @param int        $code     The internal exception code
     */
    public function __construct($message = "", \Exception $previous = null, $code = 0)
    {
        parent::__construct(400, $message, $previous, array(), $code);
    }

    public static function fromConstraintViolationErrorList(array $constraintViolationList, Serializer $serializer)
    {
        $json = $serializer->serialize($constraintViolationList, 'json');
        return new ConstraintViolationException($json);
    }
}