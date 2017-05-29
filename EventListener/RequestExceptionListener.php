<?php

namespace Speerit\AirbrakeBundle\EventListener;

use Airbrake\Notifier;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

/**
 * Class RequestExceptionListener
 *
 * @package Speerit\AirbrakeBundle\EventListener
 */
class RequestExceptionListener
{
    /**
     * @var Notifier
     */
    protected $notifier;

    /**
     * @var array
     */
    protected $ignoredExceptions;

    /**
     * @param Notifier $notifier
     * @param array $ignoredExceptions
     */
    public function __construct(Notifier $notifier, array $ignoredExceptions = [])
    {
        $this->notifier = $notifier;
        $this->ignoredExceptions = $ignoredExceptions;
    }

    /**
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        foreach ($this->ignoredExceptions as $ignoredException) {
            if ($exception instanceof $ignoredException) {
                return;
            }
        }

        $this->notifier->notify($exception);
    }
}
