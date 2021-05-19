<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserWallet;
use App\Services\Bid\Queries\LastBidByItem;
use App\Services\UserAutoBidding\Queries\GetAutoBidItemsByUser;
use App\Services\UserWallet\Actions\AddAmount;
use App\Services\UserWallet\Actions\IncrementAmount;
use App\Services\UserWallet\Queries\GetUserWallet;
use App\Services\UserWallet\Queries\GetWalletAmount;
use Auth;
use Exception;
use Illuminate\Http\Request;

class UserWalletController extends Controller
{
    private $rules = [
        'amount' => 'required|regex:/^\d*(\.\d{1,2})?$/',
    ];

    public function index()
    {
        $wallet = (new GetUserWallet(Auth::id()))->execute();
        $items = (new GetAutoBidItemsByUser(Auth::id()))->execute();

        $data = [];

        foreach ($items as $item) {
            $item = $item->item;

            if (! $bid = LastBidByItem::execute($item->id)) {
                continue;
            }

            $data[] = $item;
        }

        $response = [
            'maximum_amount' => $wallet->maximum_amount,
            'amount_remaining' => $wallet->amount_remaining,
            'items' => $data,
        ];

        return $this->successResponse($response);
    }

    public function store(Request $request)
    {
        $data = $this->validate($request, $this->rules);

        try {
            $model = (new AddAmount(Auth::id()))->execute($data['amount']);
        } catch (Exception $exception) {
            return $this->errorResponse($exception->getMessage());
        }


        return $this->successResponse($model);
    }
}
