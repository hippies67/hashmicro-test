<?php

namespace App\Http\Controllers;

use App\Models\Bonus;
use App\Models\Departemen;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departemen = Departemen::all();
        $bonus = Bonus::all();

        return view('pegawai.index', compact('departemen', 'bonus'));
    }

    public function load_pegawai_data(Request $request)
    {

        $search_value = $request->search['value'];

        $pegawai = Pegawai::query()->when($search_value, function ($query, $search_value) {
            return $query->where(function ($query) use ($search_value) {
                $query->where('nama_pegawai', 'like', "%{$search_value}%")
                      ->orWhere('email', 'like', "%{$search_value}%")
                      ->orWhereHas('departemen', function ($query) use ($search_value) {
                          $query->where('nama_departemen', 'like', "%{$search_value}%");
                      });
            });
        })
        ->latest();

        return datatables()->of($pegawai)
            ->addColumn('increment', function () {
                static $rowNumber = 0;
                return ++$rowNumber;
            })
            ->addColumn('nama_pegawai', function ($item) {
                return $item->nama_pegawai ?? '-';
            })
            ->addColumn('email', function ($item) {
                return $item->email ?? '-';
            })
            ->addColumn('gajih', function ($item) {
                return 'Rp. ' . number_format($item->gajih, 0, ',', '.');
            })
            ->addColumn('departemen', function ($item) {
                return $item->departemen->nama_departemen ?? '-';
            })
            ->addColumn('total_gajih', function ($item) {
                return isset($item->gajih_bonus) ? 'Rp. ' . number_format($item->gajih_bonus, 0, ',', '.') : '-';
            })
            ->addColumn('aksi', function ($item) {
                return '<button type="button" data-toggle="modal" data-target="#editRefPegawaiModal "
                                        style="padding-bottom:2px;" data-ids="' . $item->id . '"
                                        onclick="setEditData(' . htmlspecialchars(json_encode($item), ENT_QUOTES, 'UTF-8') . ')"
                                        class="btn btn-warning btn-xs text-white d-block"><i class="fa fa-edit mr-1"></i>
                                        Edit</button>
                                    <button type="button"
                                        class="btn btn-danger btn-xs rounded waves-light waves-effect mt-2"
                                        onclick="deleteAlert(' . $item->id . ')"><i
                                            class="fa fa-trash-o mr-1"></i> Hapus
                                    </button>';
            })
            ->rawColumns(['aksi'])
            ->make(true);
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
        $request->gajih = str_replace(".", "", $request->gajih);

        $request->validate([
            'nama_pegawai' => 'required',
            'email' => 'required|email|unique:pegawai',
            'gajih' => 'required',
            'departemen_id' => 'required',
            'bonus_id' => 'nullable',
        ],[
            'nama_pegawai.required' => 'Nama Pegawai harus diisi.',
            'email.unique' => 'Email sudah ada.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Email harus valid.',
            'gajih.required' => 'Gajih harus diisi.',
            'departemen_id.required' => 'Departemen harus diisi.',
        ]);


        $pegawai = Pegawai::create($request->all());

        return response()->json($pegawai);
    }

    /**
     * Display the specified resource.
     */
    public function show(Pegawai $pegawai)
    {
        return response()->json($pegawai);
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
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_pegawai' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('pegawai')->ignore($id),
            ],
            'gajih' => 'required',
            'departemen_id' => 'required|integer',
            'bonus_id' => 'nullable|integer',
        ],[
            'nama_pegawai.required' => 'Nama Pegawai harus diisi.',
            'email.unique' => 'Email sudah ada.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Email harus valid.',
            'gajih.required' => 'Gajih harus diisi.',
            'departemen_id.required' => 'Departemen harus diisi.',
        ]);

        $pegawai = Pegawai::find($id);

        $pegawai->update([
            'nama_pegawai' => $request->nama_pegawai,
            'email' => $request->email,
            'gajih' => str_replace(".", "", $request->gajih),
            'departemen_id' => $request->departemen_id,
            'bonus_id' => $request->bonus_id,
        ]);

        return response()->json($pegawai);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pegawai = Pegawai::find($id);
        $pegawai->delete();

        return response()->json(['success' => 'Pegawai deleted successfully']);
    }
}
