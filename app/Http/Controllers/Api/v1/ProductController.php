<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        /**
         * Memanggil model Product lalu
         * mengembalikan response data dalam bentuk json
         */
        $products = Product::get();

        if ($products->isEmpty()) {
            /**
             * Jika data pada tabel product masih kosong
             * Tampilkan response json berikut.
             */
            return response()->json([
                'status' => Response::HTTP_NO_CONTENT,
                'message' => "Produk masih kosong"
            ]);
        } else {
            /**
             * Jika tidak maka
             * Tampilkan response json berikut.
             */
            return response()->json([
                'status' => Response::HTTP_OK,
                'message' => "List Produk",
                'products' => $products
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /**
         * Proses validasi
         * Jika validasi gagal tampilkan pesan error
         * Jika tidak jalankan proses create/store data
         * Dan tampilkan response dalam bentuk json
         */
        $request->validate([
            'name' => 'required|min:5',
            'price' => 'required',
            'description' => 'min:5'
        ]);

        Product::create($request->all());

        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => "Stored Success"
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        /**
         * Panggil model product lalu cari id yng diinputkan
         */
        $product = Product::find($id);

        /**
         * Jika Data tidak ada tampilkan 
         * Response berikut
         */
        if (is_null($product)) {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => "Product Not Found"
            ]);
        }

        /**
         * Jika Data ada tampilkan 
         * Response berikut
         */
        return response()->json([
            'status' => Response::HTTP_OK,
            'product' => $product,
            'message' => "Product - " . $product->id,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        /**
         * Proses validasi
         * Jika validasi gagal tampilkan pesan error
         * Jika tidak jalankan proses update data
         * Dan tampilkan response dalam bentuk json
         */
        $request->validate([
            'name' => 'required|min:5',
            'price' => 'required',
            'description' => 'min:5'
        ]);

        $products = Product::find($id);
        $products->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price
        ]);

        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Data Updated',
            'products' => $products
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        /**
         * Panggil model product & cari data yang akan 
         * dihapus lalu
         * tampilkan response dalam bentuk json
         */
        $products = Product::find($id);
        $products->delete();
        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Delete Successfull'
        ]);
    }
}