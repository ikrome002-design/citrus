<?php

namespace App\Shop\FeatureSetting\Repositories;

use Jsdecena\Baserepo\BaseRepository;
use App\Shop\FeatureSetting\Exceptions\FeatureSettingInvalidArgumentException;
use App\Shop\FeatureSetting\Exceptions\FeatureSettingNotFoundException;
use App\Shop\FeatureSetting\Repositories\Interfaces\FeatureSettingRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use App\Shop\FeatureSetting\FeatureSetting;
use Illuminate\Support\Collection;

class FeatureSettingRepository extends BaseRepository implements FeatureSettingRepositoryInterface
{
    /**
     * BannerSettingRepository constructor.
     * @param FeatureSetting $featuresetting
     */
    public function __construct(FeatureSetting $featuresetting)
    {
        parent::__construct($featuresetting);
        $this->model = $featuresetting;
    }

    /**
     * List all the countries
     *
     * @param string $order
     * @param string $sort
     * @return Collection
     */
    public function listFeatureSetting(string $order = 'id', string $sort = 'desc') : Collection
    {
        return $this->model->get();
    }

    /**
     * @param array $params
     * @return FeatureSetting
     */
    public function createFeatureSetting(array $params) : FeatureSetting
    {   
        if ( isset( $params['banner_image'] ) ) {
            $params['banner_image'] = 'features/'.$params['banner_image']->getClientOriginalName();
        }
        return $this->create($params);
    }

    /**
     * Find the country
     *
     * @param $id
     * @return FeatureSetting
     * @throws FeatureSettingNotFoundException
     */
    public function findFeatureSettingById(int $id) : FeatureSetting
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new FeatureSettingNotFoundException('FeatureSetting not found.');
        }
    }

  
    /**
     * Update the FeatureSetting
     *
     * @param array $params
     *
     * @return FeatureSetting
     * @throws FeatureSettingotFoundException
     */
    public function updateFeatureSetting(array $params) : FeatureSetting
    {
        try {
            if (isset( $params['banner_image'] ) && $params['banner_image'] != ''){
                $params['banner_image'] = 'features/'.$params['banner_image']->getClientOriginalName();
            }else{
                $params['banner_image'] = $params['banner_image_old'];
            }
            $this->model->update($params);
            return $this->findFeatureSettingById($this->model->id);
        } catch (QueryException $e) {
            throw new FeatureSettingInvalidArgumentException($e->getMessage());
        }
    }

    public function deleteFeatureSetting() : bool
    {
        return $this->delete();
    }

   
}
