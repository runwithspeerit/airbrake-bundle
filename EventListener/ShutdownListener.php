<?php

namespace Speerit\AirbrakeBundle\EventListener;

use Airbrake\Notifier;

/**
 * Class ShutdownListener
 *
 * @package Speerit\AirbrakeBundle\EventListener
 */
class ShutdownListener
{
    /**
     * @var Notifier
     */
    protected $notifier;

    /**
     * @param Notifier $notifier
     */
    public function __construct(Notifier $notifier)
    {
        $this->notifier = $notifier;
    }

    /**
     * Register a function for execution on shutdown
     */
    public function register()
    {
        register_shutdown_function([$this, 'onShutdown']);
    }

    /**
     * Handles the PHP shutdown event.
     *
     * This event exists almost solely to provide a means to catch and log errors that might have been
     * otherwise lost when PHP decided to die unexpectedly.
     */
    public function onShutdown()
    {
        // Get the last error if there was one, if not, let's get out of here.
        if (!$error = error_get_last()) {
            return;
        }

        if (!($error['type'] & (E_ERROR | E_PARSE | E_CORE_ERROR | E_COMPILE_ERROR | E_USER_ERROR | E_RECOVERABLE_ERROR))) {
            return;
        }

        $this->notifier->notify(
            new \ErrorException($error['message'], $error['type'], $error['type'], $error['file'], $error['line'])
        );
    }
}
