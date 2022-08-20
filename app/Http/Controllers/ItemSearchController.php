<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemSearchController extends Controller
{

    public function index(Request $request)
    {
        Item::createIndex($shards = null, $replicas = null);

        Item::putMapping($ignoreConflicts = true);
    
        Item::addAllToIndex();

        return 'abc';

        // $keyword = $request->get('search','');
        // $items = Item::search($keyword )->toArray();
        // return view('ItemSearch', compact('items'));
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
        ]);

        $item = Item::create($request->all());
        $item->addToIndex();

        return redirect()->back();
    }
}
