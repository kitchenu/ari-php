<?php

namespace Ari\Models\Events;

interface IdentifiableEventInterface
{

    /**
     * @return string The id to use when emitting the event (should be specific instead of the general
     * event type as to route it correctly)
     */
    public function getEventId();
}
