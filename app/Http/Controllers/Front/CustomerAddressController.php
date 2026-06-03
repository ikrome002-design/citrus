<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Shop\Addresses\Requests\CreateAddressRequest;
use App\Shop\Addresses\Requests\UpdateAddressRequest;
use App\Shop\Addresses\Repositories\AddressRepository;
use App\Shop\Cities\Repositories\Interfaces\CityRepositoryInterface;
use App\Shop\Addresses\Repositories\Interfaces\AddressRepositoryInterface;
use App\Shop\Countries\Repositories\Interfaces\CountryRepositoryInterface;
use App\Shop\Provinces\Repositories\Interfaces\ProvinceRepositoryInterface;
use App\Address;

class CustomerAddressController extends Controller
{
    /**
     * @var AddressRepositoryInterface
     */
    private $addressRepo;

    /**
     * @var CountryRepositoryInterface
     */
    private $countryRepo;

    /**
     * @var CityRepositoryInterface
     */
    private $cityRepo;

    /**
     * @var ProvinceRepositoryInterface
     */
    private $provinceRepo;


    /**
     * @param AddressRepositoryInterface  $addressRepository
     * @param CountryRepositoryInterface  $countryRepository
     * @param CityRepositoryInterface     $cityRepository
     * @param ProvinceRepositoryInterface $provinceRepository
     */
    public function __construct(
        AddressRepositoryInterface $addressRepository,
        CountryRepositoryInterface $countryRepository,
        CityRepositoryInterface $cityRepository,
        ProvinceRepositoryInterface $provinceRepository
    ) {
        $this->addressRepo = $addressRepository;
        $this->countryRepo = $countryRepository;
        $this->provinceRepo = $provinceRepository;
        $this->cityRepo = $cityRepository;
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index()
    {

        return redirect()->route('accounts', ['tab' => 'v-pills-my-addresses']);
    }

     /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show()
    {

        return redirect()->route('accounts', ['tab' => 'v-pills-my-addresses']);
    }

    /**
     * @param  $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $customer = auth()->user();

        return view('front.customers.addresses.create', [
            'customer' => $customer,
            'countries' => $this->countryRepo->listCountries(),
            'cities' => $this->cityRepo->listCities(),
            'provinces' => $this->provinceRepo->listProvinces()
        ]);
    }

    /**
     * @param CreateAddressRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateAddressRequest $request)
    {

        $request['customer_id'] = auth()->user()->id;

        $this->addressRepo->createAddress($request->except('_token', '_method'));

        return redirect()->route('accounts', ['tab' => 'v-pills-my-addresses'])
            ->with('message', 'Address creation successful');
    }


    public function checkoutAddress(){      
      
      parse_str($_GET['billing_request'], $billing_data);
      parse_str($_GET['shipping_request'], $shipping_data);
      $sameAdd = $_GET['sameAddree'];

      $address = array();
      $billing_id = $address['billing_id'] = isset($billing_data['billing_address_id'])?$billing_data['billing_address_id']:0;
      $shipping_id = $address['shipping_id'] = isset($shipping_data['shipping_address_id'])?$shipping_data['shipping_address_id']:$address['billing_id'];
      $address['sameAdd'] = $sameAdd;
      $request['customer_id'] = auth()->user()->id;
      $request['address_type']='billing';
      $request['first_name'] = $billing_data['billing_first_name'];
      $request['last_name'] = $billing_data['billing_last_name'];
      //$request['company_name'] = $billing_data['billing_company_name'];
      $request['country_id'] = $billing_data['billing_country'];
      $request['address_1'] = $billing_data['billing_address_1'];
      $request['address_2'] = $billing_data['billing_address_2'];
      //$request['city'] = $billing_data['billing_city'];
      $request['phone'] = $billing_data['billing_phone'];
      $request['zip'] = $billing_data['billing_postcode'];
      $request['email'] = $billing_data['billing_email'];
      $request['status'] = 1;

      if($address['billing_id'] == 0){
        $request['alias']='Other Billing Address';
        $billing_address = Address::create($request); 
        $address['billing_id'] = $billing_address->id;
      }else{
        $billing_address = Address::where('id',$billing_id)->update($request); 
      }
      return response()->json($address);

      if($sameAdd!=1){
        $request['address_type']='shipping';
        $request['first_name'] = $shipping_data['shipping_first_name'];
        $request['last_name'] = $shipping_data['shipping_last_name'];
        $request['company_name'] = $shipping_data['shipping_company_name'];
        $request['country_id'] = $shipping_data['shipping_country_id'];
        $request['address_1'] = $shipping_data['shipping_address_1'];
        $request['address_2'] = $shipping_data['shipping_address_2'];
        $request['phone'] = $shipping_data['shipping_phone'];
        $request['city'] = $shipping_data['shipping_city'];
        $request['zip'] = $shipping_data['shipping_postcode'];
        $request['email'] = $shipping_data['shipping_email'];
        $request['status'] = 1;

        if($shipping_id == 0){
            $request['alias']='Other Shipping Address';
            $shipping_address = Address::create($request); 
            $address['shipping_id'] = $shipping_address->id;
        }else{
            $shipping_address = Address::where('id',$shipping_id)->update($request); 
        }
      }

      return response()->json($address);
    }
    /**
     * @param $addressId
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($customerId, $addressId)
    {
        $countries = $this->countryRepo->listCountries();

        $address = $this->addressRepo->findCustomerAddressById($addressId, auth()->user());

        return view('front.customers.addresses.edit', [
            'customer' => auth()->user(),
            'address' => $address,
            'countries' => $countries,
            'cities' => $this->cityRepo->listCities(),
            'provinces' => $this->provinceRepo->listProvinces()
        ]);
    }

    /**
     * @param UpdateAddressRequest $request
     * @param $addressId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateAddressRequest $request, $customerId, $addressId)
    {
        $address = $this->addressRepo->findCustomerAddressById($addressId, auth()->user());

        $request = $request->except('_token', '_method');
        $request['customer_id'] = auth()->user()->id;

        $addressRepo = new AddressRepository($address);
        $addressRepo->updateAddress($request);

        return redirect()->route('accounts', ['tab' => 'v-pills-my-addresses'])
            ->with('message', 'Address update successful');
    }

    /**
     * @param $addressId
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($customerId, $addressId)
    {
        $address = $this->addressRepo->findCustomerAddressById($addressId, auth()->user());

       if ($address->orders()->exists()) {
             $address->status=0;
             $address->save();
       }
       else {
             $address->delete();
       }
        return redirect()->route('accounts', ['tab' => 'v-pills-my-addresses'])
            ->with('message', 'Address delete successful');
    }
}
