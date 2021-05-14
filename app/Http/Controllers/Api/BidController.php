<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bid;
use App\Services\Bid\Actions\Create;
use App\Services\Item\Queries\GetItemDetail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BidController extends Controller
{
    private $rules = [
        'item_id' => 'required|integer',
        'amount' => 'required|regex:/^\d*(\.\d{1,2})?$/',
    ];

    public function index()
    {
        return Bid::all();
    }

    public function store(Request $request)
    {
        $data = $this->validate($request, $this->rules);

        try {
            $bid = new Create(Auth::id());
            $bid->execute($data['item_id'], $data['amount']);
        } catch (Exception $exception) {
            return $this->errorResponse($exception->getMessage());
        }

        $data = (new GetItemDetail(Auth::id()))->execute($data['item_id']);

        return $this->successResponse($data);
    }
}
