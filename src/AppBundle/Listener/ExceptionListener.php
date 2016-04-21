<?php

namespace AppBundle\Listener;

use AppBundle\Exception\ConstraintViolationException;
use JMS\Serializer\Serializer;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ExceptionListener {
    /**
     * @var Logger
     */
    protected $logger;
    
    public function __construct(Logger $logger) {
        $this->logger = $logger;
    }
    
    public function onKernelException(GetResponseForExceptionEvent $event) {
        $exception = $event->getException();

        // If instance of ConstraintViolationException then return the json message
        if ($exception instanceof ConstraintViolationException) {
            $event->setResponse(new Response($exception->getMessage(), $exception->getStatusCode()));
        } else if ($exception instanceof HttpException) {
            // If instance of HttpException then send expected status code
            $this->logger->addInfo(get_class($exception) . ' (' . $exception->getStatusCode() . ') : ' . $event->getRequest()->getRequestUri());
            $event->setResponse(new Response('', $exception->getStatusCode()));
        } else {
            // Write log when no expected HTTP Exception
            $this->logger->addCritical(get_class($exception) . ' : ' . $exception->getMessage() . ' at ' . $exception->getTraceAsString());
            $event->setResponse(new Response('', Response::HTTP_INTERNAL_SERVER_ERROR));
        }
    }
}