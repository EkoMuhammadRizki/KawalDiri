    <nav class="navbar navbar-expand-lg sticky-top py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="#">
                <div class="bg-primary rounded-3 p-1 d-flex align-items-center justify-content-center text-white" style="width: 35px; height: 35px;">
                    <span class="material-symbols-outlined fs-5">grid_view</span>
                </div>
                <span class="fw-bold fs-4 tracking-tighter">KawalDiri</span>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="#produktivitas">Produktivitas</a></li>
                    <li class="nav-item"><a class="nav-link" href="#keuangan">Keuangan</a></li>
                    <li class="nav-item"><a class="nav-link" href="#testimoni">Cerita Sukses</a></li>
                </ul>
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('login') }}" class="text-decoration-none fw-bold text-dark small">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-kd-primary">Mulai Gratis</a>
                </div>
            </div>
        </div>
    </nav>