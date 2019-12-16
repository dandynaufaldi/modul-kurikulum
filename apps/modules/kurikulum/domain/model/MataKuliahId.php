<?php

namespace Siakad\Kurikulum\Domain\Model;

use Ramsey\Uuid\Uuid;

class MataKuliahId
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

    public function isEqual(MataKuliahId $other)
    {
        return $this->id == $other->id();
    }
}