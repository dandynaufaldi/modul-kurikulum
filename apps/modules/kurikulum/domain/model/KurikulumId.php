<?php

namespace Siakad\Kurikulum\Domain\Model;

use Ramsey\Uuid\Uuid;

class KurikulumId
{
    private $id;

    public function __construct($id = null)
    {
        $this->id = $id ?? Uuid::uuid4()->toString();
    }

    public function id() 
    {
        return $this->id;
    }

    public function isEqual(KurikulumId $other)
    {
        return $this->id === $other->id();
    }

}