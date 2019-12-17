<?php

namespace Siakad\Kurikulum\Application;

use Siakad\Kurikulum\Domain\Model\RMKRepository;
use Siakad\Kurikulum\Domain\Model\UserRepository;

class LihatFormRMKService
{
    private $rmkRepository;
    private $userRepository;

    public function __construct(
        RMKRepository $rmkRepository,
        UserRepository $userRepository
    )
    {
        $this->rmkRepository = $rmkRepository;
        $this->userRepository = $userRepository;
    }

    public function execute(LihatFormRMKRequest $request)
    {
        $listUser = $this->userRepository->byRoleGreaterThanEqual(3);

        if (empty($request->rmkId)) {
            $response = new LihatFormRMKResponse();
        } else {
            $rmk = $this->rmkRepository->byId($request->rmkId);
            if (empty($rmk)) {
                throw new RMKNotFoundException("RMK not exists");
            }
            $response = new LihatFormRMKResponse($rmk);
        }

        foreach ($listUser as $user) {
            $response->addUser($user);
        }

        return $response;
    }
}