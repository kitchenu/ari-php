<?php

namespace Ari\Models\Events;

interface EventInterface
{
    public function getAsteriskId();

    /**
     * @return string Name of the application receiving the event.
     */
    public function getApplication();

    /**
     * @return \DateTime (optional) - Time at which this event was created.
     */
    public function getTimestamp();
}