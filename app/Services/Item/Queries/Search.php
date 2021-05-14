<?php

namespace App\Services\Item\Queries;

use App\Models\Item;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class Search
{
    public $userId;
    public $searchText;
    public $priceSort;
    public $perPage = 10;

    const SORT_PRICE_DESC = 'desc';
    const SORT_PRICE_ASC = 'asc';

    /**
     * @return LengthAwarePaginator
     */
    public function execute()
    {
        $query = Item::query();

        if ($this->searchText) {
            $query->where('name', 'like', '%' . $this->searchText . '%');
            $query->orWhere('description', 'like', '%' . $this->searchText . '%');
        }

        if ($this->priceSort) {
            $query->orderBy('final_price', $this->priceSort);
        }

        return $query->paginate($this->perPage);
    }
}
