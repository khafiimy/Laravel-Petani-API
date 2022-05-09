<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\KelompokTani;
use App\Models\Petani;
use Illuminate\Http\Request;

class PetaniController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $data = Petani::getPetani()->paginate(5);
        $data = Petani::getPetani()->get();
        return response()->json($data);
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
        $validasi = $request->validate([
            'nik' => 'required|numeric',
            'nama' => 'required',
            'alamat' => '',
            'telp' => 'required',
            'foto' => 'required|mimes:png,jpg',
            'id_kelompok_tani' => 'required',
            'status' => ''
        ]);

        try {
            $filename = time() . $request->file('foto')->getClientOriginalName();
            $path = $request->file('foto')->storeAs('uploads/petanis', $filename);
            $validasi['foto'] = $path;
            $response = Petani::create($validasi);
            return response()->json([
                'success' => 'true',
                'message' => 'success',
                'data' => $response
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Err',
                'erros' => $e->getMessage()
            ]);
        }
    }

    function kelompokTani()
    {
        $data = KelompokTani::all();
        return response()->json([
            'success' => true,
            'message' => 'Success',
            'data' => $data
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
        // $petani = Petani::getPetani()->find($id);
        $petani = Petani::find($id);

        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $petani
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
        $petani = Petani::find($id);
        return response()->json($petani);
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
        $validasi = $request->validate([
            'nik' => 'required|numeric',
            'nama' => 'required',
            'alamat' => '',
            'telp' => 'required',
            'foto' => 'required|mimes:png,jpg',
            'id_kelompok_tani' => 'required',
            'status' => ''
        ]);

        try {
            if ($request->file('foto')) {
                $filename = time() . $request->file('foto')->getClientOriginalName();
                $path = $request->file('foto')->storeAs('uploads/petanis', $filename);
                $validasi['foto'] = $path;
            }
            $response = Petani::find($id);
            $response->update($validasi);
            return response()->json([
                'success' => 'true',
                'message' => 'success',
                'data' => $response
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Err',
                'erros' => $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $petani = Petani::find($id);
            $petani->delete();
            return response()->json([
                'success' => true,
                'message' => 'Success'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Err',
                'errors' => $e->getMessage()
            ]);
        }
    }
}
