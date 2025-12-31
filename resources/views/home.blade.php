@extends('layouts.main')

@section('content')
@include('components.hero')

@include('components.features')

@include('components.testimonials')

<style>
    @keyframes gradientAnimation {
        0% {
            background-position: 0% 50%;
        }

        50% {
            background-position: 100% 50%;
        }

        100% {
            background-position: 0% 50%;
        }
    }

    .animated-gradient {
        background: linear-gradient(135deg, #5b47e5, #a855f7, #ec4899, #f97316, #a855f7, #5b47e5);
        background-size: 300% 300%;
        animation: gradientAnimation 8s ease infinite;
    }
</style>

<section class="section-padding">
    <div class="container">
        <div class="animated-gradient rounded-5 p-5 text-center position-relative overflow-hidden" style="min-height: 350px; display: flex; align-items: center; justify-content: center;">
            <!-- Decorative elements -->
            <div class="position-absolute" style="top: 10%; left: 5%; width: 150px; height: 150px; background: rgba(255, 255, 255, 0.1); border-radius: 50%; filter: blur(40px);"></div>
            <div class="position-absolute" style="bottom: 10%; right: 5%; width: 200px; height: 200px; background: rgba(255, 255, 255, 0.1); border-radius: 50%; filter: blur(50px);"></div>

            <div class="position-relative z-1">
                <h2 class="display-4 fw-bold mb-4 text-white">
                    Siap Jadi Versi <br><span style="color: #fbbf24;">Terbaik Dirimu?</span>
                </h2>
                <p class="lead mb-4 text-white" style="max-width: 650px; margin: 0 auto; opacity: 0.95;">
                    Gabung sama ribuan anak muda yang udah ambil kendali penuh atas waktu dan uang mereka. 100% Gratis selamanya!
                </p>
                <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center mb-3">
                    <a href="{{ route('register') }}" class="btn btn-lg fw-bold px-5 py-3 rounded-pill" style="background: white; color: #5b47e5; border: none; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 15px 40px rgba(0, 0, 0, 0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(0, 0, 0, 0.2)'">
                        Mulai Sekarang
                    </a>
                </div>
                <small class="text-white" style="opacity: 0.8;">Tidak butuh kartu kredit. 100% Gratis, tanpa biaya tersembunyi.</small>
            </div>
        </div>
    </div>
</section>
@endsection