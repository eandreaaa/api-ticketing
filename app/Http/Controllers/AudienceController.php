<?php

namespace App\Http\Controllers;

use App\Helpers\ApiFormatter;
use App\Models\Audience;
use Exception;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AudienceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search_nama;
        $limit = $request->limit;
        $audiences = Audience::where('nama', 'LIKE', '%'.$search.'%')->limit($limit)->get();

        if ($audiences) {
            return ApiFormatter::createAPI(200, 'success', $audiences);
        } else {
            return ApiFormatter::createAPI(400, 'failed');
        }
        
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
        try {
            $request->validate([
                'nama' => 'required|min:3',
                'email' => 'required|email:dns',
                'telp' => 'required|numeric',
                'tiket' => 'required|numeric',
                'jadwal' => 'required',
                'cat' => 'required',
            ]);

            $audience = Audience::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'telp' => $request->telp,
                'tiket' => $request->tiket,
                'jadwal' => Carbon::parse($request->jadwal)->format('Y-m-d'),
                'cat' => $request->cat,
            ]);

            $inputData = Audience::where('id',$audience->id)->first();

            if ($inputData) {
                return ApiFormatter::createAPI(200, 'success', $audience);
            } else {
                return ApiFormatter::createAPI(400, 'failed');
            }
            
        } catch (Exception $error) {
            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
    }

    public function createToken()
    {
        return csrf_token();
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $audience = Audience::find($id);

            if ($audience) {
                return ApiFormatter::createAPI(200, 'success', $audience);
            } else {
                return ApiFormatter::createAPI(400, 'failed');
            }
            
        } catch (Exception $error) {
            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Audience $audience)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'nama' => 'required|min:3',
                'email' => 'required|email:dns',
                'telp' => 'required|numeric',
                'tiket' => 'required|numeric',
                'jadwal' => 'required',
                'cat' => 'required',
            ]);

            $audience = Audience::find($id);

            $audience->update([
                'nama' => $request->nama,
                'email' => $request->email,
                'telp' => $request->telp,
                'tiket' => $request->tiket,
                'jadwal' => Carbon::parse($request->jadwal)->format('Y-m-d'),
                'cat' => $request->cat,
            ]);

            $dataBaru = Audience::where('id', $audience->id)->first();

            if ($dataBaru) {
                return ApiFormatter::createAPI(200, 'success', $dataBaru);
            } else {
                return ApiFormatter::createAPI(400, 'failed');
            }
            
        } catch (Exception $error) {
            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $audience = Audience::find($id);
            $cekHasil = $audience->delete();

            if ($cekHasil) {
                return ApiFormatter::createAPI(200, 'success', 'Pembelian tiket dibatalkan');
            } else {
                return ApiFormatter::createAPI(400, 'failed');
            }
            
        } catch (Exception $error) {
            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
    }

    public function trash()
    {
        try {
            $audiences = Audience::onlyTrashed()->get();

            if ($audiences) {
                return ApiFormatter::createAPI(200, 'success', $audiences);
            } else {
                return ApiFormatter::createAPI(400, 'failed');
            }
            
        } catch (Exception $error) {
            return ApiFormatter::createAPI(400, ' error', $error->getMessage());
        }
    }

    public function restore($id)
    {
        try {
            $audience = Audience::onlyTrashed()->where('id', $id);
            $audience->restore();
            $dataBalik = $audience->forceDelete();

            if ($dataBalik) {
                return ApiFormatter::createAPI(200, 'success', $dataBalik);
            } else {
                return ApiFormatter::createAPI(400, 'failed');
            }
            
        } catch (Exception $error) {
            return ApiFormatter::createAPI(400, ' error', $error->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $audience = Audience::onlyTrashed()->where('id', $id);
            $hapus = $audience->forceDelete();

            if ($hapus) {
                return ApiFormatter::createAPI(200, 'success', 'Pembelian dibatalkan');
            } else {
                return ApiFormatter::createAPI(400, 'failed');
            }
            
        } catch (Exception $error) {
            return ApiFormatter::createAPI(400, ' error', $error->getMessage());
        }
    }
}
