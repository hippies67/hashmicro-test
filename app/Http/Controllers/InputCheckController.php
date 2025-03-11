<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InputCheckController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('input_check.index');
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
        $validator = Validator::make($request->all(), [
            'input_1' => 'required',
            'input_2' => 'required',
        ], [
            'input_1.required' => 'Input 1 harus di isi.',
            'input_2.required' => 'Input 2 harus di isi.',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'data' => $validator->errors()
            ], 400);
        }

        if($request->type == '1'){
            $input1 = strtolower($request->input_1);
            $input2 = strtolower($request->input_2);
        }else{
            $input1 = $request->input_1;
            $input2 = $request->input_2;
        }

        $count = 0;
        $sameChar = [];
        $length = strlen($input1);

        for($i=0; $i<$length; $i++) {
            if(strpos($input2, $input1[$i]) !== false) {
                if(in_array($input1[$i], $sameChar)){
                    continue;
                }
                $sameChar[] = $input1[$i];
                $count++;
            }
        }

        $percentage = $length > 0 ? ($count / $length) * 100 : 0;
        $formatted_percentage = floor($percentage * 100) / 100; // Avoid rounding by truncating

        return response()->json([
            'status' => true,
            'data' => [
                'char' => $sameChar,
                'result' => $formatted_percentage
            ]
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
