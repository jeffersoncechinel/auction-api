<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserWallet;
use App\Services\Bid\Queries\LastBidByItem;
use App\Services\UserAutoBidding\Queries\GetAutoBidItemsByUser;
use App\Services\UserWallet\Actions\IncrementAmount;
use Auth;
use Illuminate\Http\Request;

class UserWalletController extends Controller
{
    private $rules = [
        'amount' => 'required|regex:/^\d*(\.\d{1,2})?$/',
    ];

    public function index()
    {
        $maximumAmount = UserWallet::query()->find(Auth::id())->maximum_amount;
        $items = (new GetAutoBidItemsByUser(Auth::id()))->execute();

        $data = [];

        foreach ($items as $item) {
            $item = $item->item;

            if (! $bid = (new LastBidByItem())->execute($item->id)) {
                continue;
            }

            if ($bid->user_id === Auth::id()) {
                $item['isWinning'] = true;
            } else {
                $item['isWinning'] = false;
            }

            $data[] = $item;
        }

        $response = [
            'maximum_amount' => $maximumAmount,
            'items' => $data,
        ];

        return $this->successResponse($response);
    }

    public function store(Request $request)
    {
        $data = $this->validate($request, $this->rules);
        $model = (new IncrementAmount(Auth::id()))->execute($data['amount']);

        return $this->successResponse($model);
    }
}
