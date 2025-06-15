<?php
namespace App\Libraries;

use Illuminate\Support\Facades\DB;

use Auth;
use DateTime;
use Exception;
use \Carbon\Carbon;
use Akaunting\Money\Currency;
use Akaunting\Money\Money;
use App\Models\HistoryResi;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

class MyLib {

  protected $datas;
    /**
     * @param int $user_id User-id
     *
     * @return string
     */
    public function validateDecimal($s_value) {
      $regex = '/^[+\-]?(?:\d+(?:\.\d*)?|\.\d+)$/';
      return preg_match($regex, trim($s_value));
    }
    public function validateTime($obj)
    {
      return preg_match("/^(?:2[0-3]|[01][0-9]):[0-5][0-9]$/", $obj);
    }

    public static function validateDateFormat($date, $format = 'Y-m-d')
    {
      // if (preg_match('/^(19|20)\d{2}\-(0[1-9]|1[0-2])\-(0[1-9]|[12][0-9]|3[01])$/',$date)) {
      //   return true;
      // } else {
      //   return false;
      // }

      try{

        if($date == ''){
          return true;
        }
        $dt = Carbon::createFromFormat($format, $date);
        return $dt && $dt->format($format) === $date;
      }catch(\Exception $e){
        return false;
      }
    }
    public static function checkAktifData($obj) {
    	if($obj == "1"){
    		$ret = '<span class="badge bg-green">Aktif</span>';
    	}else{
    		$ret = '<span class="badge bg-red">Non Aktif</span>';
    	}

    	return $ret;
    }

    public static function vDate($obj, $format="date", $fromFormat='indo-date', $formatBack=null){
      if($obj == '' || $obj == '-'){
        return '';
        // return '1970-01-01 01:00:00';
      }
      // dd(self::validateDateFormat($obj, "Y-m-d H:i:s"));
      if(self::validateDateFormat($obj, 'Y-m-d')){
        // dd('aaa');
        $fromFormat = 'sql-date';
      }else if(self::validateDateFormat($obj, "Y-m-d H:i:s")){
        // dd(self::validateDateFormat($obj, "Y-m-d H:i:s"));
        $fromFormat = 'sql-datetime';
      }else{
        // $fromFormat = 'indo-datetime';
      }

      // dd($fromFormat);

      if($format == "datetime"){
        $vFormat = "d/m/Y H:i:s";
      }else if($format == "date"){
        $vFormat = "d/m/Y";
      }else{
        $vFormat = $format;
      }
      // dd($fromFormat);
      if($fromFormat == 'indo-datetime'){
        $vFromFormat = "d/m/Y H:i:s";
        $vFormatBack = 'Y-m-d H:i:s';
      }else if($fromFormat == 'indo-date'){
        $vFromFormat = "d/m/Y";
        $vFormatBack = 'Y-m-d';
      }else if($fromFormat == 'sql-date'){
        $vFromFormat = "Y-m-d";
        $vFormatBack = 'Y-m-d';
      }else if($fromFormat == 'sql-datetime'){
        $vFromFormat = "Y-m-d H:i:s";
        $vFormatBack = 'Y-m-d H:i:s';
      }else{
        $vFromFormat = $fromFormat;
        $vFormatBack = $formatBack;
      }


      // if($formatBack==null){
      //   $vFromFormat = 'Y-m-d';
      //   $vFormatBack = $vFromFormat;
      // }

      // dd($vFromFormat.' = '.$vFormatBack);
      $obj = Carbon::createFromFormat($vFromFormat, $obj)->format($vFormatBack);
      // dd($obj);
      $tgl = Carbon::parse($obj, "Asia/Jakarta")->format($vFormat);
      return $tgl;
    }

    public static function whatDay($obj, $indo=false)
    {
      if(!strtotime($obj)){
        return $obj;
      }
      // dd($obj);
      // return date("l", $obj);
      // $dayName = DateTime::createFromFormat('Y-m-d', strtotime($obj));
      // $dayName = $dayName->format('l');
      $dayName = date("l", strtotime($obj));

      if($indo){
        // dd($this->enIndo(strtolower($dayName)));
        return self::enIndo(strtolower($dayName));
      }

      return $dayName;
    }

    public function enIndo($obj)
    {
      $data = [
        "sunday" => "minggu",
        "monday" => "senin",
        "tuesday" => "selasa",
        "wednesday" => "rabu",
        "thursday" => "kamis",
        "friday" => "jumat",
        "saturday" => "sabtu"
      ];

      return $data[$obj]??'';
    }

    public static function eDiffDate($obj, $obj2)
    {
      $seconds = strtotime($obj2) - strtotime($obj);

      $years    = floor($seconds / (365*86400));
      $months  = floor($seconds / (30*86400));
      $days    = floor($seconds / 86400);
      $hours   = floor(($seconds - ($days * 86400)) / 3600);
      $minutes = floor(($seconds - ($days * 86400) - ($hours * 3600))/60);
      $seconds = floor(($seconds - ($days * 86400) - ($hours * 3600) - ($minutes*60)));

      $compactHours = (int)$hours.'.'.(int)$minutes;
      return ["years"=>$years, "months" => $months, "days" => ($days+1), "hours" => $hours,  "minutes" => $minutes,  "seconds" => $seconds, "compactTime" => $compactHours];
    }

