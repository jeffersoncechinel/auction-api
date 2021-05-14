<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Item\Queries\GetItemDetail;
use App\Services\UserAutoBidding\Actions\DisableAutoBid;
use App\Services\UserAutoBidding\Actions\EnableAutoBid;
use App\Services\UserAutoBidding\Queries\GetAutoBidStatus;
use Auth;
use Exception;
use Illuminate\Http\Request;

class UserAutoBiddingController extends Controller
{
    private $rules = [
        'item_id' => 'required|integer',
        'is_active' => 'required|boolean',
    ];

    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        $data = $this->validate($request, $this->rules);

        try {
            if ($data['is_active']) {
                (new EnableAutoBid(Auth::id()))->execute($data['item_id']);
            } else {
                (new DisableAutoBid(Auth::id()))->execute($data['item_id']);
            }
        } catch (Exception $exception) {
            return $this->errorResponse($exception->getMessage());
        }

        $data = (new GetItemDetail(Auth::id()))->execute($data['item_id']);

        return $this->successResponse($data);
    }

    public function show($itemId)
    {
        $status = (new GetAutoBidStatus(Auth::id()))->execute($itemId);

        return $this->successResponse(['is_active' => $status]);
    }
}
