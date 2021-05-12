<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Services\Item\Queries\GetItemDetail;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $query = Item::query();
        if ($searchText = $request->input('searchText')) {
            $query->where('name', 'like', '%' . $searchText . '%');
            $query->orWhere('description', 'like', '%' . $searchText . '%');
        }

        $params = $request->all();

        if (isset($params['priceSort'])) {
            $priceSort = $params['priceSort'];

            if ($priceSort == 'false') {
                $query->orderBy('final_price', 'desc');
            } else {
                $query->orderBy('final_price', 'asc');
            }
        }

        $data = $query->paginate(10);

        return $this->successResponse($data);
    }

    public function show(Item $item)
    {
        $data = (new GetItemDetail(\Auth::id()))->execute($item->id);
        return $this->successResponse($data);
    }
}