    public static function diffInYear($date){
      $diffYears = \Carbon\Carbon::now()->diffInYears($date);

      return $diffYears;
    }

    public static function diffDate($obj, $obj2, $only = "", $decideHuman = false)
    {
      $diff = self::eDiffDate($obj, $obj2);
      $txt = "";

      $years    = $diff['years'];
      $months    = $diff['months'];
      $days    = $diff['days'];
      $hours   = $diff['hours'];
      $minutes = $diff['minutes'];
      $seconds = $diff['seconds'];

      if($decideHuman) return self::decideHumanDate($diff);

      if($only != ""){
        if($only == "day"){ $txt = (int) $diff['days']; }
        else if($only == "hour"){ $txt = (int) $diff['hours']; }
        else if($only == "minute"){ $txt = (int) $diff['minutes']; }
        else if($only == "second"){ $txt = (int) $diff['seconds']; }
      }else{
        if($days>0){ $txt .= $diff['days']." Hari "; }
        if($hours>0){ $txt .= $diff['hours']." Jam " ; }
        if($minutes>0){ $txt .= $diff['minutes']." Menit "; }
        if($seconds>0){ $txt .= $diff['seconds']." Detik "; }
      }
      return $txt;
    }

    public static function decideHumanDate($obj)
    {
      if($obj['years'] > 0){
        return $obj['years']." tahun";
      }else if($obj['months'] > 0){
        return $obj['months']." bulan";
      }else{
        return $obj['days']." hari";
      }
    }

    public static function calDate($date, $options, $format='Y-m-d')
    {
      /*
        param options key:
        calculation_type: 'sub', 'add',
        type: 'adddays, addmonths, addyears, subdays, submonths, subyears',
        value: '1-9' etc

        ex options: ['add', 'days', '30']
      */
      // cek array
      if(!is_array($options)){
        return false;
      }

      // cek option key
      if(sizeof($options) > 3 || sizeof($options) < 2)
      {
        return false;
      }

      // dd($options);

      $calculation_type = $options['calculation_type'];
      $type = $options['type'];
      $value = $options['value'];
      $date = new Carbon($date);

      $date = self::checkTypeCarbon($type, $value, $date);

      return $date->format($format);
    }

    function checkTypeCarbon($type, $value, $crDate=false)
    {
      $date = $crDate??Carbon::now();
      if($type == "adddays"){
        return $date->addDays($value);
      }else if($type == "addmonths"){
        return $date->addMonths($value);
      }else if($type == "addyears"){
        return $date->addYears($value);
      }else if($type == "subdays"){
        return $date->subDays($value);
      }else if($type == "submonths"){
        return $date->subMonths($value);
      }else if($type == "subyears"){
        return $date->subYears($value);
      }
    }

    /****************************************************************
     ***** Fungsi untuk Menampilkan Highlight String Pencarian *******
     *****************************************************************/
    public static function HighLight($String, $Keyword){
      if($Keyword == null){
        return $String;
      }else{
        $chString	= str_split($String);
        $lenKey		= strlen($Keyword);
        $strResult	= $chString;

        for($i=0; $i<count($chString); $i++)
        {
          $strKey = "";
          for($a=$i; $a<($i+$lenKey); $a++)
          {
            if(!empty($chString[$a])){
              $strKey .= $chString[$a];
            }
          }

          if(strtolower($strKey) == strtolower($Keyword))
          {
            for($b=$i; $b<($i+$lenKey); $b++)
            {
              $strResult[$b] = "<b><font color='red'>".$chString[$b]."</font></b>";
            }
          }
        }

        return implode("", $strResult);
      }
    }

    public static function cekProcData($obj, $tipe="?")
    {
        if($tipe == "insert")
        {
            if($obj == true){
                $ket = "Data Berhasil Disimpan";
                $status = "callout-info";
            }else{
                $ket = "Data Gagal Disimpan";
                $status = "callout-danger";
            }
        }

        if($tipe == "update")
        {
            if($obj == true){
                $ket = "Data Berhasil Diedit";
                $status = "callout-info";
            }else{
                $ket = "Data Gagal Diedit";
                $status = "callout-danger";
            }
        }

        if($tipe == "delete")
        {
            if($obj == true)
            {
                $ket = "Data Berhasil Dihapus";
                $status = "callout-info";
            }
            else
            {
                $ket = "Data Gagal Dihapus";
                $status = "callout-danger";
            }
        }


        return session()->put("proc-error", ["status" => $status, "ket" => $ket]);
    }
    public static function createError($ket){
      $status = "callout-danger";
      return session()->put("proc-error", ["status" => $status, "ket" => $ket]);
    }
    public static function textFormat($obj){
      $ret = str_replace("\n", "<br>", $obj);
      return $ret;
    }
    public static function cariBulan($obj){
        switch($obj){
            case "1" : $bulan = "Januari"; break;
            case "2" : $bulan = "Februari"; break;
            case "3" : $bulan = "Maret"; break;
            case "4" : $bulan = "April"; break;
            case "5" : $bulan = "Mei"; break;
            case "6" : $bulan = "Juni"; break;
            case "7" : $bulan = "Juli"; break;
            case "8" : $bulan = "Agustus"; break;
            case "9" : $bulan = "September"; break;
            case "10" : $bulan = "Oktober"; break;
            case "11" : $bulan = "November"; break;
            case "12" : $bulan = "Desember"; break;
            default: return ""; break;
        }
        return $bulan;
    }

