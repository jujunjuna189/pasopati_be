@extends('layouts.app_template')
@section('content')
<div class="row">
    <div class="col-md-9">
        <div class="d-flex" style="gap: 3px;">
            @foreach($keys as $val)
            <div>
                <a href="{{ route('qrcode', ['key' => $val->key]) }}" class="btn bg-blue-lt border-bottom-0 rounded-0 rounded-top">{{ $val->label }}</a>
            </div>
            @endforeach
        </div>
        <div class="card">
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
                            <input type="text" class="form-control form-control-sm" aria-label="Search invoice">
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
                            <th>Judul</th>
                            <th>Kode</th>
                            <th style="width: 10rem;" class="bg-dark text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($qrcode as $val)
                        <tr>
                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select invoice"></td>
                            <td>{{ $no++ }}</td>
                            <td>{{ $val->title }}</td>
                            <td>{{ $val->code ?? '-' }}</td>
                            <td>
                                <a href="#" class="btn btn-icon border-dashed rounded-10">
                                    <!-- Download SVG icon from http://tabler-icons.io/i/update -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit-circle" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M12 15l8.385 -8.415a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3z"></path>
                                        <path d="M16 5l3 3"></path>
                                        <path d="M9 7.07a7.002 7.002 0 0 0 1 13.93a7.002 7.002 0 0 0 6.929 -5.999"></path>
                                    </svg>
                                </a>
                                <a href="{{ route('generate', ['code' => $val->code]) }}" class="btn btn-icon border-dashed rounded-10">
                                    <!-- Download SVG icon from http://tabler-icons.io/i/print -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-printer" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2"></path>
                                        <path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4"></path>
                                        <rect x="7" y="13" width="10" height="8" rx="2"></rect>
                                    </svg>
                                </a>
                                <span onclick="deleteQrCode('{{ $val->id }}')" class="btn btn-icon border-dashed bg-red-lt rounded-10">
                                    <!-- Download SVG icon from http://tabler-icons.io/i/print -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M4 7l16 0" />
                                        <path d="M10 11l0 6" />
                                        <path d="M14 11l0 6" />
                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                    </svg>
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="d-flex justify-content-center">
            <div class="d-inline-block">
                <div class="card rounded-20 border-0">
                    <div class="card-body" id="form-add">
                        <h2 class="fw-bold mb-3">Generate QrCode</h2>
                        <input type="number" hidden name="key" class="form-control rounded-10" value="{{ $current_key->key }}" placeholder="...">
                        <div class="form-group">
                            <label for="title">Judul</label>
                            <input type="text" name="title" class="form-control rounded-10" value="{{ $current_key->label }}" readonly placeholder="...">
                        </div>
                        <div class="form-group mt-2">
                            <label for="title">Kode</label>
                            <input type="text" name="code" class="form-control rounded-10" placeholder="...">
                        </div>
                        <div class="form-group mt-3">
                            <button type="submit" onclick="saveGenerateQrCode()" class="btn bg-blue-lt border-dashed w-100">Buat Kode</button>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="card rounded-20 border-0">
                        <div class="card-body">
                            <h3>Keterangan</h3>
                            <ul>
                                <li class="p-2"><span class="fw-bold">01</span> - Perizinan</li>
                                <li class="p-2"><span class="fw-bold">04</span> - Ranpur</li>
                                <li class="p-2"><span class="fw-bold">05</span> - Angkutan</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
<script>
    let _form_add = {
        title: '#form-add input[name="title"]',
        code: '#form-add input[name="code"]',
        key: '#form-add input[name="key"]',
    };


    const getModalData = () => {
        let title = $(_form_add.title).val();
        let code = $(_form_add.code).val();
        let key = $(_form_add.key).val();

        let data = {
            title: title,
            code: '0' + key + '-' + code,
            key: key,
        };

        return data;
    }

    const saveGenerateQrCode = () => {
        let data = getModalData();
        requestServer({
            url: url + '/api/qrcode/store',
            data: data,
            onLoader: true,
            onSuccess: function(value) {
                close_swal(true, 'Berhasil generate qrcode', 'success');
                reloadPage();
            },
        });
    }

    const deleteQrCode = (id) => {
        requestServer({
            url: url + '/api/qrcode/delete',
            data: {
                id: id
            },
            onLoader: true,
            onSuccess: function(value) {
                close_swal(true, 'Berhasil hapus qrcode', 'success');
                reloadPage();
            },
        });
    }
</script>
@endpush
@push('script')
<script>
    const qrcodeUpdate = (code) => {

    }
</script>
@endpush