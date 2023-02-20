<?php

namespace Neo\Presentation\EventListener;

use Neo\Presentation\Exception\ApiException;
use Neo\Presentation\Response\ErrorResponse;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ApiExceptionSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException'
        ];
    }

    public function onKernelException(ExceptionEvent $event)
    {
        // TODO probably we need to return JSON response for all errors when URL starts with /neo prefix.
        if ($event->getThrowable() instanceof ApiException) {
            $response = new ErrorResponse(
                $event->getThrowable()->getUserMessage(),
                $event->getThrowable()->getHttpCode()
            );
            $event->setResponse($response);
        }
    }
}
