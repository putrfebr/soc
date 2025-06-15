@extends('admin-layouts.master')

@section('content')
<style>
    .copy-text {
	position: relative;
	padding: 10px;
	background: #fff;
	border: 1px solid #ddd;
	border-radius: 10px;
	display: flex;
}
.copy-text input.text {
	padding: 10px;
	font-size: 18px;
	color: #555;
	border: none;
	outline: none;
}

.copy-text button {
	padding: 10px;
	background: #5784f5;
	color: #fff;
	font-size: 18px;
	border: none;
	outline: none;
	border-radius: 10px;
	cursor: pointer;
}

.copy-text button:active {
	background: #809ce2;
}
.copy-text button:before {
	content: "Copied";
	position: absolute;
	top: -45px;
	right: 0px;
	background: #5c81dc;
	padding: 8px 10px;
	border-radius: 20px;
	font-size: 15px;
	display: none;
}
.copy-text button:after {
	content: "";
	position: absolute;
	top: -20px;
	right: 25px;
	width: 10px;
	height: 10px;
	background: #5c81dc;
	transform: rotate(45deg);
	display: none;
}
.copy-text.active button:before,
.copy-text.active button:after {
	display: block;
}
</style>
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Formulir SOC</h1>
    @if ($message = Session::get('resi_code'))
    <div class="alert alert-primary alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>	
        {{-- <strong>{{ $message }}</strong> --}}
        <div class="label font-weight-bold mb-1">
            Nomor Resi
        </div>
        <div class="copy-text">
            <input type="text" class="text font-weight-bold" value="{{ $message }}" />
            <button><i class="fa fa-clone"></i></button>
        </div>
    </div>
    @endif
    <div class="card">
        <div class="card-body">
            <form  action="{{route($route.'.store')}}" method="POST" enctype="multipart/form-data" id="hseForm">
                @csrf
                <input type="hidden" name="id" value="{{ $data->id??false }}">
                <input type="hidden" name="potensi_risiko" id="potensi_risiko">
                <input type="hidden" name="tindakan_mitigasi" id="tindakan_mitigasi">
                <div class="form-row">
                    <div class="col-lg-6 col-sm-12">
                        <div class="form-group ">
                            <label for=""@error('nama') class="text-danger" @enderror >Nama</label>
                            <input type="text" name="nama" class="form-control @error('nama') form-control is-invalid @enderror"
                            placeholder="" value="{{ $data->nama??false}}" @if($data->only_view) disabled @endif>
                            @error('nama')
                                <span  class="text-danger"> {{ $message }} </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <div class="form-group ">
                            <label for=""@error('divisi') class="text-danger" @enderror >Divisi</label>
                            <input type="text" name="divisi" class="form-control @error('divisi') form-control is-invalid @enderror"
                            placeholder="" value="{{ $data->divisi??false}}"  @if($data->only_view) disabled @endif>
                            @error('divisi')
                                <span  class="text-danger"> {{ $message }} </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    
                    <div class="col-lg-6 col-sm-12">
                        <div class="form-group">
                            <label for=""@error('tanggal_waktu') class="text-danger" @enderror >Tanggal & Waktu</label>
                            <input type="datetime-local" name="tanggal_waktu" class="form-control @error('tanggal_waktu') form-control is-invalid @enderror"
                            placeholder="" value="{{ $data->tanggal_waktu ??false }}" @if($data->only_view) disabled @endif>
                            @error('tanggal_waktu')
                                <span  class="text-danger"> {{ $message }} </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <div class="form-group">
                            <label for=""@error('lokasi') class="text-danger" @enderror >Lokasi</label>
                            <input type="text" name="lokasi" class="form-control @error('lokasi') form-control is-invalid @enderror"
                            placeholder="" value="{{ $data->lokasi ??false }}" @if($data->only_view) disabled @endif>
                            @error('lokasi')
                                <span  class="text-danger"> {{ $message }} </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    
                    <div class="col-lg-6 col-sm-12">
                        <div class="form-group">
                            <label for=""@error('golden_rules') class="text-danger" @enderror >Golden Rules Violation</label>
                            <select name="golden_rules" id="golden_rules" class="form-control @error('golden_rules') form-control is-invalid @enderror @if($data->only_view) disabled @endif">
                                <option value="">Pilih</option>
                                <option value="Ya"@if($data->golden_rules == 'Ya') selected @endif>Ya</option>
                                <option value="Tidak"@if($data->golden_rules == 'Tidak') selected @endif>Tidak</option>

                            </select>
                            
                            @error('golden_rules')
                                <span  class="text-danger"> {{ $message }} </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <div class="form-group">
                            <label for=""@error('unsafe_action') class="text-danger" @enderror >Unsafe Action</label>
                            <input type="text" name="unsafe_action" class="form-control @error('unsafe_action') form-control is-invalid @enderror"
                            placeholder="" value="{{ $data->unsafe_action ??false }}" @if($data->only_view) disabled @endif id="unsafe_action">
                            @error('unsafe_action')
                                <span  class="text-danger"> {{ $message }} </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    
                    <div class="col-lg-6 col-sm-12">
                        <div class="form-group">
                            <label for=""@error('safe_behaviour') class="text-danger" @enderror >Safe Behaviour</label>
                            <input type="text" name="safe_behaviour" class="form-control @error('safe_behaviour') form-control is-invalid @enderror"
                            placeholder="" value="{{ $data->safe_behaviour ??false }}" @if($data->only_view) disabled @endif id="safe_behaviour">
                            @error('safe_behaviour')
                                <span  class="text-danger"> {{ $message }} </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <div class="form-group">
                            <label for=""@error('cuaca') class="text-danger" @enderror >Cuaca</label>
                            <select name="cuaca" id="cuaca" class="form-control @error('cuaca') form-control is-invalid @enderror @if($data->only_view) disabled @endif">
                                <option value="">Pilih</option>
                                <option value="Normal"@if($data->cuaca == 'Normal') selected @endif>Normal</option>
                                <option value="Hujan"@if($data->cuaca == 'Hujan') selected @endif>Hujan</option>
                                <option value="Hujan Lebat"@if($data->cuaca == 'Hujan Lebat') selected @endif>Hujan Lebat</option>
                                <option value="Angin Kencang"@if($data->cuaca == 'Angin Kencang') selected @endif>Angin Kencang</option>
                                
                            </select>
                            
                            {{-- <input type="text" name="cuaca" class="form-control @error('cuaca') form-control is-invalid @enderror"
                            placeholder="" value="{{ $data->cuaca ??false }}" @if($data->only_view) disabled @endif> --}}
                            @error('cuaca')
                                <span  class="text-danger"> {{ $message }} </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    
                    <div class="col-lg-6 col-sm-12">
                        <div class="form-group">
                            <label for=""@error('suhu') class="text-danger" @enderror >Suhu (°C)</label>
                            <input type="text" name="suhu" class="form-control @error('suhu') form-control is-invalid @enderror"
                            placeholder="" value="{{ $data->suhu ??false }}" @if($data->only_view) disabled @endif>
                            @error('suhu')
                                <span  class="text-danger"> {{ $message }} </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <div class="form-group">
                            <label for=""@error('freq') class="text-danger" @enderror >Frekuensi Insiden Sebelumnya</label>
                            <input type="text" name="freq" class="form-control @error('freq') form-control is-invalid @enderror"
                            placeholder="" value="{{ $data->freq ??false }}" @if($data->only_view) disabled @endif>
                            @error('freq')
                                <span  class="text-danger"> {{ $message }} </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-lg-12 col-sm-12">
                        <div class="form-group">
                            <label for=""@error('deskripsi') class="text-danger" @enderror >Apa yang kamu lihat ?
                            </label>
                            <textarea name="deskripsi" class="form-control" id="" cols="30" rows="3">{{$data->deskripsi ??false}}</textarea>
                        </div>
                    </div>
                </div>
                
                
                <div class="form-group">
                    <a href="javascript:history.back()" class="btn btn-danger mt-3"> Kembali</a>
                    <input type="submit" value="Kirim" class="btn btn-primary mt-3">
                    <button type="button" id="btnSimpan" style="display: none;">Simpan</button>
                </div>
            </form>
            <div id="result" style="margin-top:20px;"></div>
        </div>
    </div>
