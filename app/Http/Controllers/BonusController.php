<?php

namespace App\Http\Controllers;

use App\Models\Bonus;
use Illuminate\Http\Request;

class BonusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('bonus.index');
    }

    public function load_bonus_data(Request $request)
    {
        $search_value = $request->search['value'];

        $bonus = Bonus::query()->when($search_value, function ($query, $search_value) {
            return $query->where('nama_bonus', 'like', "%{$search_value}%")
                         ->orWhere('jumlah', 'like', "%{$search_value}%");
        })
        ->latest();

        return datatables()->of($bonus)
            ->addColumn('increment', function () {
                static $rowNumber = 0;
                return ++$rowNumber;
            })
            ->addColumn('nama_bonus', function ($item) {
                return $item->nama_bonus ?? '-';
            })
            ->addColumn('jumlah_bonus', function ($item) {
                return isset($item->jumlah) ? 'Rp. ' . number_format($item->jumlah, 0, ',', '.') : '-';
            })
            ->addColumn('aksi', function ($item) {
                return '<button type="button" data-toggle="modal" data-target="#editRefBonusModal"
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

        $request->jumlah = str_replace(".", "", $request->jumlah);

        $request->validate([
            'nama_bonus' => 'required',
            'jumlah' => 'required',
        ],[
            'nama_bonus.required' => 'Nama Bonus harus diisi.',
            'jumlah.required' => 'Jumlah harus diisi.',
        ]);


        $bonus = Bonus::create($request->all());

        return response()->json($bonus);
    }

    /**
     * Display the specified resource.
     */
    public function show(Bonus $bonus)
    {
        return response()->json($bonus);
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
            'nama_bonus' => 'required',
            'jumlah' => 'required',
        ],[
            'nama_bonus.required' => 'Nama Bonus harus diisi.',
            'jumlah.required' => 'Jumlah harus diisi.',
        ]);

        $bonus = Bonus::find($id);

        $bonus->update([
            'nama_bonus' => $request->nama_bonus,
            'jumlah' => str_replace(".", "", $request->jumlah)
        ]);

        return response()->json($bonus);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $bonus = Bonus::find($id);
        $bonus->delete();

        return response()->json(['success' => 'Bonus deleted successfully']);
    }
}
