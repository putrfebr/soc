<?php

namespace App\Http\Controllers;

use App\Models\Soc;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['title'] = 'Home'; 
        return view('admin.home.index',$data);
    }

    public function dashboard(){
        $data['title'] = 'Dashboard';
        return view('admin.dashboard.index',$data);
    }


    public function getRiskChartData(Request $request)
    {
        $query = Soc::whereNull('deleted_at')->whereNotNull('risk');

        if ($request->filled('divisi')) {
            $query->where('divisi', $request->divisi);
        }

        if ($request->filled('start_date')) {
            $query->whereDate('tanggal_waktu', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('tanggal_waktu', '<=', $request->end_date);
        }

        $riskData = $query->select('risk', DB::raw('count(*) as total'))
                        ->groupBy('risk')
                        ->pluck('total', 'risk');

        return response()->json([
            'labels' => $riskData->keys(),
            'series' => $riskData->values()
        ]);
    }


    // Endpoint untuk photos dan topRisk
public function getTopRiskPhotos(Request $request)
{
    $query = Soc::whereNull('deleted_at')->whereNotNull('risk');

    if ($request->filled('divisi')) {
        $query->where('divisi', $request->divisi);
    }

    if ($request->filled('start_date')) {
        $query->whereDate('tanggal_waktu', '>=', $request->start_date);
    }

    if ($request->filled('end_date')) {
        $query->whereDate('tanggal_waktu', '<=', $request->end_date);
    }

    // Cari risk terbanyak
    $riskData = $query->select('risk', DB::raw('count(*) as total'))
                      ->groupBy('risk')
                      ->orderByDesc('total')
                      ->get();
    $actionData = $query->select('action', DB::raw('count(*) as total'))
                      ->where('risk',$riskData->first()?->risk)
                      ->groupBy('action')
                      ->orderByDesc('total')
                      ->get();
    $topRisk = $riskData->first()?->risk;
    $topAction = $actionData->first()?->action;
    // dd($topAction);

    $photos = [];
    if ($topRisk) {
        // Ambil 3 record terbaru berdasarkan risk terbanyak
        $recordsWithTopRisk = Soc::where('risk', $topRisk)
                                ->whereNull('deleted_at')
                                ->orderByDesc('created_at')
                                ->take(3)
                                ->get();

        foreach ($recordsWithTopRisk as $record) {
            if ($record->photos) {
                $photoArray = json_decode($record->photos, true);
                if (is_array($photoArray) && count($photoArray) > 0) {
                    // Ambil foto pertama dari json photos tiap record
                    $photos[] = $photoArray[0];
                }
            }
        }
    }


    return response()->json([
        'topRisk' => $topRisk,
        'topAction' => $topAction,

        'photos' => $photos,
    ]);
}

}
