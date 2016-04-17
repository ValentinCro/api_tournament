<?php

namespace AppBundle\Listener;

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

    /**
     * @var Serializer
     */
    protected $serializer;
    
    public function __construct(Logger $logger, Serializer $serializer) {
        $this->logger = $logger;
        $this->serializer =  $serializer;
    }
    
    public function onKernelException(GetResponseForExceptionEvent $event) {
        $exception = $event->getException();

        // If instance of HttpException then send expected status code
        if ($exception instanceof HttpException) {
            $this->logger->addInfo(get_class($exception) . ' (' . $exception->getStatusCode() . ') : ' . $event->getRequest()->getRequestUri());
            $event->setResponse(new Response('', $exception->getStatusCode()));
        } else {
            // Write log when no expected HTTP Exception
            $this->logger->addCritical(get_class($exception) . ' : ' . $exception->getMessage() . ' at ' . $exception->getTraceAsString());
            $event->setResponse(new Response('', Response::HTTP_INTERNAL_SERVER_ERROR));
        }
    }
}