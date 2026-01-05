    <section class="section-padding position-relative overflow-hidden">
        <div class="hero-blob" style="top: -100px; right: -100px;"></div>
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-5 text-center text-lg-start">
                    <div class="d-inline-flex align-items-center gap-2 bg-white border px-3 py-2 rounded-pill shadow-sm mb-4">
                        <span class="badge bg-success rounded-pill p-1"><span class="visually-hidden">Online</span></span>
                        <small class="fw-bold text-uppercase tracking-wider text-muted" style="font-size: 0.7rem;">KawalDiri 1.0 Kini Hadir</small>
                    </div>
                    <style>
                        @keyframes gradientShift {
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

                        .text-gradient-animated {
                            background: linear-gradient(90deg, #5B21B6, #3B82F6, #8B5CF6, #3B82F6, #5B21B6);
                            background-size: 300% 300%;
                            -webkit-background-clip: text;
                            -webkit-text-fill-color: transparent;
                            background-clip: text;
                            animation: gradientShift 4s ease infinite;
                        }
                    </style>
                    <h1 class="display-3 font-black lh-1 mb-4">
                        Atur Hidup. <br>
                        <span class="text-gradient-animated">Kejar Mimpi.</span>
                    </h1>
                    <p class="lead text-muted mb-5">
                        Bantu kamu tetap waras di tengah godaan checkout dan rebahan, biar hidup nggak cuma muter di niat doang tapi benar-benar jalan ke arah yang kamu mau.
                    </p>
                    <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center justify-content-lg-start">
                        <a href="{{ route('register') }}" class="btn btn-kd-gradient fs-5">Gas Mulai Gratis</a>
                    </div>
                    <div class="mt-5 d-flex align-items-center justify-content-center justify-content-lg-start gap-3">
                        <div class="avatar-group d-flex">
                            <img src="https://ui-avatars.com/api/?name=Sarah&background=random" class="rounded-circle border border-white" width="40" style="margin-right: -10px;">
                            <img src="https://ui-avatars.com/api/?name=Mark&background=random" class="rounded-circle border border-white" width="40" style="margin-right: -10px;">
                            <img src="https://ui-avatars.com/api/?name=Emily&background=random" class="rounded-circle border border-white" width="40">
                        </div>
                        <div class="small">
                            <span class="fw-bold d-block">10.000+ Pengguna Bergabung</span>
                            <span class="text-muted text-xs">Dipercaya oleh profesional muda</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="mockup-container animate-float">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="fw-bold mb-0">Ringkasan Dasbor</h5>
                            <button class="btn btn-sm btn-light fw-bold border text-primary">Tugas Baru</button>
                        </div>
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="card-stat bg-light">
                                    <div class="d-flex justify-content-between mb-3">
                                        <span class="material-symbols-outlined text-primary">check_circle</span>
                                        <span class="badge bg-success-subtle text-success" id="taskBadge">+12%</span>
                                    </div>
                                    <p class="small text-muted mb-1">Tugas Selesai</p>
                                    <h2 class="fw-black mb-0" id="taskCount">5/8</h2>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card-stat bg-light">
                                    <div class="d-flex justify-content-between mb-3">
                                        <span class="material-symbols-outlined text-success">payments</span>
                                        <span class="badge bg-success-subtle text-success" id="moneyBadge">Aman</span>
                                    </div>
                                    <p class="small text-muted mb-1">Terpakai Hari Ini</p>
                                    <h2 class="fw-black mb-0" id="moneySpent">Rp 450k</h2>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 p-4 border rounded-4 bg-white shadow-sm">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="fw-bold mb-0">Tren Mingguan</h6>
                                <span class="material-symbols-outlined text-muted fs-6">more_horiz</span>
                            </div>
                            <div class="progress" style="height: 40px; border-radius: 12px;">
                                <div class="progress-bar bg-primary" id="prodBar" style="width: 70%; transition: width 1s ease">Produktivitas</div>
                                <div class="progress-bar bg-success" id="finBar" style="width: 30%; transition: width 1s ease">Finansial</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Dashboard data yang akan di-loop
        const dashboardStates = [{
                task: '5/8',
                taskBadge: '+12%',
                money: 'Rp 450k',
                moneyBadge: 'Aman',
                prodWidth: 70,
                finWidth: 30
            },
            {
                task: '6/8',
                taskBadge: '+18%',
                money: 'Rp 320k',
                moneyBadge: 'Hemat',
                prodWidth: 55,
                finWidth: 45
            },
            {
                task: '8/8',
                taskBadge: '+25%',
                money: 'Rp 680k',
                moneyBadge: 'Tinggi',
                prodWidth: 80,
                finWidth: 20
            },
            {
                task: '3/8',
                taskBadge: '+8%',
                money: 'Rp 150k',
                moneyBadge: 'Aman',
                prodWidth: 45,
                finWidth: 55
            },
            {
                task: '7/8',
                taskBadge: '+20%',
                money: 'Rp 520k',
                moneyBadge: 'Aman',
                prodWidth: 65,
                finWidth: 35
            }
        ];

        let currentState = 0;

        function animateDashboard() {
            const state = dashboardStates[currentState];

            // Update dengan fade effect
            document.getElementById('taskCount').style.opacity = '0';
            document.getElementById('moneySpent').style.opacity = '0';

            setTimeout(() => {
                document.getElementById('taskCount').textContent = state.task;
                document.getElementById('taskBadge').textContent = state.taskBadge;
                document.getElementById('moneySpent').textContent = state.money;
                document.getElementById('moneyBadge').textContent = state.moneyBadge;

                document.getElementById('taskCount').style.opacity = '1';
                document.getElementById('moneySpent').style.opacity = '1';

                // Update progress bars
                document.getElementById('prodBar').style.width = state.prodWidth + '%';
                document.getElementById('finBar').style.width = state.finWidth + '%';
            }, 300);

            currentState = (currentState + 1) % dashboardStates.length;
        }

        // Jalankan animasi setiap 3 detik
        setInterval(animateDashboard, 3000);

        // Add transition to numbers
        document.getElementById('taskCount').style.transition = 'opacity 0.3s ease';
        document.getElementById('moneySpent').style.transition = 'opacity 0.3s ease';
    </script>