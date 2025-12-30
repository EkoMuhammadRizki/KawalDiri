@extends('layouts.main')

@section('content')
@include('components.hero')

@include('components.features')

@include('components.testimonials')

<section class="section-padding">
    <div class="container">
        <div class="bg-dark text-white rounded-5 p-5 text-center position-relative overflow-hidden shadow-lg">
            <div class="position-absolute opacity-25" style="top: 0; left: 0; width: 100%; height: 100%; background: url('https://www.transparenttextures.com/patterns/cubes.png');"></div>
            <div class="position-relative z-1">
                <h2 class="display-4 font-black mb-4">Siap Jadi Versi <br><span class="text-warning">Terbaik Dirimu?</span></h2>
                <p class="lead mb-5 opacity-75">Gabung sama ribuan anak muda yang udah ambil kendali penuh atas waktu dan uang mereka. Cobain gratis 14 hari.</p>
                <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                    <a href="{{ route('register') }}" class="btn btn-white btn-lg bg-white text-dark fw-bold px-5 rounded-4">Mulai Sekarang</a>
                    <button class="btn btn-outline-light btn-lg border-2 fw-bold px-5 rounded-4">Lihat Harga</button>
                </div>
                <p class="mt-4 small opacity-50">Tidak butuh kartu kredit. Batalkan kapan saja.</p>
            </div>
        </div>
    </div>
</section>
@endsection