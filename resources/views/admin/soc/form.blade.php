@extends('admin-layouts.master')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" />
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
                            <select @if($data->only_view) disabled @endif name="golden_rules" id="golden_rule_violation" class="form-control @error('golden_rules') form-control is-invalid @enderror ">
                                <option value="">Pilih</option>
                                <option value="1"@if($data->golden_rules == '1') selected @endif>Ya</option>
                                <option value="0"@if($data->golden_rules == '0') selected @endif>Tidak</option>

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
                            placeholder="" value="{{ $data->unsafe_action ??false }}" @if($data->only_view) disabled @endif id="unsafe_act_condition">
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
                            <select name="cuaca" id="weather" class="form-control @error('cuaca') form-control is-invalid @enderror " @if($data->only_view) disabled @endif>
                                <option value="">Pilih</option>
                                <option value="0"@if($data->cuaca == '0') selected @endif>Cerah</option>
                                <option value="1"@if($data->cuaca == '1') selected @endif>Mendung</option>

                                <option value="2"@if($data->cuaca == '2') selected @endif>Hujan</option>
                                <option value="3"@if($data->cuaca == '3') selected @endif>Hujan Lebat</option>
                                <option value="4"@if($data->cuaca == '4') selected @endif>Angin Kencang</option>
                                
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
                            placeholder="" value="{{ $data->suhu ??false }}" @if($data->only_view) disabled @endif id="temperature">
                            @error('suhu')
                                <span  class="text-danger"> {{ $message }} </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <div class="form-group">
                            <label for=""@error('freq') class="text-danger" @enderror >Frekuensi Insiden Sebelumnya</label>
                            <input type="text" id="past_incident_frequency" name="freq" class="form-control @error('freq') form-control is-invalid @enderror"
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
                            <textarea name="deskripsi" class="form-control" id="" cols="30" rows="3" @if($data->only_view) disabled @endif>{{$data->deskripsi ??false}}</textarea>
                        </div>
                    </div>
                </div>
                @if(!empty($data->photos))
                    <div class="form-group">
                        <label>Foto yang sudah diupload:</label>
                        <div class="row">
                            @foreach(json_decode($data->photos, true) as $photo)
                                <div class="col-md-3 mb-2">
                                    <div class="position-relative">
                                        <img src="{{ $photo }}" class="img-fluid rounded" style="border:1px solid #ddd;">
                                        <button type="button" class="btn btn-sm btn-danger btn-remove-photo" 
                                            data-photo="{{ $photo }}" 
                                            data-id="{{ $data->id }}"
                                            style="position:absolute; top:5px; right:5px;">Hapus</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                <div class="form-group">
                    <label for="photos">Upload Foto (bisa drag & drop, multiple):</label>
                    <div class="dropzone" id="photoDropzone"></div>
                </div>
                
                <hr>
                <h5 class="text-center">Prediksi</h5>
                <div class="form-row">
                   
                    <div class="col-lg-6 col-sm-12">
                        <div class="form-group">
                            <label for=""@error('') class="text-danger" @enderror >Resiko</label>
                            <input type="text" id="" name="" class="form-control @error('') form-control is-invalid @enderror"
                            placeholder="" value="{{ $data->risk ??false }}" @if($data->only_view) disabled @endif readonly>
                            @error('')
                                <span  class="text-danger"> {{ $message }} </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <div class="form-group">
                            <label for=""@error('freq') class="text-danger" @enderror >Tindakan Mitigas</label>
                            <input type="text" id="" name="" class="form-control @error('freq') form-control is-invalid @enderror"
                            placeholder="" value="{{ $data->action ??false }}" @if($data->only_view) disabled @endif readonly>
                            @error('freq')
                                <span  class="text-danger"> {{ $message }} </span>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <a href="javascript:history.back()" class="btn btn-danger mt-3"> Kembali</a>
                    @if(!$data->only_view??false) 
                    <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                    @endif
                    {{-- <button type="button" id="btnSimpan" style="display: none;">Simpan</button> --}}
                </div>
                
            </form>
            
            <div id="result" style="margin-top:20px;">
                @if($data->id??false)
                    
                @endif
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll('.btn-remove-photo').forEach(button => {
            button.addEventListener('click', function () {
                const photoUrl = this.dataset.photo;
                const recordId = this.dataset.id;
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
                if (confirm("Yakin ingin menghapus foto ini?")) {
                    fetch('/photos/delete', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            id: recordId,
                            photo: photoUrl
                        })
                    }).then(response => response.json())
                      .then(data => {
                          if (data.success) {
                              // Hapus tampilan gambar
                              this.closest('.col-md-3').remove();
                          } else {
                              alert('Gagal menghapus foto.');
                          }
                      }).catch(() => {
                          alert('Terjadi kesalahan.');
                      });
                }
            });
        });
    });
