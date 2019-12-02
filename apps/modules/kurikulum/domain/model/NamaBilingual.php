<?php

namespace Siakad\Kurikulum\Domain\Model;

class NamaBilingual
{
    private $indonesia;
    private $inggris;

    public function __construct(string $indonesia, string $inggris)
    {
        $this->indonesia = $indonesia;
        $this->inggris = $inggris;
    }

    public function indonesia()
    {
        return $this->indonesia;
    }

    public function inggris()
    {
        return $this->inggris;
    }
}