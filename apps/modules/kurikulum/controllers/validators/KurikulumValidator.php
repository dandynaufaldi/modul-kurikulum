<?php

namespace Siakad\Kurikulum\Controllers\Validators;

use Phalcon\Validation;
use Phalcon\Validation\Validator\Numericality;
use Phalcon\Validation\Validator\PresenceOf;

class KurikulumValidator extends Validation
{
    public function initialize() 
    {
        $this->add(
            [
                'prodi',
                'nama_indonesia',
                'nama_inggris',
                'sks_lulus',
                'sks_wajib',
                'sks_pilihan',
                'semester_normal',
                'semester_mulai',
                'tahun_mulai',
                'tahun_selesai'
            ],
            new PresenceOf(
                [
                    'message' => [
                        'prodi' => 'Program Studi wajib diisi',
                        'nama_indonesia' => 'Nama Kurikulum wajib diisi',
                        'nama_inggris' => 'Nama Inggris wajib diisi',
                        'sks_lulus' => 'Jumlah SKS Lulus wajib diisi',
                        'sks_wajib' => 'Jumlah SKS Wajib wajib diisi',
                        'sks_pilihan' => 'Jumlah SKS Pilihan wajib diisi',
                        'semester_normal' => 'Jumlah Semester Normal wajib diisi',
                        'semester_mulai' => 'Semester Mulai wajib diisi',
                        'tahun_mulai' => 'Tahun Mulai wajib diisi',
                        'tahun_selesai' => 'Tahun Selesai wajib diisi'
                    ], 
                ]
            ) 
        );

        $this->add(
            [
                'sks_lulus',
                'sks_wajib',
                'sks_pilihan',
                'semester_normal',
                'tahun_mulai',
                'tahun_selesai'
            ],
            new Numericality(
                [
                    'message' => [
                        'sks_lulus' => 'Jumlah SKS Lulus harus berupa bilangan',
                        'sks_wajib' => 'Jumlah SKS Wajib harus berupa bilangan',
                        'sks_pilihan' => 'Jumlah SKS Pilihan harus berupa bilangan',
                        'semester_normal' => 'Jumlah Semester Normal harus berupa bilangan',
                        'tahun_mulai' => 'Tahun Mulai harus berupa nilai tahun',
                        'tahun_selesai' => 'Tahun Selesai harus berupa nilai tahun'
                    ]
                ]
            )
        );
    }
}