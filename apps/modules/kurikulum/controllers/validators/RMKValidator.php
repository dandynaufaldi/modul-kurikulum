<?php

namespace Siakad\Kurikulum\Controllers\Validators;

use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;

class RMKValidator extends Validation
{
    public function initialize() 
    {
        $this->add(
            [
                'kode_rmk',
                'nama_indonesia',
                'nama_inggris',
                'ketua_identifier',
            ],
            new PresenceOf(
                [
                    'message' => [
                        'kode_rmk' => 'Kode RMK wajib diisi',
                        'nama_indonesia' => 'Nama Kurikulum wajib diisi',
                        'nama_inggris' => 'Nama Inggris wajib diisi',
                        'ketua_identifier' => 'Ketua wajib diisi',
                    ], 
                ]
            ) 
        );
    }
}