@extends('layouts.app')
@section('content')
<div class="container py-4">
    <div class="w-100">
        @php
            $artikelContent = $artikel->artikel;
            $output = $artikelContent;
            
            // Cek apakah string adalah valid JSON
            $firstChar = trim($artikelContent)[0] ?? '';
            if ($firstChar === '{' || $firstChar === '[' || $firstChar === '"') {
                $decoded = json_decode($artikelContent, true);
                
                if (json_last_error() === JSON_ERROR_NONE && $decoded !== null) {
                    // Jika hasil decode adalah string, gunakan string tersebut
                    if (is_string($decoded)) {
                        $output = $decoded;
                    } else {
                        // Jika object/array, convert kembali ke string
                        $output = json_decode($artikelContent);
                    }
                }
            }
        @endphp
        {!! $output !!}
    </div>
</div>
@endsection