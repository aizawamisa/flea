<?php

namespace App\Http\Controllers;

use App\Http\Requests\SellRequest;
use App\Models\Category;
use App\Models\Category_item;
use App\Models\Condition;
use App\Models\Item;
use Illuminate\Support\Facades\Storage;


class SellController extends Controller
{
    public function index($item_id = null)
    {
        $conditions = Condition::all();
        $selectedConditionId = null;
        $selectedCategoryId = null;

        if ($item_id) {
            $item = Item::find($item_id);
            $selectedConditionId = $item->condition_id;
            $selectedCategoryId = $item->categories->first()->id;
        }

        $parentCategories = Category::whereNull('parent_id')->with('children')->get();
        $selectCategories = [];
        foreach ($parentCategories as $parent) {
            foreach ($parent->children as $child) {
                $selectCategories[] = [
                'id' => $child->id,
                'name' => $parent->name . ' _ ' . $child->name ,
                'selected' => $child->id == $selectedCategoryId
            ];
            }            
        }

        $data = [
            'conditions' => $conditions,
            'selectedConditionId' => $selectedConditionId,
            'selectedCategories' => $selectCategories,
            'item' => $item ?? null,
            'item_id' => $item_id ?? null,
        ];

        return view('sell', $data);
    }

    public function create(SellRequest $request)
    {
        $form = $request->all();

        // 価格はカンマ削除後、整数に変換
        $form['price'] = str_replace(',', '', $form['price']);
        $form['price'] = intval($form['price']);

        $file = $request->file('img_url');
        $filename = time() . '_' . 
        $file->getClientOriginalName();
        $path = $file->storeAs('uploads', $filename, 'public');
        $form['img_url'] = Storage::url($path);

        $newItem = Item::create($form);

        $categoryItems = new Category_item();
        $categoryItems->item_id = $newItem->id;
        $categoryItems->category_id = $request->category_id;
        $categoryItems->save();

        return redirect('/mypage')->with('success', '出品しました');
    }

    public function edit(SellRequest $request, $item_id)
    {
        $form = $request->all();
        unset($form['_token']);

        if (isset($form['img_url'])) {
            $file = $request->file('img_url');
            $filename = time() . '_' . $file->getClientOriginalName();

            $path = $file->storeAs('uploads', $filename, 'public');
            $form['img_url'] = Storage::url($path);
        }

        if (isset($form['price'])) {
            $form['price'] = str_replace(',', '', $form['price']);
        }

        Item::find($item_id)->update($form);

        return redirect('/mypage')->with('success', '修正しました');
    }
}