</script>
    
<script>
    Dropzone.autoDiscover = false;

    var uploadedPhotos = [];

    let photoDropzone = new Dropzone("#photoDropzone", {
        url: "{{ route('photos.upload') }}",
        maxFilesize: 2, // MB
        acceptedFiles: ".jpeg,.jpg,.png",
        addRemoveLinks: true,
        paramName: 'photos', // jangan pakai photos[] di sini
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        success: function(file, response) {
            uploadedPhotos.push(response.file_path);
            let input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'uploaded_photos[]'; // tetap array di sisi form
            input.value = response.file_path;
            document.getElementById('hseForm').appendChild(input);
        },
        removedfile: function(file) {
            file.previewElement.remove();
            if (file.xhr) {
                let response = JSON.parse(file.xhr.response);

                if (response.file_path) {
                    // Kirim request ke server untuk hapus file fisik
                    fetch('/photos/delete', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            file_path: response.file_path
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        console.log('File deleted from server:', data);
                    })
                    .catch(err => {
                        console.error('Delete error:', err);
                    });
                }
                const inputs = document.querySelectorAll('input[name="uploaded_photos[]"]');
                console.log(inputs)
                inputs.forEach(input => {
                    if (input.value === file.xhr.response.file_path) {
                        // Hapus dari form
                        input.remove();
                        // Hapus dari uploadedPhotos array
                        const index = uploadedPhotos.indexOf(input.value);
                        if (index > -1) {
                            uploadedPhotos.splice(index, 1);
                        }
                        
                    }
                });
            }
            // Cari path file dari hidden input
            
        }
    });
</script>
    
