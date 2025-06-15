<?php

namespace App\Http\Controllers;

use App\Libraries\MyLib;
use App\Models\Soc;
use App\Models\MobileService;
use App\Models\Resi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SocController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $const = [
        'viewFolder' => 'admin.soc',
        'route' => 'soc'
    ];
    public function index()
    {
        $data['soc'] = Soc::all();
        $data['title'] = 'SOC';
        return view($this->const['viewFolder'].'.index', $data, $this->const);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $id=null)
    {
        return $this->form($request);
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
        $id = $request->id;
            DB::transaction(function() use ($request,$id){
                $this->saveData($request,$id);
                session()->flash('success', "Data Berhasil Disimpan");
                // session(['resi_code' => $resi_code]);
            });
            
            return redirect()->route($this->const['route'].'.index');
        }catch(\Exception $e){
           
            DB::rollback();
            session()->flash('error', $e->getMessage());
            return redirect()->back();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id=null)
    {
        return $this->form($request, $id, true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id=null)
    {
        return $this->form($request, $id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Soc $Soc)
    {
        $this->saveData($request,$Soc->id);
        if ($Soc) {
            session()->flash('success', 'Data Berhasil Diupdate');
        } else {
            session()->flash('error', 'Data gagal Diupdate');
        }

        return redirect()->route($this->const['route'].'.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        $Soc = Soc::findOrFail($id);
        $Soc->delete();
        if ($Soc) {
            session()->flash('success', 'Data Berhasil Dihapus');
        } else {
            session()->flash('error', 'Data gagal Dihapus');
        }

        return redirect()->route($this->const['route'].'.index');
    }

    public function form(Request $request, $id = false, $only_view = false)
    {
        $data = $id ? Soc::findOrFail($id) : new Soc();
        $data->only_view = $only_view;
        $data->title = 'Form SOC';
        return view($this->const['viewFolder'] . '.form', ['data'=>$data], $this->const);
    }

    public function saveData($request, $id=false)
    {
        $this->validate($request, [
            'nama' => 'required',
            'divisi' => 'required',
            // 'deskripsi' => 'required',
            'tanggal_waktu' => 'required',
            'lokasi' => 'required',
            // 'golden_rules' => 'required',
            // 'unsafe_action' => 'required',
            // 'safe_behaviour' => 'required',
            // 'cuaca' => 'required',
        ]);
        // dd($request->potensi_risiko,$request->tindakan_mitigasi);
        $data = $id == true ? Soc::find($id) : new Soc();
        if(empty($request->id)){
            $data->code = Soc::genCode();
        }
        $data->nama = $request->nama;
        $data->divisi = $request->divisi;
        $data->deskripsi = $request->deskripsi;
        $data->tanggal_waktu = $request->tanggal_waktu;
        $data->lokasi = $request->lokasi;
        $data->golden_rules = $request->golden_rules;
        $data->unsafe_action = $request->unsafe_action;
        $data->safe_behaviour = $request->safe_behaviour;
        $data->cuaca = $request->cuaca;
        $data->suhu = $request->suhu;
        $data->freq = $request->freq;
        $data->risk = $request->potensi_risiko;
        $data->action = $request->tindakan_mitigasi;
        $data->photos = json_encode($request->uploaded_photos ?? []);
        $data->save();
       
       
        
        return $data;

    }

    public function generateMobileService($id)
    {
        MobileService::create([
            'id_nasabah' => $id,
            'status' => 1,
        ]);
    }
}
