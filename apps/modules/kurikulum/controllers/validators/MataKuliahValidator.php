<?php


namespace Siakad\Kurikulum\Controllers\Validators;


use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;

class MataKuliahValidator extends Validation
{
    public function initialize()
    {
        $this->add(
            [
                'kode_rmk',
                'kode_mata_kuliah',
                'nama_indonesia',
                'nama_inggris',
                'deskripsi',
            ],
            new PresenceOf(
                [
                    'message' => [
                        'kode_rmk' => 'RMK wajib dipilih',
                        'kode_mata_kuliah' => 'Kode Mata Kuliah wajib diisi',
                        'nama_indonesia' => 'Nama Mata Kuliah wajib diisi',
                        'nama_inggris' => 'Nama Inggris wajib diisi',
                        'deskripsi' => 'Deskripsi wajib diisi',
                    ]
                ]
            )
        );
    }
}