    public static function tgl_indo_to_sql($obj){
      try{

        if(!empty($obj)){
          $ex = explode("/", $obj);
          $hasil = $ex[2]."-".str_pad($ex[1]??01, 2, 0, STR_PAD_LEFT)."-".str_pad($ex[0]??01, 2, 0, STR_PAD_LEFT);
        }else{
          $hasil = null;
        }

        return $hasil;
      }catch(\Exception $e){
        return null;
      }

    }
    public static function updateStatusResi($status,$id_resi,$urutan){
        $status_log = HistoryResi::STATUS[$status];
        
        $HistoryResi = HistoryResi::create([
            'id_resi' => $id_resi,
            'status' => $status_log,
            'urutan' => $urutan,
        ]);

    

    }
    public static function tgl_indo_to_sql_en($obj){

      if(!empty($obj)){
        $ex = explode("/", $obj);
        $hasil = $ex[2]."-".$ex[0]."-".$ex[1];
      }else{
        $hasil = "1900-01-01";
      }

      return $hasil;

    }

    public static function tgl_sql_to_indo($obj){

    $ex = explode("-", $obj);
    if(!empty($obj)){
      $hasil = $ex[2]."/".$ex[1]."/".$ex[0];
    }else{
      $hasil = "";
    }


    if($hasil == "01/01/0001"){
      return "";
    }


    return $hasil;

  }

  public static function tgl_sql_to_indo_en($obj){

    $ex = explode("-", $obj);

    if(!empty($obj)){
      $hasil = $ex[1]."/".$ex[2]."/".$ex[0];
    }else{
      $hasil = "";
    }

    return $hasil;

  }

  public static function tgl_mysql($obj, $separator){

  	//ex: 07/07/2015
  	//$separator: /
    if(!empty($obj)){
    	$ex = explode($separator, $obj);
    	$tgl = $ex[2]."-".$ex[1]."-".$ex[0];
    }else{
      $tgl = "";
    }

  	return $tgl;
  }

  public static function convert_tgl_mysql($obj, $separator){

  	//ex: 2015-01-01
  	//return 01/01/2015 (garing di ambil dr separator)

  	$ex = explode("-", $obj);
    if(!empty($obj)){
  	   $tgl = $ex[2].$separator.$ex[1].$separator.$ex[0];
    }else{
      $tgl = "";
    }
  	return $tgl;
  }

  public static function convert_tgl_mysql_jam($obj, $separator){

  	//ex: 2015-01-01
  	//return 01/01/2015 (garing di ambil dr separator)
    try{
      if(!empty($obj)){
        $pisah = explode(" ", $obj);
        $ex = explode("-", $pisah[0]);
        $tgl = $ex[2].$separator.$ex[1].$separator.$ex[0]." ".$pisah[1];
      }else{
        $tgl = "";
      }

      return $tgl;

    }catch(\Exception $e){
      return null;
    }
  }

  public static function convert_tgl_indo_jam($obj, $implode, $separator="/"){

  	//ex: 2015-01-01
  	//return 01/01/2015 (garing di ambil dr separator)

    if(!empty($obj)){
      $pisah = explode(" ", $obj);
      // $ex = explode("/", $pisah[0]);

      $parseDate = explode($separator, $pisah[0]);
      $dt[] = self::nNum($parseDate[0]??'');
      $dt[] = self::nNum($parseDate[1]??'');
      $dt[] = self::nNum($parseDate[2]??'');
      $tgl = implode($implode, $dt);

      $parseTime = explode(":", $pisah[1]);
      $tm[] = self::nNum($parseTime[0]??'');
      $tm[] = self::nNum($parseTime[1]??'');
      $tm[] = self::nNum($parseTime[2]??'');
      $time = implode(":", $tm);

      $tgl = $tgl." ".$time;

    }else{
      $tgl = "";
    }

  	return $tgl;
  }

  public static function nNum($obj)
  {

    if($obj != ""){
      if(strlen($obj) < 2){
        $obj = "0".$obj;
      }
    }

    return $obj;
  }

    public static function namahari($tanggal){

        //fungsi mencari namahari
        //format $tgl YYYY-MM-DD

        $tgl=substr($tanggal,8,2);
        $bln=substr($tanggal,5,2);
        $thn=substr($tanggal,0,4);

        $info=date('w', mktime(0,0,0,$bln,$tgl,$thn));

        switch($info){
            case '0': return "Minggu"; break;
            case '1': return "Senin"; break;
            case '2': return "Selasa"; break;
            case '3': return "Rabu"; break;
            case '4': return "Kamis"; break;
            case '5': return "Jumat"; break;
            case '6': return "Sabtu"; break;
            default:
              return '';
        };

    }

