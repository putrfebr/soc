<?php

namespace App\Http\Controllers;

use App\Models\HistoryResi;
use App\Models\Resi;
use App\Models\Soc;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $const = [
        'viewFolder' => 'admin.tracking-claim',
        'route' => 'tracking-claim'
    ];
    public function index()
    {
        $data['title'] = 'Tracking Resi';
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

    public function upload(Request $request)
    {
        if ($request->hasFile('photos')) {
            $photo = $request->file('photos');
            $path = $photo->store('uploads/photos', 'public'); // simpan ke storage/app/public/uploads/photos

            return response()->json(['file_path' => '/storage/' . $path]);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }
    public function destroy(Request $request)
    {
        // Jika ada file_path (dari Dropzone)
        if ($request->has('file_path')) {
            $filePath = str_replace('/storage/', '', parse_url($request->file_path, PHP_URL_PATH));
            $fullPath = storage_path('app/public/' . ltrim($filePath, '/'));
    
            if (file_exists($fullPath)) {
                unlink($fullPath);
                return response()->json(['success' => true, 'message' => 'File fisik dihapus']);
            }
    
            return response()->json(['success' => false, 'message' => 'File tidak ditemukan'], 404);
        }
    
         // Dari database
            $request->validate([
                'id' => 'required|integer',
                'photo' => 'required|string'
            ]);

            $data = Soc::find($request->id);

            if (!$data) {
                return response()->json(['success' => false, 'message' => 'Data tidak ditemukan']);
            }

            $photos = json_decode($data->photos, true) ?? [];
            $photoUrl = $request->photo;

            // Cek eksistensi dan hapus dari storage
            $filePath = str_replace('/storage/', '', parse_url($photoUrl, PHP_URL_PATH));
            $fullPath = storage_path('app/public/' . ltrim($filePath, '/'));
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }

            // Hapus hanya 1 photo dari array
            $newPhotos = array_values(array_filter($photos, function ($item) use ($photoUrl) {
                return $item !== $photoUrl;
            }));

            $data->photos = json_encode($newPhotos);
            $data->save();

            return response()->json(['success' => true, 'message' => 'Foto dihapus dari DB dan storage']);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id=null)
    {
        //
        return $this->form($request,$id);
    }

    public function form(Request $request, $id = false, $only_view = false)
    {
        $code = $request->code;
        // dd($code);
        $data = Resi::where('code',$code)->first() ?? new Resi();
        if($code){
            if($data->id){
                $data->history_resi = HistoryResi::where('id_resi',$data->id)->orderBy('urutan','DESC')->get();
                // dd($data->history_resi);
                $data->cek_resi = false;
            }else{
                $data->cek_resi = true;
            }
        }else{
            $data->cek_resi = false;
        }
      
        
        $data->code = $code;
        $data->only_view = $only_view;
        $data->title = 'Tracking Resi';
        
        return view($this->const['viewFolder'] . '.form', ['data'=>$data], $this->const);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
}
