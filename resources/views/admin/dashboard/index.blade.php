@extends('admin-layouts.master')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between ">
        <h1 class="h3 mb-0 text-gray-800">{{$title}}</h1>
        {{-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> --}}
    </div>

    <!-- Content Row -->
    .<div class="row">
        .<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-4">
            <div class="card shadow">
                
                <div class="card-body">
                    <h4 class="card-title">Filter</h4>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="startDate">Dari Tanggal:</label>
                            <input type="date" id="startDate" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label for="endDate">Sampai Tanggal:</label>
                            <input type="date" id="endDate" class="form-control">
                        </div>
                        {{-- <div class="col-md-3">
                            <label for="divisiFilter">Filter Divisi:</label>
                            <select id="divisiFilter" class="form-control">
                                <option value="">-- Semua Divisi --</option>
                                <option value="HRD">HRD</option>
                                <option value="Operation">Operation</option>
                                <!-- Tambahkan lainnya -->
                            </select>
                        </div> --}}
                        <div class="col-md-3 d-flex align-items-end">
                            <button class="btn btn-primary w-100" id="applyFilter">Terapkan Filter</button>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-7 col-md-12 col-sm-12 mb-4">
            <div class="card border-left-secondary shadow h-100 py-2">
                
                <div class="card-body">
                    <div id="riskDonutChart"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-5 col-md-12 col-sm-12 mb-4">
            <div class="card border-left-secondary shadow h-100 py-2">
              <div class="card-header bg-white font-weight-bold">
                Foto Risiko Terbanyak : <span id="topRiskLabel">-</span>
              </div>
              <div class="card-body" id="photoGallery">
                <p class="text-center">Tidak ada foto</p>
                
              </div>
              <div class="card-footer bg-white">
                  Rekomendasi Trend : <span id="topActionLabel">-</span>
                </div>
            </div>
            
        </div>
       
        
    </div>

    <!-- Content Row -->

    

   
</div>
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    let chart;
    
    function loadRiskChart(filters = {}) {
        $.ajax({
            url: "{{ route('dashboard.risk-chart-data') }}",
            data: filters,
            success: function (response) {
                const hasData = response.series && response.series.length > 0;
                  // Hitung total keseluruhan untuk persentase
                const totalCount = hasData ? response.series.reduce((a, b) => a + b, 0) : 0;
                // Buat label baru dengan format "Label (Jumlah)"
                const labelsWithCount = hasData
                    ? response.labels.map((label, index) => `${label} (${response.series[index]})`)
                    : [];
                const options = {
                    chart: {
                        type: 'donut',
                        height: 350
                    },
                    series: hasData ? response.series : [],
                    labels: labelsWithCount ,
                    colors: ['#4ccce4', '#fc4c4c', '#fcb455', '#577590', '#f9c74f'],
                    title: {
                        text: 'Distribusi Risiko (Risk Level)'
                    },
                    legend: { position: 'bottom' },
                    noData: {
                        text: 'Tidak ada data',
                        align: 'center',
                        verticalAlign: 'middle',
                        style: {
                            color: '#999',
                            fontSize: '16px'
                        }
                    },
                    tooltip: {
                        y: {
                            formatter: function (val) {
                                // Hitung persentase
                                const percent = totalCount > 0 ? ((val / totalCount) * 100).toFixed(2) : 0;
                                return `${val} kasus (${percent}%)`;
                            }
                        }
                    }
                };

                if (chart) {
                    chart.destroy();
                }
                chart = new ApexCharts(document.querySelector("#riskDonutChart"), options);
                chart.render();
            }
        });
    }
    function loadTopRiskPhotos(filters = {}) {
        $.ajax({
            url: "{{ route('dashboard.top-risk-photos') }}",
            data: filters,
            success: function(response) {
                $('#topRiskLabel').text(response.topRisk ?? '-');
                $('#topActionLabel').text(response.topAction ?? '-');

                


                let photosHtml = '';
                if (response.photos && response.photos.length > 0) {
                    photosHtml += `<div style="
                        display: grid;
                        grid-template-columns: repeat(3, 1fr);
                        gap: 10px;
                    ">`;

                    response.photos.forEach(photoUrl => {
                        photosHtml += `
                            <div style="position: relative; width: 100%; padding-top: 100%; overflow: hidden; border-radius: 5px;">
                                <img src="${photoUrl}" alt="Photo" style="
                                    position: absolute;
                                    top: 0; left: 0; width: 100%; height: 100%;
                                    object-fit: cover;
                                    border-radius: 5px;
                                ">
                            </div>
                        `;
                    });

                    photosHtml += `</div>`;
                    
                } else {
                    photosHtml = '<p>Tidak ada foto</p>';
                }
                $('#photoGallery').html(photosHtml);
                
            },
            error: function() {
                alert('Gagal mengambil data foto.');
            }
        });
    }


    $(document).ready(function () {
        loadRiskChart();
        loadTopRiskPhotos();
        $('#applyFilter').on('click', function () {
            const filters = {
                divisi: $('#divisiFilter').val(),
                start_date: $('#startDate').val(),
                end_date: $('#endDate').val()
            };
            loadRiskChart(filters);
            loadTopRiskPhotos(filters);
        });
    });
</script>
@endpush

@endsection