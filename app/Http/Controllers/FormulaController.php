<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Formula;
use App\TrialRevisionData;
use App\Material;
use App\SampleMaterial;
use App\FormulaDetail;
use App\Stock;
use App\SampleStock;
use App\Product;

class FormulaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $formula = Formula::orderBy('updated_at', 'desc')->get();
        $no = 1;
        $revision = TrialRevisionData::all();
        return view('produksi.formula.index', compact('formula','no','revision'));
    }

    public function hpp($id)
    {
        $product = Product::where('formula_id', $id)->first();

        $formula = FormulaDetail::where('formula_id', $id)->get();
        return view('produksi.formula.hpp', compact('formula','product'));
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
        
        try {
            $cek = DB::table('formulas')
                ->where('formula_num',$request->formula_num)
                ->count();
            
            if($cek > 0){
                return redirect()
                    ->route('formula.index')
                    ->with('error','Code Already Exists!!');
            }
            
            Formula::create($request->all());
          return redirect()
              ->route('formula.index')
              ->with('success', 'Successfully Formula Created.');

        }catch(Exception $e){
          return redirect()
              ->route('formula.index')
              ->with('error', $e->toString());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $formula = Formula::findOrFail($id);
            $material = Material::all();
            $sampleMaterial = SampleMaterial::all();
            $formula_view = FormulaDetail::where('formula_id', $id)->get();
            return view('produksi.formula.view', compact('formula', 'material', 'formula_view','sampleMaterial'));
        }catch(Exception $e){
          return redirect()
              ->route('formula.index')
              ->with('error', $e->toString());
        }
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
        try{
            Formula::whereId($id)
                ->update([
                    'formula_num' => $request->formula_num,
                    'trial_revision_data_id' => $request->trial_revision_data_id,
                ]);
            return redirect()
                ->route('formula.index')
                ->with('success', 'Successfully Updated.');
        }catch(Exception $e){
          return redirect()
              ->route('formula.index')
              ->with('error', $e->toString());
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
        try{
            Formula::whereId($id)->delete();
            return redirect()
                ->route('formula.index')
                ->with('success', 'Successfully Formula Delete.');
        }catch(Exception $e){
          return redirect()
              ->route('formula.index')
              ->with('error', $e->toString());
        }
    }

    public function storeView(Request $request)
    {
        if($request->source_material == '' || $request->material_id == '' || $request->quantity=='' || $request->weighing == ''){
            return redirect()
                ->route('formula.show',$request->input('formula_id'))
                ->with('error','invalid input!!');
        }
        $formulaDetail = FormulaDetail::where('formula_id', $request->formula_id)->get();
        $totalQty = 0;
        foreach($formulaDetail as $fd){
            $totalQty = $totalQty + $fd->quantity;
        }
        $totalQty = $request->quantity + $totalQty;
        if($totalQty <= 100){
            if($request->source_material){
                $stock = Stock::where('material_id', $request->material_id)->first();
                if (!empty($stock) && $stock->quantity >= $request->weighing) {
                    FormulaDetail::create($request->all());
                    Stock::where('material_id', $request->material_id)
                    ->update([
                        'quantity' => $stock->quantity - $request->weighing,
                    ]);
                }else{
                    return redirect()
                        ->route('formula.show',$request->input('formula_id'))
                        ->with('error','Quantity material not enough to create product!!');
                }
    
            }else{
                $stock = SampleStock::where('sample_material_id', $request->material_id)->first();
                if (!empty($stock) && $stock->quantity >= $request->weighing) {
                    FormulaDetail::create($request->all());
                    SampleStock::where('sample_material_id', $request->material_id)
                    ->update([
                        'quantity' => $stock->quantity - $request->weighing,
                    ]);
                }else{
                    return redirect()
                        ->route('formula.show',$request->input('formula_id'))
                        ->with('error','Quantity material not enough to create product!!');
                }
    
            }
    
        }else{
            return redirect()
                ->route('formula.show',$request->input('formula_id'))
                ->with('error','Maximal total quantity is 100');

        }

        
        return redirect()
            ->route('formula.show',$request->input('formula_id'))
            ->with('success','Successfully Formula Created');
    }
    public function destroyView($id)
    {
        try{
            $formula = FormulaDetail::findOrFail($id);
            FormulaDetail::whereId($id)->delete();
            return redirect()
                ->route('formula.show',$formula->formula_id)
                ->with('success','Successfully Formula Delete');
        }catch(Exception $e){
            return redirect()
                ->route('formula.show',$formula->formula_id)
                ->with('error', $e->toString());
        }
    }
}