    public static function tgl_sql_to_indo2($obj){

      if(empty($obj)){
        return '';
      }
        $ex = explode("-", $obj);
        // dd($ex);
        $hasil = ($ex[2]??'-')." ".self::cariBulan(($ex[1]??'1'))." ".($ex[0]??'-');

        return $hasil;

    }

    public static function hariTgl($tgl)
    {
        $hari = self::namahari($tgl);

        $ret = $hari.", ".self::tgl_sql_to_indo2($tgl);
        return $ret;
    }

    public static function menuList($parent=0,$permission = []){
        $html = "";
        $tb = new tb_menu;
        $dropdown = "";
        $dropdown_toggle = "";
        $dropdown_toggle2 = "";
        $url = "";
        $aktip = "";
        //dd($permission);
        $menu = $tb->where('parent','=',$parent)->where('soft_delete', '<>', '1')->get();
        $parent = $tb->where('id','=',$parent)->where('soft_delete', '<>', '1')->first();

          if(in_array($parent->id, $permission)){

          if(sizeof($menu)>0){
            if($parent->parent==0){
              $dropdown = "dropdown";
            }else{
              $dropdown = "dropdown-submenu";
            }
            $dropdown_toggle = "dropdown-toggle";
            $dropdown_toggle2 = "data-toggle='dropdown'";
            $url = "#";
          }else{
            $url = "/".$parent->param;
          }
          if(isset(app()->view->getSections()[$parent->param])){ $aktip = "active"; }

          $html .= "<li class='$dropdown $aktip'>";
          $html .= "<a href='".url($url)."' class='$dropdown_toggle' $dropdown_toggle2>".$parent->name;
          if(sizeof($menu)>0){
            if($parent->parent==0){ $html .= "<span class='caret'></span>"; }
          }
          $html .= "</a>";
          if(sizeof($menu)>0){
            $html .= "<ul class='dropdown-menu' role='menu'>";
                foreach($menu AS $k){
                  $html .= self::menuList($k->id,$permission);
                }
            $html .= "</ul>";
          }
          $html .= "</li>";
        }
        return $html;
    }

    // fungsi rekursif untuk mengambil kategori dan semua child-nya.
    public static function menu_hirarki($id_kategori = NULL, $id_tipeuser = NULL,$act=null)
    {

        $list = NULL;
      //if(!empty($id_kategori)){ $_SESSION["menu_hirarki"]++; }

        if($id_kategori === NULL)
        {
          $id_kategori = "0";
            // query yang dijalankan jika argumen $id_kategori bernilai NULL
            $sql = DB::table('menus')->where('parent',0)->orderBy('id','asc');
        }
        else
        {
            // pastikan $id_kategori adalah angka
            $id_kategori = intval($id_kategori);
            $sql = DB::table('menus')->where('parent',$id_kategori)->orderBy('id','asc');
        }

        // query MySQL
      $has = $sql->get();
        $num = $sql->count();
      // dd($has);
        // jika kategori ada
        if($num > 0)
        {
            // ambil data kategori
            foreach($has as $kategori){
          $rg = DB::table('user_roles')->where('usertype_id', $id_tipeuser)->where('menu_id',$kategori->id)->first();

          $crd = "";
          $ctm = "";
          $cet = "";
          $chp = "";
          $cpr = "";
          $checked = "";


          $crdCek = "";
          $ctmCek = "";
          $cetCek = "";
          $chpCek = "";
          $cprCek = "";
          if($rg??false){

          if($rg->id??false){ $cmm = 'checked'; }else{ $cmm = ""; }
          if($rg->read == "1"){ $crd = 'checked';
            $crdCek = "<i class='fas fa-check'></i>";}
          if($rg->create == "1"){ $ctm = 'checked';
            $ctmCek = "<i class='fas fa-check'></i>";}
          if($rg->update == "1"){ $cet = 'checked';
            $cetCek = "<i class='fas fa-check'></i>";}
          if($rg->delete == "1"){ $chp = 'checked';
            $chpCek = "<i class='fas fa-check'></i>";}
          if($rg->print == "1"){ $cpr = 'checked';
            $cprCek = "<i class='fas fa-check'></i>";}
          }
                $child_list = self::menu_hirarki($kategori->id,$id_tipeuser,$act);
          // persiapkan list
          $list .= '<tr>';
          $list .= '<td>';
          if($kategori->lvl > 1){
            for($i=1;$i<=$kategori->lvl;$i++){
              $list .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            }

            if($kategori->lvl == 2){
              $list .= "<i class='far fa-dot-circle nav-icon'></i>&nbsp;&nbsp;";
            }else{
              $list .= "<i class='fas fa-ellipsis-v nav-icon'></i>&nbsp;&nbsp;";
            }
          }else{
            $list .= "<i class='".$kategori->icon."'></i>&nbsp;&nbsp;";
          }
                $list .= $kategori->name;
          $list .= '</td>';
          if($act == 'edit'){

            if(empty($child_list)){
              $list .= '<td  style=" text-align: center; "><input type="checkbox" name="read['.$kategori->id.']" value="1" '.$crd.' class="minimal check'.$kategori->id.'" '.$checked.'></td>';
              $list .= '<td  style=" text-align: center; "><input type="hidden" name="menu_id[]" value="'.$kategori->id.'"><input type="checkbox" name="create['.$kategori->id.']" value="1" '.$ctm.' class="minimal check'.$kategori->id.'" '.$checked.'></td>';
              $list .= '<td  style=" text-align: center; "><input type="checkbox" name="edit['.$kategori->id.']" value="1" '.$cet.' class="minimal check'.$kategori->id.'" '.$checked.'></td>';
              $list .= '<td  style=" text-align: center; "><input type="checkbox" name="delete['.$kategori->id.']" value="1" '.$chp.' class="minimal check'.$kategori->id.'" '.$checked.'></td>';
              $list .= '<td  style=" text-align: center; "><input type="checkbox" name="print['.$kategori->id.']" value="1" '.$cpr.' class="minimal check'.$kategori->id.'" '.$checked.'></td>';
            }else{
              $list .= '<td>&nbsp;</td>';
              $list .= '<td>&nbsp;</td>';
              $list .= '<td>&nbsp;</td>';
              $list .= '<td>&nbsp;</td>';
              $list .= '<td>&nbsp;</td>';
            }

          }else{
            $list .= '<td class="text-center">'.$crdCek.'</td>';
            $list .= '<td class="text-center">'.$ctmCek.'</td>';
            $list .= '<td class="text-center">'.$cetCek.'</td>';
            $list .= '<td class="text-center">'.$chpCek.'</td>';
            $list .= '<td class="text-center">'.$cprCek.'</td>';
            // $list .= '<td>&nbsp;</td>';
          }
          $list .= '</tr>';
                // ambil list child dengan memanggil kembali fungsi hirarki
                $list .= $child_list;
            // }

          }
        }
        // hasil list kategori
        return $list;
    }

