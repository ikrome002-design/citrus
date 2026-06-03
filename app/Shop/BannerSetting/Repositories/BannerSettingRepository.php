<?php

namespace App\Shop\BannerSetting\Repositories;

use Jsdecena\Baserepo\BaseRepository;
use App\Shop\BannerSetting\Exceptions\BannerSettingInvalidArgumentException;
use App\Shop\BannerSetting\Exceptions\BannerSettingNotFoundException;
use App\Shop\BannerSetting\Repositories\Interfaces\BannerSettingRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use App\Shop\BannerSetting\BannerSetting;
use Illuminate\Support\Collection;

class BannerSettingRepository extends BaseRepository implements BannerSettingRepositoryInterface
{
    /**
     * BannerSettingRepository constructor.
     * @param BannerSetting $bannersetting
     */
    public function __construct(BannerSetting $bannersetting)
    {
        parent::__construct($bannersetting);
        $this->model = $bannersetting;
    }

    /**
     * List all the countries
     *
     * @param string $order
     * @param string $sort
     * @return Collection
     */
    public function listBannerSetting(string $order = 'id', string $sort = 'desc') : Collection
    {
        return $this->model->get();
    }

    /**
     * @param array $params
     * @return BannerSetting
     */
    public function createBannerSetting(array $params) : BannerSetting
    {   
        if ( isset( $params['banner_image'] ) ) {
            $params['banner_image'] = $params['banner_image']->getClientOriginalName();
        }
        return $this->create($params);
    }

    /**
     * Find the country
     *
     * @param $id
     * @return BannerSetting
     * @throws BannerSettingNotFoundException
     */
    public function findBannerSettingById(int $id) : BannerSetting
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new BannerSettingNotFoundException('BannerSetting not found.');
        }
    }

  
    /**
     * Update the BannerSetting
     *
     * @param array $params
     *
     * @return BannerSetting
     * @throws BannerSettingNotFoundException
     */
    public function updateBannerSetting(array $params) : BannerSetting
    {
        try {
            if (isset( $params['banner_image'] ) && $params['banner_image'] != ''){
                $params['banner_image'] = $params['banner_image']->getClientOriginalName();
            }else{
                $params['banner_image'] = $params['banner_image_old'];
            }
            $this->model->update($params);
            return $this->findBannerSettingById($this->model->id);
        } catch (QueryException $e) {
            throw new BannerSettingInvalidArgumentException($e->getMessage());
        }
    }

    public function deleteBannerSetting() : bool
    {
        return $this->delete();
    }

   
}
