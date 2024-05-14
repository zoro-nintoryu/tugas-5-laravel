<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use stdClass;

class UserController extends Controller
{

public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();
            if ($user->hasRole('superadmin')) {
                return redirect()->intended('/admin/{user}/list-products');
            } else {
                return redirect()->intended('/products');
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:user,superadmin'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $role = Role::where('name', $request->role)->first();
        $user->assignRole($role);

        Auth::login($user);

        if ($user->hasRole('superadmin')) {
            return redirect('/admin/{user}/list-products');
        } else {
            return redirect('/products');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    





































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

    public function updateProduct(Request $request, User $user, Product $product)
    {
        if (!$request->filled('image')) {
            return redirect()->back()->with('error', 'Error. Field Gambar wajib diisi.');
        } else if (!$request->filled('nama')) {
            return redirect()->back()->with('error', 'Error. Field Nama wajib diisi.');
        } else if (!$request->filled('berat')) {
            return redirect()->back()->with('error', 'Error. Field Berat wajib diisi.');
        } else if (!$request->filled('harga')) {
            return redirect()->back()->with('error', 'Error. Field Harga wajib diisi.');
        } else if (!$request->filled('stok')) {
            return redirect()->back()->with('error', 'Error. Field Stok wajib diisi.');
        } else if ($request->kondisi === 0) {
            return redirect()->back()->with('error', 'Error. Field Kondisi wajib diisi.');
        } else if (!$request->filled('deskripsi')) {
            return redirect()->back()->with('error', 'Error. Field Deskripsi wajib diisi.');
        }

        if ($product->user_id === $user->id) {
            $product->name = $request->nama;
            $product->stock = $request->stok;
            $product->weight = $request->berat;
            $product->price = $request->harga;
            $product->description = $request->deskripsi;
            $product->condition = $request->kondisi;
            $product->image = $request->image;
            $product->save();
        }

        return redirect()->route('admin_page', ['user' => $user->id])->with('message', 'Berhasil update data');
    }

    public function deleteProduct(Request $request, User $user, Product $product)
    {
        if ($product->user_id === $user->id) {
            $product->delete();
        }
        return redirect()->back()->with('status', 'Berhasil menghapus data');
    }





    public function show(Request $request)
    {
        $varInsert = "Halo ini adalah variable yang disisipkan";
        $varOther = "Variable ini merupakan variable lain yang disisipkan";
        return view('show', compact('varInsert', 'varOther'));
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

    public function postRequest(Request $request, User $user)
    {
        if (!$request->filled('image')) {
            return redirect()->back()->with('error', 'Error. Field Gambar wajib diisi.');
        } else if (!$request->filled('nama')) {
            return redirect()->back()->with('error', 'Error. Field Nama wajib diisi.');
        } else if (!$request->filled('berat')) {
            return redirect()->back()->with('error', 'Error. Field Berat wajib diisi.');
        } else if (!$request->filled('harga')) {
            return redirect()->back()->with('error', 'Error. Field Harga wajib diisi.');
        } else if (!$request->filled('stok')) {
            return redirect()->back()->with('error', 'Error. Field Stok wajib diisi.');
        } else if ($request->kondisi === 0) {
            return redirect()->back()->with('error', 'Error. Field Kondisi wajib diisi.');
        } else if (!$request->filled('deskripsi')) {
            return redirect()->back()->with('error', 'Error. Field Deskripsi wajib diisi.');
        }

        Product::create([
            'user_id' => $user->id,
            'image' => $request->image,
            'name' => $request->nama,
            'weight' => $request->berat,
            'price' => $request->harga,
            'condition' => $request->kondisi,
            'stock' => $request->stok,
            'description' => $request->deskripsi,
        ]);

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