    public static function menuListTable($parent=0,$permission=null,$act=null){
        $html = "";
        $tb = DB::table('menus');
        $indentDefault = 20;
        $checked_tambah = "";
        $checked_ubah = "";
        $checked_hapus = "";
        $checked_print = "";
        $checked_all = "";

        $menu = $tb->where('parent','=',$parent)->get();
        $parent = $tb->where('id','=',$parent)->first();
        // dd($menu);
        $textIndent = ($indentDefault*($parent->lvl??0));
        $html .= "<tr>";
        $html .= "<td style=' text-indent: ".$textIndent."px;'><input type='hidden' name='id_menu[]' value='".($parent->id??0)."' >";
        $html .= ($parent->name??'');
        $html .= "</td>";
        if(sizeof($menu)<=0){
            if($act == "edit"){
                $html .= "<td style=' width: 15%; text-align: center;'>";
                if(isset($permission[$parent->id]["create"]) && $permission[$parent->id]["create"] == "1"){
                    $checked_tambah = "checked";
                }
                $html .= "<input type='checkbox' name='create[".$parent->id."]' class='check".$parent->id." cer' $checked_tambah value='".($parent->id??'')."'>";
                $html .= "</td>";
                $html .= "<td style=' width: 15%; text-align: center;'>";
                if(isset($permission[$parent->id]["update"]) && $permission[$parent->id]["update"] == "1") {
                    $checked_ubah = "checked";
                }
                $html .= "<input type='checkbox' name='update[" . $parent->id . "]' class='check".$parent->id . " cer' $checked_ubah value='" .($parent->id??''). "'>";
                $html .= "</td>";
                $html .= "<td style=' width: 15%; text-align: center;'>";
                if(isset($permission[$parent->id]["delete"]) && $permission[$parent->id]["delete"] == "1") {
                    $checked_hapus = "checked";
                }
                $html .= "<input type='checkbox' name='delete[" .($parent->id??''). "]' class='check" .($parent->id??''). " cer' $checked_hapus value='" .($parent->id??''). "'>";
                $html .= "</td>";
                $html .= "<td style=' width: 15%; text-align: center;'>";
                if(isset($permission[$parent->id]["print"]) && $permission[$parent->id]["print"] == "1") {
                    $checked_print = "checked";
                }
                $html .= "<input type='checkbox' name='print[" .($parent->id??''). "]' class='check" . $parent->id . " cer' $checked_print value='" . $parent->id . "'>";
                $html .= "</td>";
                $html .= "<td style=' width: 15%; text-align: center;'>";
                if($checked_tambah == "checked" && $checked_ubah == "checked" && $checked_hapus == "checked" && $checked_print == "checked"){
                  $checked_all = "checked";
                }
                $html .= "<input type='checkbox' class='all-check' id='all-check".$parent->id."' name='all' $checked_all value='".$parent->id."'>";
                $html .= "</td>";
            }else{

                $html .= "<td style=' width: 15%; text-align: center;'>";
                if(isset($permission[$parent->id]["create"]) && $permission[$parent->id]["create"] == "1"){
                    $html .= "<i class='fa fa-check-square'></i>";
                }
                $html .= "</td>";
                $html .= "<td style=' width: 15%; text-align: center;'>";
                if(isset($permission[$parent->id]["update"]) && $permission[$parent->id]["update"] == "1") {
                    $html .= "<i class='fa fa-check-square'></i>";
                }
                $html .= "</td>";
                $html .= "<td style=' width: 15%; text-align: center;'>";
                if(isset($permission[$parent->id]["delete"]) && $permission[$parent->id]["delete"] == "1") {
                    $html .= "<i class='fa fa-check-square'></i>";
                }
                $html .= "</td>";
                $html .= "<td style=' width: 15%; text-align: center;'>";
                if(isset($permission[$parent->id]["print"]) && $permission[$parent->id]["print"] == "1") {
                    $html .= "<i class='fa fa-check-square'></i>";
                }
                $html .= "</td>";
                if($act == "edit"){
                    $html .= "<td style=' width: 15%; text-align: center;'>";
                    $html .= "<input type='checkbox' class='all-check' name='all' value='".$parent->id."'>";
                    $html .= "</td>";
                }
            }
        }
        $html .= "</tr>";
        if(sizeof($menu)>0){
            foreach($menu AS $k){
                $html .= self::menuListTable($k->id,$permission,$act);
            }
        }
        return $html;
    }

