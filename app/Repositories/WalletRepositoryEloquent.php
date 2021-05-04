<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use App\Repositories\WalletRepository;
use App\Models\Wallet;

/**
 * Class WalletRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class WalletRepositoryEloquent extends BaseRepository implements WalletRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Wallet::class;
    }
}
