<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TrialData;
use App\PoCustomer;
use Illuminate\Support\Facades\DB;
class TrialDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trial = TrialData::orderBy('id', 'desc')->get();
        $pocustomer = PoCustomer::all();
        $no = 1;
        return view('produksi.trial.data.index', compact('trial','no','pocustomer'));
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
        try{
            $cek = DB::table('trial_datas')
            ->where('trial_num',$request->trial_num)
            ->count();
            
            if($cek > 0){
                return redirect()
                    ->route('trial.index')
                    ->with('error','Code Already Exists!!');
            }
            
            TrialData::create($request->all());
            return redirect()
                ->route('trial.index')
                ->with('success','Successfully Trial Data Added');
        }catch(Exception $e){
            return redirect()
                ->route('trial.index')
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
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
            TrialData::whereId($id)
            ->update([
                'trial_num' => $request->trial_num,
                'po_customer_id' => $request->po_customer_id,
                'po_customer_detail_id' => $request->po_customer_detail_id,
                'willingness' => $request->willingness,
                'type' => $request->type,
                'keterangan' => $request->keterangan,
            ]);
            return redirect()
                ->route('trial.index')
                ->with('success','Successfully Trial Data Updated');
        }catch(Exception $e){
            return redirect()
                ->route('trial.index')
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
            TrialData::whereId($id)->delete();
            return redirect()
                ->route('trial.index')
                ->with('success','Successfully Deleted');
        }catch(Exception $e){
            return redirect()
                ->route('trial.index')
                ->with('error', $e->toString());
        }
    }
}
