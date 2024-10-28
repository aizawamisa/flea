<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;

class IndexController extends Controller
{
    public function index()
    {
        $likeItems = collect();

        $items = Item::whereDoesntHave('soldToUsers')->when(Auth::check(), function ($query) {
            $query->where('user_id', '!=', Auth::id());
        })->paginate(10);        

        if (Auth::check()){
            $user = Auth::user();
            $likeItems = $user->likeItems()->paginate(10);
        }
        
        return view('index', compact('items', 'likeItems'));
    }

    public function search(Request $request)
    {
        $searchText = $request->input('searchText');

        $items = Item::where('name', 'like', '%' . $searchText . '%') ->get();

        return view('index_search', compact('items'));
    }
}

