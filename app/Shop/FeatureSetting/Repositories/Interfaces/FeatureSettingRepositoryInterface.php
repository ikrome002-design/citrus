<?php

namespace App\Shop\FeatureSetting\Repositories\Interfaces;

use Jsdecena\Baserepo\BaseRepositoryInterface;
use App\Shop\FeatureSetting\FeatureSetting;
use Illuminate\Support\Collection;

interface FeatureSettingRepositoryInterface extends BaseRepositoryInterface
{
    public function updateFeatureSetting(array $params) : FeatureSetting;

    public function listFeatureSetting(string $order = 'id', string $sort = 'desc') : Collection;
    
    public function createFeatureSetting(array $params) : FeatureSetting;

    public function findFeatureSettingById(int $id) : FeatureSetting;
    
    public function deleteFeatureSetting() : bool;

    // public function findProvinces();

	//public function listStates() : Collection;
}
