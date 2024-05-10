<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostCreateRequest;
use App\Models\Post;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use stdClass;

class UserController extends Controller
{

    public function index(Request $request)
    {
        return view('index');
    }

    public function callSession(Request $request)
    {
        return redirect()->back()->with('status', 'Berhasil memanggil sesi');
    }



    public function getAdmin(User $user)
    {
        $products = Product::where('user_id', $user->id)->get();
        return view('admin_page', ['products' => $products, 'user' => $user]);
    }

    public function editProduct(Request $request, User $user, Product $product)
    {
        return view('edit_product', ['product' => $product, 'user' => $user]);
    }

    public function updateProduct(PostCreateRequest $request, User $user, )
    {
        
    Product::create([
            'user_id' => $user->id,
            'image' => $request->image,
            'nama' => $request->nama,
            'weight' => $request->berat,
            'price' => $request->harga,
            'condition' => $request->kondisi,
            'stock' => $request->stok,
            'description' => $request->deskripsi,
        ]);

        $imagePatch= $request->file('image')->store('profile_image','public');

       
        

        // return redirect()->route('get_product');
        return redirect()->route('admin_page', ['user' => $user->id]);

        return redirect()->route('admin_page', ['user' => $user->id])->with('message', 'Berhasil update data');

         
    }

    public function deleteProduct(Request $request, User $user, Product $product)
    {
        if ($product->user_id === $user->id) {
            $product->delete();
        }
        return redirect()->back()->with('status', 'Berhasil menghapus data');
    }





    











    public function getFormRequest()
    {
        return view('form_request');
    }

    public function sendRequest(Request $request)
    {
        dd($request->gender);
    }




    public function handleRequest(Request $request, User $user)
    {
        return view('handle_request', ['user' => $user]);
    }

    public function postRequest(PostCreateRequest $request, User $user)
    {
        Product::create([
            'user_id' => $user->id,
            'image' => $request->image,
            'nama' => $request->nama,
            'weight' => $request->berat,
            'price' => $request->harga,
            'condition' => $request->kondisi,
            'stock' => $request->stok,
            'description' => $request->deskripsi,
        ]);
        $imagePatch= $request->file('image')->store('profile_image','public');
        

        // return redirect()->route('get_product');
        return redirect()->route('admin_page', ['user' => $user->id]);
    }

    public function getProduct()
    {
        // $data = Product::all();
        $user = User::find(1);
        $data = $user->products;
        // return view('list_product')->with('products', $data);
        return view('products')->with('products', $data);
    }


    public function getProfile(Request $request, User $user)
    {
        $user = User::with('summarize')->find($user->id);
        // dd($user);
        return view('profile', ['user' => $user]);
    }
}
