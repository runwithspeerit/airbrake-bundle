<?php

namespace Speerit\AirbrakeBundle\EventListener;

use Airbrake\Notifier;
use Symfony\Component\Console\Event\ConsoleExceptionEvent;

/**
 * Class ConsoleExceptionListener
 *
 * @package Speerit\AirbrakeBundle\EventListener
 */
class ConsoleExceptionListener
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
     * @param ConsoleExceptionEvent $event
     */
    public function onKernelException(ConsoleExceptionEvent $event)
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
