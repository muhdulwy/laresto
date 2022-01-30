<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MenuController extends Controller
{
    public function index()
    {
        $menu = Menu::all();

        if($menu->count() < 1){
            return response(
                [
                    "status" => "error",
                    "message" => "Data Menu Kosong"
                ], 400);
        }

        return response()->json($menu, 200);
    }

    
    public function store(Request $request){
        $validator = $this->__validate($request);

        if($validator->fails()){
            return response()->json([
                "status" => "error",
                "message" => "Error Validation",
                "validation" => $validator->errors()
            ], 400);
        }

        Menu::create([
            "nama" => $request->nama,
            "deskripsi" => $request->deskripsi,
            "kategori" => $request->kategori,
            "harga" => $request->harga,
            "foto" => $request->foto,
        ]);

        return response()->json([
            "status" => "success",
            "message" => "Data Berhasil di Tambah"
        ], 200);
    }

    public function show(Menu $menu)
    {
        $menu = Menu::find($menu);

        if($menu->count() < 1){
            return response(
                [
                    "status" => "error",
                    "message" => "Data Menu Kosong"
                ], 400);
        }

        return response()->json($menu, 200);
    }

    public function update(Request $request, Menu $menu){
        $validator = $this->__validate($request);

        if($validator->fails()){
            return response()->json([
                "status" => "error",
                "message" => "Error Validation",
                "validation" => $validator->errors()
            ], 400);
        }

        $menu->update([
            "nama" => $request->nama,
            "deskripsi" => $request->deskripsi,
            "kategori" => $request->kategori,
            "harga" => $request->harga,
            "foto" => $request->foto,
        ]);

        return response()->json([
            "status" => "success",
            "message" => "Data Berhasil di Edit"
        ], 200);
    }

    public function destroy(Menu $menu){
        $menu->delete();

        return response()->json([
            "status" => "success",
            "message" => "Data Berhasil di Hapus"
        ], 200);
    }

    public function uploadImage(Request $request){
        $validator = Validator::make($request->all(), [
            'image' => 'required|image:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        if ($validator->fails()) {
            return response($validator->message()->first(),  'error', 500);
        }
        $uploadFolder = 'menu';
        $image = $request->file('foto');
        $image_uploaded_path = $image->store($uploadFolder, 'public');
        $uploadedImageResponse = array(
            "image_name" => basename($image_uploaded_path),
            "image_url" => Storage::disk('public')->url($image_uploaded_path),
            "mime" => $image->getClientMimeType()
        );
        return response('File Uploaded Successfully', 'success', 200, $uploadedImageResponse);
    }

    private function __validate($request){
        $data = $request->all();
        $rules = [
            'nama' => 'required',
            'deskripsi' => 'required',
            'kategori' => 'required',
            'harga' => 'required',
            'foto' => 'required',
        
        ];

        return Validator::make($data, $rules);
    }
}

