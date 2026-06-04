<?php

namespace App\Http\Controllers\Admin\MembershipVarients;

use App\Http\Controllers\Controller;
use App\Shop\MembershipVarients\Repositories\MembershipVarientRepositoryInterface;

class MembershipVarientController extends Controller
{
    protected $membershipvarientRepo;

    public function __construct(MembershipVarientRepositoryInterface $membershipvarientRepository)
    {
        $this->membershipvarientRepo = $membershipvarientRepository;
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $membershipvarientId)
    {
        $membershipvarient = $this->membershipvarientRepo->findMembershipvarientById($membershipvarientId);

        return view('admin.provinces.show', [
            'membershipvarient' => $membershipvarient,
        ]);
    }
}