    public static function menuPermission($id_userrole=0,$parent=0){
      if(empty($parent)){
        //$id_userrole = 1;
        $s1 = DB::table("tb_permissions AS a")->leftJoin("tb_menus AS b", "a.id_menu", "=", "b.id")->where("a.id_userrole", $id_userrole)->where("b.soft_delete", "<>", "1")->select("b.*")->get();
        foreach($s1 AS $dat1){
          $permission[] = $dat1->id;
          if($dat1->tingkatan > 0){
            $permission[] = self::menuPermission($id_userrole,$dat1->parent);
          }
        }
      }else{
        $s2 = DB::table("tb_menus")->where("id", $parent)->where("soft_delete", "<>", "1")->first();
        if($s2->tingkatan > 0){
          $permission[] = $s2->id;
          //if($s2->tingkatan > 0){
          $permission[] = self::menuPermission($id_userrole,$s2->parent);
          //}
        }else{
          $permission = $s2->id;
        }
      }
      return $permission;
    }

    public static function menuPermission2($id_userrole=0,$parent=0){
        //$id_userrole = 1;
        $no="";
        $s1 = DB::table("tb_permissions AS a")->leftJoin("tb_menus AS b", "a.id_menu", "=", "b.id")->where("a.id_userrole", $id_userrole)->where("b.soft_delete", "<>", "1")->select("b.*")->get();
        foreach($s1 AS $dat1){
          $permission[] = $dat1->id;
          if($dat1->tingkatan > 0){
            $no = 0;
            for($i = ($dat1->tingkatan-1); $i >= 0; $i--){
              $no++;
              if($no == 1){
                $parent = $dat1->parent;
              }else{
                $parent = $s2->parent;
              }
              $s2 = DB::table("tb_menus")->where("id", $parent)->where("soft_delete", "<>", "1")->first();
              $permission[] = $s2->id;
            }
          }
        }

      return $permission;
    }

    public static function cMoney($obj, $currency='IDR')
    {
      $op = new Money((float)$obj,  new Currency('USD'), true);
// dd($op->getCurrency()->getSymbol());
      return str_replace($op->getCurrency()->getSymbol(), "", $op);
      // return $op->getCurrency();
    }

    public function cDifference($total, $value, $type)
    {
      /*
      $FLOW = array: from, to
      */

      if(is_array($value))
      {
        /*
          if array, format: [nominal, percent]
        */

        if($value[0] != ""){
          return $value[0];
        }else if($value[1] != ""){
          return ($value[1]/100)*$total;
        }
      }else{
        if($type == "decimal")
        {
          return $value;
        }else if($type == "percent")
        {
          return ($value/100)*$total;
        }
      }

      return 0;
    }

    public static function cost2($angka2)
    {
      if(!empty($angka2)){
        $nilai2 = number_format($angka2,0,".",",");
      }else{
        $nilai2 = "0";
      }
      return $nilai2;
    }

    public static function cost2Input($angka2)
    {
      if(!empty($angka2)){
        $nilai2 = number_format($angka2,0,".",",");
      }else{
        $nilai2 = "";
      }
      return $nilai2;
    }

    public static function cost($angka2)
    {

      if(!empty($angka2)){
        $nilai2 = number_format((float)$angka2,0,".",".");
      }else{
        $nilai2 = 0;
      }
      return $nilai2;
    }

    public static function labelStatusOrder($obj)
    {
      if($obj == "Create" || $obj == "Waiting Payment" || $obj == "On Progress" || $obj == "Delivery")
      { $bg = "bg-yellow"; }
      elseif($obj == "Cancel")
      { $bg = "bg-red"; }
      elseif($obj == "Confirm")
      { $bg = "bg-blue"; }
      elseif($obj == "Recieved")
      { $bg = "bg-green"; }

      return "<span class='badge ".$bg."'>".$obj."</span>";
    }

