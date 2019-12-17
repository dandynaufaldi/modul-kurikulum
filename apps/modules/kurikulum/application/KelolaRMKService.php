<?php

namespace Siakad\Kurikulum\Application;

use Siakad\Kurikulum\Domain\Model\RMK;
use Siakad\Kurikulum\Domain\Model\RMKRepository;
use Siakad\Kurikulum\Domain\Model\UserRepository;

class KelolaRMKService
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

    public function execute(KelolaRMKRequest $request)
    {
        $user = $this->userRepository->byIdentifier($request->ketuaIdentifier);
        if (empty($user)) {
            throw new UserNotFoundException("User not exist");
        }

        $rmk = RMK::makeRMK(
            $request->kode,
            $request->namaIndonesia,
            $request->namaInggris,
            $user,
            $request->id
        );
        $this->rmkRepository->save($rmk);
    }
}