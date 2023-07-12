<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use App\Notifications\AcceptReplaceNotification;
use App\Notifications\CancelReplaceNotification;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('admin.notifications.productReplaceNotification');
    }

    public function ReplaceCancel(DatabaseNotification $notification)
    {
        $product = Product::find($notification->data['product']['id']);
        $productReplace = Product::find($notification->data['productReplace']['id']);
        $notification->markAsRead();
        $productReplace->user->notify(new CancelReplaceNotification($product, $productReplace));
        $product->user->notify(new CancelReplaceNotification($product, $productReplace));

        return redirect()->route('product.index')->with('cancel', 'Seu pedido de troca foi cancelado');
    }

    public function MarkAsRead(DatabaseNotification $notification) 
    {
        $notification->markAsRead();
        return redirect()->route('notifications');
    }

    public function AcceptReplace(DatabaseNotification $notification)
    {
        $product = Product::find($notification->data['product']['id']);
        $productReplace = Product::find($notification->data['productReplace']['id']);

        $auxId = $product->user_id;
        $product->user_id = $productReplace->user_id;
        $productReplace->user_id = $auxId;

        $product->replace = true;
        $productReplace->replace = true;
        
        $product->save();
        $productReplace->save();
        
        $product->user->notify(new AcceptReplaceNotification($product, $productReplace));
        

        $notification->markAsRead();

        return redirect()->route('product.index')->with('accept', "Troca Realizada!");
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