    public static function normalisasiNilai($obj){
      if(empty($obj))
        return 0;

      if(is_numeric($obj)){
        $obj = explode(".",$obj)[0];
        $ret = str_replace(",", "",$obj);
      }else{
        // $ret = str_replace(",", "", str_replace(".", "", $obj));
        $ret = str_replace(",", "",$obj);
        $obj = explode(".",$obj)[0];
      }
      return $ret;
    }

    public static function diskonView($obj)
    {
      if(strlen($obj) <= "2")
      {
        return $obj."%";
      }else{
        return self::cost($obj);
      }
    }

    public static function nominalSql($obj)
    {
      return str_replace(".", "", $obj);
    }

    public static function nominalSql2($obj)
    {
      return str_replace(",", "", $obj);
    }

    public static function procMsg($status)
    {

      $alert = '<div class="alert alert-'.$status['status'].' alert-dismissible" ><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4 style="padding:0;margin:0;"><i class="icon fa '.self::statusIcon($status['status']).'"></i> '.$status['msg'].'</h4></div>';
      return $alert;
    }

    public static function statusIcon($status)
    {
      $icon = "";

      if($status == "danger")
      {  $icon = "fa-remove"; }
      else
      { $icon = "fa-check"; }

      return $icon;
    }

    public function checkProc($data, $pos, $ket = NULL)
    {
      if($data)
      {
        return array("status"=>"success", "msg"=>$pos." Success");
      }else{
        return array("status"=>"danger", "msg"=>$ket);
      }
    }

    public static function normalText($obj)
    {
      return str_replace(",", "", $obj);
    }

    public static function normalNumber($obj)
    {
      $obj = (empty($obj) ? "0" : $obj);
      return str_replace(",", "", str_replace(".", "", $obj));
    }

    public static function createThumbnail($image_name,$new_width,$new_height,$uploadDir,$moveToDir)
    {
        $path = $uploadDir . '/' . $image_name;

        $mime = getimagesize($path);

        if($mime['mime']=='image/png') {
            $src_img = imagecreatefrompng($path);
        }
        if($mime['mime']=='image/jpg' || $mime['mime']=='image/jpeg' || $mime['mime']=='image/pjpeg') {
            $src_img = imagecreatefromjpeg($path);
        }

        $old_x          =   imageSX($src_img);
        $old_y          =   imageSY($src_img);

        if($old_x > $old_y)
        {
            $thumb_w    =   $new_width;
            $thumb_h    =   $old_y*($new_height/$old_x);
        }

        if($old_x < $old_y)
        {
            $thumb_w    =   $old_x*($new_width/$old_y);
            $thumb_h    =   $new_height;
        }

        if($old_x == $old_y)
        {
            $thumb_w    =   $new_width;
            $thumb_h    =   $new_height;
        }

        $dst_img        =   ImageCreateTrueColor($thumb_w,$thumb_h);

        imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y);


        // New save location
        $new_thumb_loc = $moveToDir . $image_name;

        if($mime['mime']=='image/png') {
            $result = imagepng($dst_img,$new_thumb_loc,8);
        }
        if($mime['mime']=='image/jpg' || $mime['mime']=='image/jpeg' || $mime['mime']=='image/pjpeg') {
            $result = imagejpeg($dst_img,$new_thumb_loc,80);
        }

        imagedestroy($dst_img);
        imagedestroy($src_img);

