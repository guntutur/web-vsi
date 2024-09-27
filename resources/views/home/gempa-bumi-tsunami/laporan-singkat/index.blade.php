@extends('template.layout')

@section('title', 'Laporan Singkat Gempa Bumi & Tsunami')

@push('styles')
<link href="{{ asset('css/selectric.css') }}" rel="stylesheet">
@endpush

@section('content')
<!-- SAB BANNER START-->
<div class="sab_banner overlay">
    <div class="container">
        <div class="sab_banner_text">
            <h2>Laporan Singkat Gempa Bumi & Tsunami</h2>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Gempa Bumi & Tsunami</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('gempa-bumi-tsunami.laporan-singkat.index') }}">Laporan Singkat Gempa Bumi & Tsunami</a></li>
            </ul>
        </div>
    </div>
</div>
<!-- SAB BANNER END-->
<div class="city_blog2_wrap team" style="background: #f0f2f7">
    <div class="container">
        <div id="app">
            <news 
                apiurl="{{ route('gempa-bumi-tsunami.laporan-singkat.get') }}" 
                detailurl="{{ route('gempa-bumi-tsunami.laporan-singkat.detail', '') }}" 
            ></news>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/jquery-filterable.js') }}"></script>
<script src="{{ asset('js/jquery.nice-select.min.js') }}"></script>
<script src="{{ asset('js/web/collab/index.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var collabHandle = CollabHandler.construct({
            maxPicField: 2,
            maxInvolvedField: 5
        });
        collabHandle.init();
    });

</script>
@endpush
