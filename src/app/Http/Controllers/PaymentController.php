<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Sold_item;
use Exception;

class PaymentController extends Controller
{
    public function create($item_id)
    {
        return view('create', ['item_id' => $item_id]);
    }

    public function store(Request $request, $item_id)
    {
        $request->validate([
            'stripeToken' => 'required|string',
        ]);

        \Stripe\Stripe::setApiKey(config('stripe.stripe_secret_key'));

        $userId = Auth::id();
                
        try {

            $charge = \Stripe\Charge::create([
                'source' => $request->stripeToken,
                'amount' => 1000,
                'currency' => 'jpy',
            ]);

            $payment_id = 1;

            $sold_items = new Sold_item();
            $sold_items->item_id = $item_id;
            $sold_items->user_id = $userId;
            $sold_items->payment_id = $payment_id;
            $sold_items->stripe_payment_id = $charge->id;
            
            $sold_items->save();

            return redirect('/mypage')->with('success', '購入が完了しました');
        } catch (Exception $e) {
            return back()->with('flash_alert', '決済に失敗しました ('. $e->getMessage() . ')');
        }        
    }
}
