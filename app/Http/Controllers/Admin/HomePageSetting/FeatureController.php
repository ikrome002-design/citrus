<?php

namespace App\Http\Controllers\Admin\HomePageSetting;

use App\Shop\FeatureSetting\FeatureSetting;
use App\Shop\FeatureSetting\Repositories\FeatureSettingRepository;
use App\Shop\FeatureSetting\Repositories\Interfaces\FeatureSettingRepositoryInterface;
use App\Shop\FeatureSetting\Requests\UpdateFeatureSettingRequest;
use App\Shop\FeatureSetting\Requests\CreateFeatureSettingRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class FeatureController extends Controller
{
    private $featureSettingRepo;

    public function __construct(
        FeatureSettingRepositoryInterface $featureSettingRepository)
    {
        $this->featureSettingRepo = $featureSettingRepository;
       
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $list = $this->featureSettingRepo->listFeatureSetting('created_at', 'desc');

        return view('admin.homepagesetting.feature.list', [
           'lists' => $this->featureSettingRepo->paginateArrayResults($list->all(), 10)
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
        $featuresetting = $this->featureSettingRepo->findFeatureSettingById($id);
        return view('admin.homepagesetting.feature.show', ['lists' => $featuresetting]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin.homepagesetting.feature.edit',['feature' => $this->featureSettingRepo->findFeatureSettingById($id)]);
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.homepagesetting.feature.create');
    }


    public function store(CreateFeatureSettingRequest $request)
    {   
        if ($request->has('banner_image') && $request->file('banner_image') != ''){
            $file = $request->file('banner_image');
            request()->validate([
                'banner_image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:1024',
            ]);
            $destinationPath = 'storage/features';
            $file->move($destinationPath,$file->getClientOriginalName());
        }
        $featuresetting = $this->featureSettingRepo->createFeatureSetting($request->all());
        return redirect()->route('admin.features.index')->with('message', 'Created successfully');
}


    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateCountryRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFeatureSettingRequest $request, $id)
    {
        if ($request->has('banner_image') && $request->file('banner_image') != ''){
            $file = $request->file('banner_image');
            request()->validate([
                'banner_image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:1024',
            ]);
            $destinationPath = 'storage/features';
            $file->move($destinationPath,$file->getClientOriginalName());
        }
        $featuresetting = $this->featureSettingRepo->findFeatureSettingById($id);
        $update = new FeatureSettingRepository($featuresetting);
        $update->updateFeatureSetting($request->except('_method', '_token'));

        $request->session()->flash('message', 'Update successful');
        return redirect()->route('admin.features.edit', $id);
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
        
        
        $featuresetting = $this->featureSettingRepo->findFeatureSettingById($id);
        $featureSettingRepo = new FeatureSettingRepository($featuresetting);
        $featureSettingRepo->deleteFeatureSetting();

        return redirect()->route('admin.features.index')->with('message', 'Delete successful');

    }


    public function approve($id) 
    {
        
        $featuresetting = $this->featureSettingRepo->findfeatureSettingById($id);
        if($featuresetting)
        {
            $featuresetting->status = 1;
            $featuresetting->save();
            return redirect()->back()->with('message', 'Approved successfully');
            
        }
    }

    public function unapprove($id) 
    {   
        $featuresetting = $this->featureSettingRepo->findfeatureSettingById($id);
        if($featuresetting)
        {
            $featuresetting->status = 0;
            $featuresetting->save();
            return redirect()->back()->with('error', 'Unapproved successfully');
           
        }
    }

}