<script>
    let modelRisk = null;
    let modelAction = null;
  
    // Daftar fitur yang digunakan, urut sesuai model
    const featureNames = [
      "golden_rule_violation",
      "unsafe_act_condition",
      "safe_behaviour",
      "past_incident_frequency",
      "weather",
      "temperature"
    ];
  
    // Fungsi untuk menelusuri satu pohon keputusan
    function traverseTree(node, features) {
      if (node.value) {
        // Node daun, kembalikan probabilitas kelas
        return node.value[0];
      }
      // Ambil indeks fitur dari nama fitur
      const featureIndex = featureNames.indexOf(node.feature);
      if (featureIndex === -1) {
        throw new Error(`Fitur ${node.feature} tidak ditemukan dalam daftar fitur.`);
      }
      // Bandingkan nilai fitur dengan threshold
      if (features[featureIndex] <= node.threshold) {
        return traverseTree(node.left, features);
      } else {
        return traverseTree(node.right, features);
      }
    }
  
    // Fungsi prediksi untuk satu model (array pohon)
    function predictModel(model, features) {
      // model adalah array pohon
      const nClasses = model[0].value ? model[0].value[0].length : 3; // asumsi 3 kelas default
      const classVotes = new Array(nClasses).fill(0);
  
      for (const tree of model) {
        const probs = traverseTree(tree, features);
        for (let i = 0; i < nClasses; i++) {
          classVotes[i] += probs[i];
        }
      }
  
      // Cari kelas dengan nilai tertinggi
      let maxIndex = 0;
      for (let i = 1; i < classVotes.length; i++) {
        if (classVotes[i] > classVotes[maxIndex]) {
          maxIndex = i;
        }
      }
      return maxIndex;
    }
    function scalePastIncidents(value) {
        const maxValue = 20; // sesuaikan dengan data pelatihan
        return Math.min(value / maxValue, 1);
    }
    // Fungsi untuk memuat model JSON
    async function loadModels() {
      const [riskResponse, actionResponse] = await Promise.all([
        fetch("{{ asset('model_prediksi/rf_action_model.json') }}"),
        fetch("{{ asset('model_prediksi/rf_risk_model.json') }}")
      ]);
      modelRisk = await riskResponse.json();
      modelAction = await actionResponse.json();
      console.log("Model Risk loaded:", modelRisk);
      console.log("Model Action loaded:", modelAction);
    }
  
    // Fungsi ekstrak fitur dari form input
    function extractFeatures() {
      const goldenRule = parseFloat(document.getElementById("golden_rule_violation").value || "0");
      const unsafeAct = parseFloat(document.getElementById("unsafe_act_condition").value || "0");
      const safeBehaviour = parseFloat(document.getElementById("safe_behaviour").value || "0");
      const pastIncidents = scalePastIncidents(parseFloat(document.getElementById("past_incident_frequency").value || "0"));
      const weather = parseFloat(document.getElementById("weather").value || "0");
      const temperature = parseFloat(document.getElementById("temperature").value || "0");
  
      return [goldenRule, unsafeAct, safeBehaviour, pastIncidents, weather, temperature];
    }
  
    // Mapping label hasil prediksi
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
    // const actionLabelMap = {
    //     0: "Berikan apresiasi kepada pekerja atau tim yang mematuhi aturan keselamatan.",
    //     1: "Lakukan tindakan korektif lokal dan beri peringatan pada pekerja terkait",
    //     2: "Lakukan investigasi segera dan terapkan tindakan korektif besar",

    //     3: "Tingkatkan pengawasan dan lakukan inspeksi tambahan di lokasi tersebut.",
    //     4: "Tunda pekerjaan luar ruangan dan berikan perlengkapan tambahan seperti jas hujan atau pakaian hangat. ",
    //     5: "Batasi penggunaan alat berat dan beri pekerja istirahat lebih sering ",
    //     6: "Lakukan investigasi besar dan hentikan pekerjaan hingga situasi aman."
    // };
    // Handler form submit
    document.getElementById("hseForm").addEventListener("submit", async function (e) {
      e.preventDefault();
      const goldenRuleCheck = document.getElementById("golden_rule_violation").value ;
      const unsafeActCheck = document.getElementById("unsafe_act_condition").value ;
      const safeBehaviourCheck = document.getElementById("safe_behaviour").value ;
      const pastIncidentsCheck = (document.getElementById("past_incident_frequency").value );
      const weatherCheck = document.getElementById("weather").value ;
      const temperatureCheck = document.getElementById("temperature").value ;
      console.log(goldenRuleCheck,unsafeActCheck,safeBehaviourCheck,pastIncidentsCheck,weatherCheck,temperatureCheck)
      // Cek apakah semua input kosong
        if (
        !goldenRuleCheck &&
        !unsafeActCheck &&
        !safeBehaviourCheck &&
        !pastIncidentsCheck &&
        !weatherCheck &&
        !temperatureCheck
        ) {
        Swal.fire({
            icon: 'error',
            title: 'Oops!',
            text: 'Data Perhitungan Tidak Valid, Pastikan data lengkap!',
        });
        return;
        }
        if (!modelRisk || !modelAction) {
        Swal.fire({
            icon: 'error',
            title: 'Oops!',
            text: 'Model Tidak Ditemukan ! Silahkan coba kombinasi dengan rule lain',
        });
        return;
}

      const features = extractFeatures();
      const riskPrediction = predictModel(modelRisk, features);
      const actionPrediction = predictModel(modelAction, features);
      document.getElementById("potensi_risiko").value = riskLabelMap[riskPrediction];
      document.getElementById("tindakan_mitigasi").value = actionLabelMap[actionPrediction];
      this.submit();
    //   const resultDiv = document.getElementById("result");
    //   resultDiv.innerHTML = `
    //     <h3>Hasil Prediksi</h3>
    //     <p><strong>Risk Level:</strong> ${riskLabelMap[riskPrediction]}</p>
    //     <p><strong>Rekomendasi Aksi:</strong> ${actionLabelMap[actionPrediction]}</p>
    //   `;
    });
  
    // Muat model saat halaman siap
    window.addEventListener("DOMContentLoaded", loadModels);
  </script>
  

@endpush
@endsection