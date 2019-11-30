<?php

namespace Siakad\Common\Events;

interface DomainEvent
{
    /**
    * @return DateTimeImmutable
    */
    public function occurredOn();
}