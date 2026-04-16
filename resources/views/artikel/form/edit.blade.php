@extends('layouts.app_template')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header justify-content-between">
                <h3 class="card-title">Edit Artikel</h3>
                <div>
                    <a href="#" class="btn bg-blue-lt border-dashed" onclick="saveArtikel()">Simpan</a>
                </div>
            </div>
            <div class="card-body" id="form">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Judul">Judul</label>
                            <input type="text" name="judul" id="judul" class="form-control" required placeholder="..." value="{{ $artikel->judul ?? '' }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Deskripsi">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" cols="30" rows="3" class="form-control" required placeholder="...">{{ $artikel->deskripsi ?? '' }}</textarea>
                        </div>
                    </div>
                </div>
                <div style="height: 10px;"></div>
                <div id="summernote"></div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
<script>
    let _artikel_id = <?= $artikel_id ?>;
    const _summernote = '#summernote';
    const _form = '#form';
    const _formJudul = _form + ' #judul';
    const _formDeskripsi = _form + ' #deskripsi';

    $(document).ready(function() {
        // Parse artikel content dengan aman
        let rawArticle = '<?= addslashes($artikel->artikel ?? '') ?>';
        let artikelContent = null;
        
        try {
            // Coba parse jika JSON
            artikelContent = JSON.parse(rawArticle);
        } catch (e) {
            // Jika bukan JSON, gunakan as-is
            artikelContent = rawArticle;
        }
        
        let summernote = $(_summernote).summernote({
            placeholder: 'Tulis disini!...',
            height: 500, // set editor height
            minHeight: null, // set minimum height of editor
            maxHeight: null, // set maximum height of editor
            focus: true,
            lineHeights: 0.2,
            lineHeights: ['0.2', '0.3', '0.4', '0.5', '0.6', '0.8', '1.0', '1.2', '1.4', '1.5', '2.0', '3.0'],
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['fontsize', 'color', 'forecolor', 'backcolor']],
                ['font', ['fontname']],
                ['para', ['paragraph', 'hr']],
                ['style', ['ul', 'ol', 'height']],
                ['insert', ['link', 'picture', 'table', 'video']], // image and doc are customized buttons
                ['misc', ['codeview']],
            ],
        });

        // Set konten artikel
        if (artikelContent) {
            $(_summernote).summernote('code', artikelContent);
        }
    });

    const getDataArtikel = () => {
        let judul = $(_formJudul).val();
        let deskripsi = $(_formDeskripsi).val();
        let artikel = $(_summernote).summernote('code');
        
        // Validasi input
        if (!judul || !deskripsi || !artikel) {
            alert('Semua field harus diisi!');
            return null;
        }

        let data = {
            artikel_id: _artikel_id,
            judul: judul,
            deskripsi: deskripsi,
            artikel: artikel,
        };

        return data;
    }

    const saveArtikel = () => {
        let data = getDataArtikel();
        if (!data) return;
        
        console.log('Data yang akan dikirim:', data);
        
        requestServer({
            url: url + '/api/artikel/store',
            data: data,
            onLoader: true,
            onSuccess: function(value) {
                console.log('Response success:', value);
                close_swal(true, value.message || 'Berhasil update artikel', 'success');
                setTimeout(() => {
                    window.location.href = '{{ route('artikel') }}';
                }, 1500);
            },
            onError: function(error) {
                console.log('Error Response:', error);
                let errorMsg = 'Gagal mengupdate artikel';
                if (error.responseJSON && error.responseJSON.message) {
                    errorMsg = error.responseJSON.message;
                }
                close_swal(true, errorMsg, 'error');
            }
        });
    }
</script>
@endpush
