<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use Illuminate\Http\Request;

class DepartemenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('departemen.index');
    }

    public function load_departemen_data(Request $request)
    {
        $search_value = $request->search['value'];

        $departemen = Departemen::query()->when($search_value, function ($query, $search_value) {
            return $query->where('nama_departemen', 'like', "%{$search_value}%")
                         ->orWhere('deskripsi', 'like', "%{$search_value}%");
        })
        ->latest();

        return datatables()->of($departemen)
            ->addColumn('increment', function () {
                static $rowNumber = 0;
                return ++$rowNumber;
            })
            ->addColumn('nama_departemen ', function ($item) {
                return $item->nama_departemen ?? '-';
            })
            ->addColumn('deskripsi', function ($item) {
                return isset($item->deskripsi) ? $item->deskripsi : '-';
            })
            ->addColumn('aksi', function ($item) {
                return '<button type="button" data-toggle="modal" data-target="#editRefDepartemenModal "
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
        $request->validate([
            'nama_departemen' => 'required',
            'deskripsi' => 'required',
        ],[
            'nama_departemen.required' => 'Nama Departemen harus diisi.',
            'deskripsi.required' => 'Deskripsi harus diisi.',
        ]);

        $departemen = Departemen::create($request->all());

        return response()->json($departemen);
    }

    /**
     * Display the specified resource.
     */
    public function show(Departemen $departemen)
    {
        return response()->json($departemen);
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
            'nama_departemen' => 'required',
            'deskripsi' => 'required',
        ],[
            'nama_departemen.required' => 'Nama Departemen harus diisi.',
            'deskripsi.required' => 'Deskripsi harus diisi.',
        ]);

        $departemen = Departemen::find($id);

        $departemen->update([
            'nama_departemen' => $request->nama_departemen,
            'deskripsi' => $request->deskripsi,
        ]);

        return response()->json($departemen);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $departemen = Departemen::find($id);
        $departemen->delete();

        return response()->json(['success' => 'Departemen deleted successfully']);
    }
}
