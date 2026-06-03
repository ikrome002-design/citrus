<?php

namespace App\Http\Controllers\Admin\HomePageSetting;

use App\Shop\BannerSetting\BannerSetting;
use App\Shop\BannerSetting\Repositories\BannerSettingRepository;
use App\Shop\BannerSetting\Repositories\Interfaces\BannerSettingRepositoryInterface;
use App\Shop\BannerSetting\Requests\UpdateBannerSettingRequest;
use App\Shop\BannerSetting\Requests\CreateBannerSettingRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class BannerController extends Controller
{
    private $bannerSettingRepo;

    public function __construct(
        BannerSettingRepositoryInterface $bannerSettingRepository)
    {
        $this->bannerSettingRepo = $bannerSettingRepository;
       
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $list = $this->bannerSettingRepo->listBannerSetting('created_at', 'desc');

        return view('admin.homepagesetting.banner.list', [
           'lists' => $this->bannerSettingRepo->paginateArrayResults($list->all(), 10)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $bannersetting = $this->bannerSettingRepo->findBannerSettingById($id);
        return view('admin.homepagesetting.banner.show', ['lists' => $bannersetting]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin.homepagesetting.banner.edit',['banner' => $this->bannerSettingRepo->findBannerSettingById($id)]);
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.homepagesetting.banner.create');
    }


    public function store(CreateBannerSettingRequest $request)
    {   
        if ($request->has('banner_image') && $request->file('banner_image') != ''){
            $file = $request->file('banner_image');
            request()->validate([
                'banner_image' => 'required|mimes:jpeg,png,jpg,gif,svg',
            ]);
            // $destinationPath = 'storage/banners';
            // $file->move($destinationPath,$file->getClientOriginalName());
            $file->move(public_path('storage/banners/'),$file->getClientOriginalName());
        }
        $bannersetting = $this->bannerSettingRepo->createBannerSetting($request->all());
        return redirect()->route('admin.banners.index')->with('message', 'Created successfully');
}


    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateCountryRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBannerSettingRequest $request, $id)
    {
        if ($request->has('banner_image') && $request->file('banner_image') != ''){
            $file = $request->file('banner_image');
            request()->validate([
                'banner_image' => 'required|mimes:jpeg,png,jpg,gif,svg',
            ]);
            // $destinationPath = 'storage/banners';
            // $file->move($destinationPath,$file->getClientOriginalName());
            $file->move(public_path('storage/banners/'),$file->getClientOriginalName());
        }
        $bannersetting = $this->bannerSettingRepo->findBannerSettingById($id);
        $update = new BannerSettingRepository($bannersetting);
        $update->updateBannerSetting($request->except('_method', '_token'));

        $request->session()->flash('message', 'Update successful');
        return redirect()->route('admin.banners.edit', $id);
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(int $id)
    {
   
        $bannersetting = $this->bannerSettingRepo->findBannerSettingById($id);
        $bannerSettingRepo = new BannerSettingRepository($bannersetting);
        $bannerSettingRepo->deleteBannerSetting();
        return redirect()->route('admin.banners.index')->with('message', 'Delete successful');

    }


    public function approve($id) 
    {
        
        $bannersetting = $this->bannerSettingRepo->findbannerSettingById($id);
        if($bannersetting)
        {
            $bannersetting->status = 1;
            $bannersetting->save();
            return redirect()->back()->with('message', 'Approved successfully');
           
        }
    }

    public function unapprove($id) 
    {   
        $bannersetting = $this->bannerSettingRepo->findbannerSettingById($id);
        if($bannersetting)
        {
            $bannersetting->status = 0;
            $bannersetting->save();
            return redirect()->back()->with('error', 'Unapproved successfully');
            
        }
    }
}
