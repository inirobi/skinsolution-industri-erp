<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TrialRevisionData;
use App\TrialData;
use Illuminate\Support\Facades\DB;

class TrialRevisionDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trialdata = TrialData::all();
        $trial = TrialRevisionData::orderBy('id', 'desc')->get();
        $no = 1;
        return view('produksi.trial.revisi.index', compact('trial','no','trialdata'));
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
            $cek = DB::table('trial_revision_datas')
                ->where('revision_num',$request->revision_num)
                ->count();
                
                if($cek > 0){
                    return redirect()
                        ->route('trial_revisi.index')
                        ->with('error','Code Already Exists!!');
                }
                
                TrialRevisionData::create([
                    'revision_num' => $request->revision_num,
                    'trial_data_id' => $request->trial_data_id,
                    'created_from' => $request->created_from,
                    'created_to' => $request->created_to,
                    'prosedur' => $request->prosedur,
                    'keterangan' => $request->keterangan,
                ]);
            return redirect()
                ->route('trial_revisi.index')
                ->with('success','Successfully Trial Revision Added');
        }catch(Exception $e){
            return redirect()
                ->route('trial_revisi.index')
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
            TrialRevisionData::whereId($id)
            ->update([
                'revision_num' => $request->revision_num,
                'trial_data_id' => $request->trial_data_id,
                'created_from' => $request->created_from,
                'created_to' => $request->created_to,
                'prosedur' => $request->prosedur,
                'keterangan' => $request->keterangan,
            ]);
            return redirect()
                ->route('trial_revisi.index')
                ->with('success','Successfully Trial Revision Updated');
        }catch(Exception $e){
            return redirect()
                ->route('trial_revisi.index')
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
            TrialRevisionData::whereId($id)->delete();
            return redirect()
                ->route('trial_revisi.index')
                ->with('success','Successfully Deleted');
        }catch(Exception $e){
            return redirect()
                ->route('trial_revisi.index')
                ->with('error', $e->toString());
        }
    }
}
