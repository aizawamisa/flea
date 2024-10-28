<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PurchaseRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Sold_item;
use App\Models\Payment;


class PurchaseController extends Controller
{
    public function index($item_id)
    {
        session()->forget('paymentId');
        $user = Auth::user();    
        $item = Item::find($item_id);          
        $profile = $user->profile ?? null;

        $paymentId = session('paymentId', null);

        $paymentId = session('paymentId', 1);
        session(['paymentId' => $paymentId]);
        
        if (session()->has('newPaymentId')) {
            $newPaymentId = session('newPaymentId');
            session(['paymentId' => $newPaymentId]);   
        }

        $paymentMethod = session('newPaymentMethod',$user->userPayments()->latest('id')->first()->method ?? null);

        return view('purchase', compact('item', 'profile', 'paymentId', 'paymentMethod', 'item_id'));
    }

    public function decidePurchase(PurchaseRequest $request, $item_id)
    {
        $userId = Auth::id();
        $payment_id = $request->input('payment_id');

        if (empty($payment_id)) {
            return redirect()->back()->with('error', '決済方法が未選択です');
        }

        $sold_items = new Sold_item();
        $sold_items->item_id = $item_id;
        $sold_items->user_id = $userId;        

        if ($payment_id == 1) {
            // クレカ決済
            return redirect()->route('create', $item_id);
        } elseif ($payment_id == 2) {
            // 銀行振込
            $sold_items->payment_id = 2;
        } elseif ($payment_id == 3) {
            // コンビニ
            $sold_items->payment_id = 3;
        } else {
            return redirect()->back()->with('error', '決済方法が未選択です');
        }        
        $sold_items->payment_id = $payment_id;

        $sold_items->save();

        return redirect('/mypage')->with('success', '購入完了しました');   
    } 

    public function payment($item_id)
    {
        return view('/payment', compact('item_id'));
    }

    public function selectPayment(Request $request, $item_id)
    {
        $paymentId = $request->input('payment_id');
        $newPaymentMethod = Payment::find($paymentId)->method;
        
        session([
            'newPaymentId' => $paymentId,
            'newPaymentMethod' => $newPaymentMethod
        ]);

        return redirect('/purchase/' . $item_id);
    }    

    public function address($item_id)
    {
        $user = Auth::user();
        $profile = $user->profile;

        return view('address', compact('profile', 'item_id'));
    }

    public function updateAddress(Request $request, $item_id)
    {
        $user = Auth::user();
        $form = $request->all();
        $isChanged = false;
        unset($form['_token']);

        if ($user->profile) {
            foreach ($form as $key => $value) {
                if ($user->profile->$key != $value) {
                    $isChanged = true;
                    break;
                }
            }

            $user->profile->update($form);
        } else {
            $user->profile()->create($form);
            $isCanged = true;
        }

        if ($isChanged) {
            session()->flash('success', '配送先を変更しました');
        }

        return redirect('/purchase/' . $item_id);
    }
}