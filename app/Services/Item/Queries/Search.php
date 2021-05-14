<?php

namespace App\Services\Item\Queries;

use App\Common\Helpers\DateTimeHelper;
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

        $paginator = $query->paginate($this->perPage);

        $paginator->getCollection()->transform(function ($value) {
            $value->finished_at = DateTimeHelper::datetimeFromUTC($value['finished_at']);
            return $value;
        });

        return $paginator;
    }
}
