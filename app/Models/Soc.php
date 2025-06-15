<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\SoftDeletes;

class Soc extends Model
{
    use HasFactory, Userstamps,SoftDeletes;
    
    protected $guarded = [''];
    protected $table = 'soc';

    const CUACA = [ '0' => 'Cerah','1' => 'Mendung' ,'2' => 'Hujan', '3' => 'Hujan Lebat', '4' => 'Angin Kencang'];
    public static function genCode()
    {
        $tahun = date("Y");
        $bulan = date("m");
        $prefix = "SOC".substr($tahun, 2, 2).$bulan;
        $lastCode = self::whereMonth('created_at', $bulan)->whereYear('created_at', $tahun)->orderBy("id","desc")->first();
        // dd($lastCode);
        $lastCode = $lastCode ? substr($lastCode->code, 6, 5) : 0;
        return $prefix.str_pad(($lastCode+1), 5, 0, STR_PAD_LEFT);
    }
    // public function resi()
    // {
    //     return $this->hasOne(Resi::class, 'id_registrasi_klaim');
    // }

    // public function MobileService(){
    //     return $this->hasOne(MobileService::class, 'id_nasabah');
    // }
    // public function KeuanganUmum(){
    //     return $this->hasOne(KeuanganUmum::class, 'id_nasabah');
    // }
}
