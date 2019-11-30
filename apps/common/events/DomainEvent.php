<?php

namespace Kur\Common\Events;

interface DomainEvent
{
    /**
    * @return DateTimeImmutable
    */
    public function occurredOn();
}