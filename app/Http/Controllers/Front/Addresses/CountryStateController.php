<?php

namespace App\Http\Controllers\Front\Addresses;

use App\Http\Controllers\Controller;
use App\Shop\Countries\Repositories\CountryRepository;
use App\Shop\Countries\Repositories\Interfaces\CountryRepositoryInterface;

class CountryStateController extends Controller
{
    private $countryRepo;

    /**
     * CountryStateController constructor.
     */
    public function __construct(CountryRepositoryInterface $countryRepository)
    {
        $this->countryRepo = $countryRepository;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($countryId)
    {
        $country = $this->countryRepo->findCountryById($countryId);

        $countryRepo = new CountryRepository($country);
        $data = $countryRepo->listStates();

        return response()->json(compact('data'));
    }
}
