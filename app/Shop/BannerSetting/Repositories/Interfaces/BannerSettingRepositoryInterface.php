<?php

namespace App\Shop\BannerSetting\Repositories\Interfaces;

use Jsdecena\Baserepo\BaseRepositoryInterface;
use App\Shop\BannerSetting\BannerSetting;
use Illuminate\Support\Collection;

interface BannerSettingRepositoryInterface extends BaseRepositoryInterface
{
    public function updateBannerSetting(array $params) : BannerSetting;

    public function listBannerSetting(string $order = 'id', string $sort = 'desc') : Collection;
    
    public function createBannerSetting(array $params) : BannerSetting;

    public function findBannerSettingById(int $id) : BannerSetting;
    
    public function deleteBannerSetting() : bool;

   // public function findProvinces();


    //public function listStates() : Collection;
}
