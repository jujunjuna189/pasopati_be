@extends('layouts.app_template')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header justify-content-between">
                <h3 class="card-title">Kelola Data Kendaraan</h3>
                <div>
                    <span class="btn bg-blue-lt border-dashed" onclick="openModalKendaraan()">Tambah</span>
                </div>
            </div>
            <div class="card-body border-bottom py-3">
                <div class="d-flex">
                    <div class="text-muted">
                        Show
                        <div class="mx-2 d-inline-block">
                            <input type="text" class="form-control form-control-sm" value="8" size="3" aria-label="Invoices count">
                        </div>
                        entries
                    </div>
                    <div class="ms-auto text-muted">
                        Search:
                        <div class="ms-2 d-inline-block">
                            <form action="javascript:onSearch()" method="get">
                                <input type="text" name="search" class="form-control form-control-sm" aria-label="Search invoice">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table card-table table-vcenter text-nowrap datatable">
                    <thead>
                        <tr>
                            <th class="w-1"><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></th>
                            <th class="w-1">No.
                                <!-- Download SVG icon from http://tabler-icons.io/i/chevron-up -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm text-dark icon-thick" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <polyline points="6 15 12 9 18 15"></polyline>
                                </svg>
                            </th>
                            <th>QrCode</th>
                            <th>Jenis</th>
                            <th>Nomor</th>
                            <th>Keterangan</th>
                            <th style="width: 10rem;" class="bg-dark text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kendaraan as $val)
                        <tr>
                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select invoice"></td>
                            <td>{{ $no++ }}</td>
                            <td>{{ $val->code }}</td>
                            <td>{{ $val->jenis ?? '-' }}</td>
                            <td>{{ $val->nomor }}</td>
                            <td>{{ $val->deskripsi }}</td>
                            <td></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer d-flex align-items-center">
                <p class="m-0 text-muted">Showing <span>1</span> to <span>8</span> of <span>16</span> entries</p>
                <ul class="pagination m-0 ms-auto">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                            <!-- Download SVG icon from http://tabler-icons.io/i/chevron-left -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <polyline points="15 6 9 12 15 18"></polyline>
                            </svg>
                            prev
                        </a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item active"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">4</a></li>
                    <li class="page-item"><a class="page-link" href="#">5</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">
                            next
                            <!-- Download SVG icon from http://tabler-icons.io/i/chevron-right -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <polyline points="9 6 15 12 9 18"></polyline>
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
@section('modal')
<div class="modal modal-blur fade" id="modal-kendaraan" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Angkutan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if(count($qrcode) > 0)
                <div class="bg-blue-lt border-dashed p-2 rounded border mb-3">
                    Qr Code Tersedia
                </div>
                @else
                <div class="bg-red-lt border-dashed p-2 rounded border mb-3">
                    <div class="d-flex align-items-center" style="gap: 10px;">
                        <span>Qr Code Tidak Tersedia, silahkan tambahkan Qr Code terlebih dahulu</span>
                        <a href="{{ route('qrcode', ['key' => 5]) }}" class="btn btn-primary ms-auto">
                            Tambah Qr Code
                        </a>
                    </div>
                </div>
                @endif
                <div class="mb-3">
                    <label class="form-label">Jenis Kendaraan</label>
                    <input type="text" class="form-control" name="jenis" placeholder="..." required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nomor Kendaraan</label>
                    <input type="text" class="form-control" name="nomor" placeholder="..." required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <textarea class="form-control" rows="3" name="deskripsi" placeholder="..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                    Batal
                </a>
                <a href="#" class="btn btn-primary ms-auto" onclick="saveKendaraan()">
                    <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <line x1="12" y1="5" x2="12" y2="19" />
                        <line x1="5" y1="12" x2="19" y2="12" />
                    </svg>
                    Simpan
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
<script>
    let _modal_kendaraan = '#modal-kendaraan';
    let _modal_kendaraan_jenis = _modal_kendaraan + ' input[name="jenis"]';
    let _modal_kendaraan_nomor = _modal_kendaraan + ' input[name="nomor"]';
    let _modal_kendaraan_deskripsi = _modal_kendaraan + ' textarea[name="deskripsi"]';
    let _modal_kendaraan_path = _modal_kendaraan + ' input[name="path"]';

    const openModalKendaraan = () => {
        $(_modal_kendaraan).modal("show");
    }

    const closeModal = () => {
        $(_modal_kendaraan).modal("hide");
    }

    const getModalData = () => {
        let jenis = $(_modal_kendaraan_jenis).val();
        let nomor = $(_modal_kendaraan_nomor).val();
        let deskripsi = $(_modal_kendaraan_deskripsi).val();

        let data = {
            jenis: jenis,
            nomor: nomor,
            deskripsi: deskripsi,
        };

        return data;
    }

    const saveKendaraan = () => {
        let data = getModalData();
        requestServer({
            url: url + '/api/data/kendaraan/store',
            data: data,
            onLoader: true,
            onSuccess: function(value) {
                close_swal(true, 'Berhasil tambah kendaraan', 'success');
                closeModal();
                reloadPage();
            },
        });
    }
</script>
@endpush