</div>
@push('scripts')
<script>
let predictionData = [];

fetch("{{ asset('model_prediksi/rf_model.json') }}")
    .then(res => res.json())
    .then(data => {
        predictionData = data;
    });

document.getElementById("hseForm").addEventListener("submit", function(e) {
    e.preventDefault();

    const input = {
        golden_rule_violation: parseInt(document.getElementById("golden_rule_violation").value),
        unsafe_act_condition: document.getElementById("unsafe_act_condition").value ? 1 : 0,
        safe_behaviour: document.getElementById("safe_behaviour").value ? 1 : 0,
        past_incident_frequency: parseInt(document.getElementById("past_incident_frequency").value),
        weather: parseInt(document.getElementById("weather").value),
        temperature: parseFloat(document.getElementById("temperature").value)
    };

    const matched = predictionData.find(item => {
        const f = item.features;
        return (
            f.golden_rule_violation === input.golden_rule_violation &&
            f.unsafe_act_condition === input.unsafe_act_condition &&
            f.safe_behaviour === input.safe_behaviour &&
            f.past_incident_frequency === input.past_incident_frequency &&
            f.weather === input.weather &&
            Math.abs(f.temperature - input.temperature) < 0.5  // toleransi suhu
        );
    });

    const riskLabelMap = {
        0: "Rendah",
        1: "Sedang",
        2: "Tinggi"
    };

    const actionLabelMap = {
        0: "Berikan apresiasi atau teruskan pengawasan rutin.",
        1: "Lakukan tindakan korektif lokal atau beri peringatan.",
        2: "Investigasi segera dan hentikan pekerjaan jika perlu.",
        3: "Lakukan investigasi besar dan hentikan pekerjaan hingga situasi aman.",
        4: "Tingkatkan pengawasan dan lakukan inspeksi tambahan di lokasi tersebut.",
        5: "Tunda pekerjaan luar ruangan dan berikan perlengkapan tambahan.",
        6: "Batasi penggunaan alat berat dan beri pekerja istirahat lebih sering."
    };

    if (matched) {
        document.getElementById("result").innerHTML = `
            <h3>Hasil Prediksi (via JSON)</h3>
            <p><strong>Risk Level:</strong> ${riskLabelMap[matched.risk_level]}</p>
            <p><strong>Action:</strong> ${actionLabelMap[matched.action]}</p>
        `;
    } else {
        document.getElementById("result").innerHTML = `
            <h3>Hasil Prediksi</h3>
            <p>Data tidak ditemukan dalam model JSON.</p>
        `;
    }
});
</script>





@endpush
@endsection