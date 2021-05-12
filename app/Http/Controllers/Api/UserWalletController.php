<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserWallet;
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
        $data = UserWallet::query()->find(Auth::id())->maximum_amount;

        return $this->successResponse(['maximum_amount' => $data]);
    }

    public function store(Request $request)
    {
        $data = $this->validate($request, $this->rules);
        $model = (new IncrementAmount(Auth::id()))->execute($data['amount']);

        return $this->successResponse($model);
    }
}
