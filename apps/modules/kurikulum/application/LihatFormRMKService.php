<?php

namespace Siakad\Kurikulum\Application;

use Siakad\Kurikulum\Domain\Model\KurikulumRepository;
use Siakad\Kurikulum\Domain\Model\RMKRepository;
use Siakad\Kurikulum\Domain\Model\UserRepository;

class LihatFormRMKService
{
    private $rmkRepository;
    private $kurikulumRepository;
    private $userRepository;

    public function __construct(
        RMKRepository $rmkRepository,
        KurikulumRepository $kurikulumRepository,
        UserRepository $userRepository
    )
    {
        $this->rmkRepository = $rmkRepository;
        $this->kurikulumRepository = $kurikulumRepository;
        $this->userRepository = $userRepository;
    }

    public function execute(LihatFormRMKRequest $request)
    {
        $listKurikulum = $this->kurikulumRepository->all();
        $listUser = $this->userRepository->byRoleGreaterThanEqual(3);

        if (empty($kurikulumId)) {
            $response = new LihatFormRMKResponse();
        } else {
            $rmk = $this->rmkRepository->byKode($request->rmkKode);
            if (empty($rmk)) {
                throw new RMKNotFoundException("RMK not exists");
            }
            $response = new LihatFormRMKResponse($rmk);
        }
        
        foreach ($listKurikulum as $kurikulum) {
            $response->addKurikulum($kurikulum);
        }

        foreach ($listUser as $user) {
            $response->addUser($user);
        }

        return $response;
    }
}