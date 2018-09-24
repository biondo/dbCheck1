<?php
/**
 * Created by PhpStorm.
 * User: Biondo
 * Date: 22/09/2018
 * Time: 00:28
 */

namespace DoubleCheck\Repositories;


use DoubleCheck\Entities\Client;
use Prettus\Repository\Eloquent\BaseRepository;

class ClientRepositoryEloquent extends BaseRepository implements ClientRepository
{
    public function model()
    {
        return Client::class;
    }
}