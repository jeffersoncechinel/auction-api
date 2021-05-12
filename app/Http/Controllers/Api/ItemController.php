<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Services\Item\Queries\GetItemDetail;
use App\Services\Item\Queries\Search;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $search = new Search();
        $search->searchText = $request->input('searchText');
        $search->priceSort = $request->input('priceSort');
        $data = $search->execute();

        return $this->successResponse($data);
    }

    public function show(Item $item)
    {
        $data = (new GetItemDetail(\Auth::id()))->execute($item->id);
        return $this->successResponse($data);
    }
}
