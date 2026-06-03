<?php

namespace App\Shop\Footers\Repositories;

use Jsdecena\Baserepo\BaseRepositoryInterface;
use App\Shop\Footers\Footer;
use Illuminate\Support\Collection;

interface FooterRepositoryInterface extends BaseRepositoryInterface
{
    public function createFooter(array $data): Footer;

    public function findFooterById(int $id) : Footer;

    public function updateFooter(array $data) : bool;

    public function deleteFooter() : bool;

    public function listFooters($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc') : Collection;

 
}
