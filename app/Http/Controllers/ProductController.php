<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Notifications\ProductReplaceNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $product = new Product();
        return view('admin.products.create', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $product = new Product();
    

        $product->name = $request->name;
        $product->description = $request->description;
        $product->preparationTime = $request->preparationTime;
        $product->preparationMode = $request->preparationMode;
        $product->value = $request->value;
        $product->replace = false;
        $product->user_id = $request->user_id;
        
        if($request->hasFile('photo') && $request->file('photo')->isValid()) {

            $requestImage = $request->photo;
            $fileName = $request->file('photo')->getClientOriginalName();
            $extesion = $request->file('photo')->getClientOriginalExtension();
            $fileNameToStore= pathinfo($fileName, PATHINFO_FILENAME) . '_' . time() . '.' . $extesion;
            $request->photo->move(public_path('img/products'), $fileNameToStore);

            $path = "img/products/" . $fileNameToStore;

            $product->photo = $path;

        }
 
        $product->save();
        return redirect()->route('product.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('admin.products.show',compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function ProductList(Product $product)
    {
        $userLogged = new User();
        $productsAuth = new Product();
        $productsAuth = $userLogged->find(Auth::user()->id)->products->all();

        return view('admin.products.product_list',compact('productsAuth','product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($idProduct, $idProductReplace)
    {
        $product = Product::find($idProduct);
        $productReplace = Product::find($idProductReplace);

        $product->user->notify(new ProductReplaceNotification($product, $productReplace));

        // $auxId = $product->user_id;
        // $product->user_id = $productReplace->user_id;
        // $productReplace->user_id = $auxId;

        // $product->save();
        // $productReplace->save();

        return redirect()->route('product.index')->with('message',"Mensagem enviada para o usuário, espere o mesmo aceitar o seu pedido de troca entre os peodutos!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