        return $result;
    }

    public static function cekImg($obj)
    {
      if(empty($obj))
      {
        $obj = asset('/dist/img/user-icon.jpg');
      }else{
        $obj = Storage::url($obj);
      }

      return $obj;
    }

    public static function ConvertTglRange($obj)
    {
      $ex = explode("-", $obj);
      $date = self::tgl_indo_to_sql(trim($ex[0]))."/".self::tgl_indo_to_sql(trim($ex[1]));
      return $date;
    }

    public static function Terbilang($x)
    {
      $abil = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
      if ($x < 12)
        $re = " " . $abil[$x];
      elseif ($x < 20)
        $re = self::Terbilang($x - 10) . "belas";
      elseif ($x < 100)
        $re = self::Terbilang($x / 10) . " puluh" . self::Terbilang($x % 10);
      elseif ($x < 200)
        $re = " seratus" . self::Terbilang($x - 100);
      elseif ($x < 1000)
        $re = self::Terbilang($x / 100) . " ratus" . self::Terbilang($x % 100);
      elseif ($x < 2000)
        $re = " seribu" . self::Terbilang($x - 1000);
      elseif ($x < 1000000)
        $re = self::Terbilang($x / 1000) . " ribu" . self::Terbilang($x % 1000);
      elseif ($x < 1000000000)
        $re = self::Terbilang($x / 1000000) . " juta" . self::Terbilang($x % 1000000);

      return $re;
    }

    ############################# FUNGSI MENCARI TGL, BULAN, TAHUN FORMAT INDONESIA #############################
    public static function tampiltgl2($valtgl)
    {
    if(!empty($valtgl)) {
    $temp=explode(substr($valtgl, 2, 1),$valtgl);
    $tgl=$temp[0];
    $bulan=$temp[1];
    $tahun=$temp[2];
    return $tgl." ".self::bulan_c($bulan)." ".$tahun;
   } else {
   return "" ;
  }
    }

    #################### MENCARI BULAN DI DALAM FIELD ###################
    public static function bulan_c($nilai)
    {
    //
    if ($nilai=='01' || $nilai=='1')
    {return "Jan";}
    elseif ($nilai=='02' || $nilai=='2')
    {return "Feb";}
    elseif ($nilai=='03' || $nilai=='3')
    {return "Mar";}
    elseif ($nilai=='04' || $nilai=='4')
    {return "Apr";}
    elseif ($nilai=='05' || $nilai=='5')
    {return "Mei";}
    elseif ($nilai=='06' || $nilai=='6')
    {return "Jun";}
    elseif ($nilai=='07' || $nilai=='7')
    {return "Jul";}
    elseif ($nilai=='08' || $nilai=='8')
    {return "Agu";}
    elseif ($nilai=='09' || $nilai=='9')
    {return "Sep";}
    elseif ($nilai=='10')
    {return "Okt";}
    elseif ($nilai=='11')
    {return "Nov";}
    elseif ($nilai=='12')
    {return "Des";}
    //end function
    }

    public static function bgStatus($obj)
    {
      $statusGreen = array('Aktif', '0');
      $statusRed = array('Tidak Aktif', '1');

      if(in_array($obj, $statusGreen))
      {
        $bg = 'bg-green';
      }else{
        $bg = 'bg-red';
      }

      return $bg;
    }

    public static function vDiskon($obj)
    {
      if($obj ?? false){
        $ex = explode(".",$obj);
        if(strlen($ex[0]) <= 3){
          return abs($obj)."%";
        }else{
          return self::cost2($obj);
        }
      }
    }

    public static function cDiskonSymbol($obj)
    {
        if($obj??false){
            $ex = explode(".", $obj);
            if(strlen($ex[0]) <= 3){
                return "%";
            }else{
                return "Rp";
            }
        }else{
            return '%';

        }
    }

    public static function menuDetail($prefix)
    {
        if(!$prefix){
            return [];
        }

        $curParam = '';
        $param = explode("/",$prefix);
        if($param[0] === ''){
            $curParam = explode("?", $param[1])[0];
        }else{
            $curParam = $param[0];
        }

        return $curParam;
        // return Menu::where('parameter', $curParam)->first();
    }


  static public function alphaToNum($obj){
    $alphabet = array( 'a', 'b', 'c', 'd', 'e',
                      'f', 'g', 'h', 'i', 'j',
                      'k', 'l', 'm', 'n', 'o',
                      'p', 'q', 'r', 's', 't',
                      'u', 'v', 'w', 'x', 'y',
                      'z'
                    );
    $alpha_flip = array_flip($alphabet);
    // dd($alpha_flip);
    $return_value = -1;
    $length = strlen($obj);
    for ($i = 0; $i < $length; $i++) {
      $return_value += ($alpha_flip[$obj[$i]] + 1) * pow(26, ($length - $i - 1));
    }
    return $return_value;
  }

  static public function NumToAlpha($obj)
  {
    $num = substr($obj, 0, 1);
    $alpha = substr($obj, 1, 1);
    $alphabet = array( 'a', 'b', 'c', 'd', 'e',
                      'f', 'g', 'h', 'i', 'j',
                      'k', 'l', 'm', 'n', 'o',
                      'p', 'q', 'r', 's', 't',
                      'u', 'v', 'w', 'x', 'y',
                      'z'
                    );
    return strtoupper($num.$alphabet[$alpha]);
  }

  static public function fileAttr($obj)
  {

    //File Name
    $name = $obj->getClientOriginalName();

    //Display File Extension
    $extension = $obj->getClientOriginalExtension();

    //Display File Real Path
    $realPath = $obj->getRealPath();

    //Display File Size
    $size = $obj->getSize();

    //Display File Mime Type
    $mime = $obj->getMimeType();

    return [
      "name" => str_replace(".", "_", $name),
      "extension" => $extension,
      "realPath" => $realPath,
      "size" => $size,
      "mime" => $mime
    ];
  }

  static public function numberToRoman($number) {
    $map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
    $returnValue = '';
    while ($number > 0) {
        foreach ($map as $roman => $int) {
            if($number >= $int) {
                $number -= $int;
                $returnValue .= $roman;
                break;
            }
        }
    }
    return $returnValue;
  }

  static public function uniqueId($tableName, $field)
  {
    $str = uniqid(rand(), true);

    $check = DB::table($tableName)->where($field, $str)->first();

    if($check==null){
      return $str;
    }

    self::uniqueId($tableName, $field);
  }

  static public function gender($obj)
  {
    if($obj == '-'){
      return '-';
    }else if(strtolower($obj) == 'l'){
      return 'Laki -  Laki';
    }else if(strtolower($obj) == 'p'){
      return 'Perempuan';
    }

    return '';
  }
}

