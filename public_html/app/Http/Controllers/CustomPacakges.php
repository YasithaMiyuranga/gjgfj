<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use DB;
use App\Models\Item;
use App\Models\CartItem;
use Illuminate\Http\Request;
use App\Models\CustomerPackage;
use App\Models\CustomerPackageItem;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CustomPacakges extends Controller
{
    public function addToCart(Request $request)
    {
        $item = Item::find($request->product_id);
        if (!$item) {
            return redirect()->back()->with('error', 'Product does not exist.');
        }
    
        $productId = $request->product_id;
        $quantity = $request->quantity;
        $item_price = $item->rent_price;
    
        // Get the logged-in user
        $user = auth()->user();
        $cart = Cart::firstOrCreate(['user_id' => $user->id]);
    
        // Check if the product already exists in the cart
        $cartItem = CartItem::where('cart_id', $cart->cart_id)
                             ->where('item_id', $productId)
                             ->first();
        if ($cartItem) {
            // Update the quantity and price
             $cartItem->update([
                'quantity' => $cartItem->quantity + $quantity,
            ]);

        } else {
            // Add new item to the cart
            CartItem::create([
                'cart_id' => $cart->cart_id,
                'item_id' => $productId,
                'quantity' => $quantity,
                'price' => $item_price 
            ]);

        }

        // Get the updated cart items images 
        $cartItems = CartItem::where('cart_id', $cart->cart_id)->get();
        foreach ($cartItems as $cartItem) {
            $item = Item::find($cartItem->item_id);
            $cartItem->image = $item->image;
        }

        // Update session with all cart items
        Session::put('cart_'. $user->id, $cartItems);
    
        return redirect()->back()->with('success', 'Item added to cart successfully!');
    }
    
    public function showCart()
    {
        $cart = Session::get('cart_' . auth()->user()->id, []);
        return view('Cart.cart_view', compact('cart'));
    }
    public function updateCart(Request $request)
    {
        // dd($request->all());
       $productIds = $request->input('product_id');
       $quantities = $request->input('quantity');
       $cartItems = Session::get('cart_' . auth()->user()->id, []);
       foreach ($cartItems as $key => $cartItem) {
           if (in_array($cartItem['item_id'], $productIds)) {
               $index = array_search($cartItem['item_id'], $productIds);
               $cartItems[$key]['quantity'] = $quantities[$index];
           }
       }
       Session::put('cart_' . auth()->user()->id, $cartItems);
       // Now update cart items table
       $cartId = Cart::where('user_id', auth()->user()->id)->value('cart_id');
       // Update the cart items table
       foreach ($cartItems as $cartItem) {
           $item = Item::find($cartItem['item_id']);
           $price = $item->rent_price;
           $quantity = $cartItem['quantity'];
           CartItem::where('cart_id', $cartId)
                   ->where('item_id', $cartItem['item_id'])
                   ->update([
                       'quantity' => $quantity,
                       'price' => $price,
                   ]);
       }
       return redirect()->back()->with('success', 'Cart updated successfully!');
    }
    public function removeItem($id)
    {
        // Item id
        $productId = $id;
        $userId = auth()->user()->id;
        
        // Get the user's cart from session
        $cartItems = Session::get('cart_' . $userId, collect());
    
        // Check if the cart contains the product
        $cartItem = $cartItems->firstWhere('item_id', $productId);
    
        if ($cartItem) {
            // Remove the cart item from the database
            $cartId = Cart::where('user_id', $userId)->value('cart_id');
            CartItem::where('item_id', $productId)
                    ->where('cart_id', $cartId)
                    ->delete();
    
            // Remove the item from the session collection
            $updatedCart = $cartItems->reject(function ($item) use ($productId) {
                return $item->item_id == $productId;
            });
    
            // Update session with the modified cart
            Session::put('cart_' . $userId, $updatedCart);
    
            return redirect()->back()->with('success', 'Product removed from cart successfully!');
        }
        else{

            return redirect()->back()->with('error', 'Product not found in cart.');
        }
    
    }
    
    public function clearCart() //function to clear cart
    {
        Session::forget('cart');
        //delete cart from database
        Cart::where('user_id', auth()->user()->id)->delete();
        return redirect()->back()->with('success', 'Cart cleared successfully!');
    }
    public function cp_complate()
    {
        $cart = Session::get('cart_'. auth()->user()->id, []);
        return view('Custom_Packages.details_add', compact('cart'));
    }

    protected function validateCustomPackage(Request $request)
    {
        $customMessages = [
            'customer_name_txt.required' => 'The name field is required.',
            'mobile_no_txt.required' => 'The mobile number field is required.',
            'location_txt.required' => 'The location field is required.',
            'category_txt.required' => 'The category field is required.',
            'StartDatetime.required' => 'The start date and time are required.',
            'EndDatetime.required' => 'The end date and time are required.',
        ];

        $rules = [
            'customer_name_txt' => 'required|max:255',
            'mobile_no_txt' => 'required|numeric',
            'location_txt' => 'required|max:255',
            'category_txt' => 'required',
            'StartDatetime' => 'required|date',
            'EndDatetime' => 'required|date|after_or_equal:StartDatetime',

        ];
        return Validator::make($request->all(), $rules, $customMessages);
    }
    public function cp_complate_store(Request $request)
    {
        
        $validator = $this->validateCustomPackage($request);
        
        if ($validator->fails()) {
            return redirect()->back()
            ->withErrors($validator)
            ->withInput();
        }
      
        DB::beginTransaction();
        try {
                $cart = Session::get('cart_'.auth()->user()->id, []);
               
                $totalPrice = 0;
                // Find the total price of the cart
                foreach ($cart as $product) {
                    $totalPrice += $product['price'] * $product['quantity'];
                }
                
        
                $customerpacakges = new CustomerPackage();
                $customerpacakges->customer_name = $request->customer_name_txt;
                $customerpacakges->mobile_no = $request->mobile_no_txt;
                $customerpacakges->location = $request->location_txt;
                $customerpacakges->category = $request->category_txt;
                $customerpacakges->starttime = $request->StartDatetime;
                $customerpacakges->endtime = $request->EndDatetime;
                $customerpacakges->price = $totalPrice;
                $customerpacakges->detail = $request->details_txt;
                $customerpacakges->status = 'Pending';
                $customerpacakges->type = 'Event';
                
                $customerpacakges->save(); 
                
                if (!$customerpacakges->wasRecentlyCreated) {
                    return redirect()->back()->withErrors(['error' => 'Failed to save the package.'])->withInput();
                }
                
                $customerName = $request->customer_name_txt;
                $lastPackage = CustomerPackage::where('customer_name', $customerName)
                    ->orderBy('package_id', 'desc')
                    ->first(); 
                
                if ($lastPackage) {
                    $packageid = $lastPackage->package_id;
                } else {
                    return redirect()->back()->withErrors(['error' => 'Package not found.'])->withInput();
                }           
                
                $cart = Session::get('cart_'. auth()->user()->id, []);
                  
                if (!empty($cart)) {
                    foreach ($cart as $productId => $item) {
                        CustomerPackageItem::create([
                            'package_id' => $packageid,
                            'image' => $item['image'],
                            'item_id' => $item['item_id'],
                            'item_name' => Item::where('item_id', $item['item_id'])->value('item_name'),
                            'quantity' => $item['quantity'],
                            'price' => $item['price'],
                            'amount' => $item['quantity'] * $item['price'],
                        ]);
                    }
                     // Delete cart 
                      Cart::where('user_id', auth()->user()->id)->delete();
                    Session::forget('cart_'.auth()->user()->id);
                   
                }

                DB::commit();
                return redirect()->route('custom.package.contactus', ['id' => $packageid]);
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->withErrors(['error' => 'Failed to save the package.'])->withInput();
            }
  
    }

    public function cp_contactus($id)
    {
        
        $customerpacakge= CustomerPackage::where('package_id', $id)->with('customerPackageItem')->first();
        return view('Custom_Packages.package_complate', ['customerpacakge' => $customerpacakge],['downloadable' => true]);
    }


}
