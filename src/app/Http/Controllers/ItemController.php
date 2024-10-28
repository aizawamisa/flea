<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use App\Models\Like;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    private function loadItemWithRelations($item_id)
    {
        return Item::with('comments.user', 'categories', 'condition')->findOrFail($item_id);
    }

    private function checkUserLiked($item)
    {
        return $item->likeUsers()->where('user_id', Auth::id())->exists();
    }

    public function index()
    {
        $items = Item::all();
        return view('index', ['items' => $items]);
    }

    public function show($item_id)
    {
        $item = $this->loadItemWithRelations($item_id);

        $category = $item->categories->first();
        $categories = [];

            if ($category) {
                $categories['parentCategory'] = Category::find($category->parent_id)->name ?? $category->name;
                if ($category->parent_id) {
                $categories['childCategory'] = $category->name;
            }
            }
        
            return view('item', [
            'item' => $item,
            'likesCount' => $item->likeUsers->count(),
            'commentsCount' => $item->comments->count(),
            'categories' => $categories,
            'condition' => $item->condition->condition ?? '不明',
            'link' => "/item/comment/{$item_id}",
            'userLiked' => $this->checkUserLiked($item),
            'userItem' => $item->user_id == Auth::id(),
            'img_url' => asset($item->img_url),
        ]);
    }

    public function comment($item_id)
    {
        $item = $this->loadItemWithRelations($item_id);
        $userLiked = $this->checkUserLiked($item);
        $comments = $item->comments;

        $comments = $comments->map(function ($comment) {
            return [
                    'id' => $comment->id,
                    'comment' => $comment->comment,
                    'userId' => $comment->user->id,
                    'userName' => $comment->user->name,
                    'userIcon' => $comment->user->img_url,
                ];
            });

            $data = [
                'item' => $item,
                'likesCount' => $item->likeUsers->count(),
                'commentsCount' => $item->comments->count(),
                'comments' => $comments,
                'link' => "/item/{$item_id}",
                'userLiked' => $userLiked,
            ];

            return view('comment', $data);
    }

    public function store(Request $request, $item_id)
    {
        $userId = Auth::user()->id;
        $commentText = $request->input('comment');
        $comment = new Comment();
        $comment->user_id = $userId;
        $comment->item_id = $item_id;
        $comment->comment = $commentText;
        $comment->save();

        return redirect()->back();
    }

    public function deleteComment($item_id, $comment_id)
    {
        $comment = Comment::where('id', $comment_id)->where('item_id', $item_id)->first();
        if (!$comment) {
        abort(404, 'コメントが見つかりません');
        }
        if ($comment->user_id != Auth::id()) {
        abort(403, '権限がありません');
        }

        $comment->delete();
        return redirect()->back()->with('success', 'このコメントは削除されました');
    }

    public function like($item_id)
    {
        $like = new Like();
        $like->user_id = Auth::id();
        $like->item_id = $item_id;
        $like->save();

        return redirect()->back();
    }

    public function unlike($item_id)
    {
        Auth::user()->likeItems()->detach($item_id);
        return redirect()->back();
    }
}
