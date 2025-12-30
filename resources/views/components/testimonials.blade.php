<style>
    .testimonial-section {
        overflow: hidden;
        position: relative;
        padding: 50px 0;
        background-color: #ffffff;
    }

    .testimonial-track {
        display: flex;
        gap: 20px;
        animation: scroll 40s linear infinite;
        width: max-content;
    }

    .testimonial-card {
        width: 350px;
        flex-shrink: 0;
        background: #f8f9fa;
        border-radius: 20px;
        padding: 25px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.02);
        transition: transform 0.3s ease;
    }

    .testimonial-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 15px rgba(0, 0, 0, 0.05);
    }

    @keyframes scroll {
        0% {
            transform: translateX(0);
        }

        100% {
            transform: translateX(-50%);
        }
    }

    .testimonial-section:hover .testimonial-track {
        animation-play-state: paused;
    }
</style>

<section id="testimoni" class="section-padding bg-white overflow-hidden">
    <div class="container mb-5">
        <div class="text-center">
            <h2 class="display-5 font-black mb-3">Kata Mereka</h2>
            <p class="text-muted fs-5">Dari mereka yang sudah mulai hidup lebih teratur</p>
        </div>
    </div>

    <div class="testimonial-section">
        <div class="testimonial-track">
            <!-- 10 Dummy Cards (Repeated for seamless loop effect, actually we need duplicates to loop seamlessly, so 10 original + 10 duplicates = 20 cards) -->

            @foreach(range(1, 2) as $loop)
            <!-- Card 1 -->
            <div class="testimonial-card">
                <div class="mb-3 text-warning">
                    @for($i=0; $i<5; $i++) <span class="material-symbols-outlined icon-fill fs-5">star</span> @endfor
                </div>
                <p class="mb-4 text-muted">"Fitur ‘Keuangan’-nya life saver banget! Dulu sering boncos karena gak kecatet, sekarang semua pengeluaran ke-track rapi. Wajib coba!"</p>
                <div class="d-flex align-items-center gap-3">
                    <img src="https://ui-avatars.com/api/?name=Sarah+Amelia&background=random" class="rounded-circle" width="45">
                    <div>
                        <h6 class="fw-bold mb-0">Sarah Amelia</h6>
                        <small class="text-muted">Desainer Grafis</small>
                    </div>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="testimonial-card">
                <div class="mb-3 text-warning">
                    @for($i=0; $i<5; $i++) <span class="material-symbols-outlined icon-fill fs-5">star</span> @endfor
                </div>
                <p class="mb-4 text-muted">"Simpel tapi powerful. Gabungan to-do list sama finance tracker dalam satu aplikasi itu ide jenius. UI-nya juga bersih banget."</p>
                <div class="d-flex align-items-center gap-3">
                    <img src="https://ui-avatars.com/api/?name=Raka+Pratama&background=random" class="rounded-circle" width="45">
                    <div>
                        <h6 class="fw-bold mb-0">Raka Pratama</h6>
                        <small class="text-muted">Mahasiswa</small>
                    </div>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="testimonial-card">
                <div class="mb-3 text-warning">
                    @for($i=0; $i<5; $i++) <span class="material-symbols-outlined icon-fill fs-5">star</span> @endfor
                </div>
                <p class="mb-4 text-muted">"Productivity naik drastis sejak pake KawalDiri. Suka banget sama sistem prioritasnya, jadi tau mana yang harus dikerjain duluan."</p>
                <div class="d-flex align-items-center gap-3">
                    <img src="https://ui-avatars.com/api/?name=Fanny+Rose&background=random" class="rounded-circle" width="45">
                    <div>
                        <h6 class="fw-bold mb-0">Fanny Rose</h6>
                        <small class="text-muted">Freelancer</small>
                    </div>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="testimonial-card">
                <div class="mb-3 text-warning">
                    @for($i=0; $i<5; $i++) <span class="material-symbols-outlined icon-fill fs-5">star</span> @endfor
                </div>
                <p class="mb-4 text-muted">"Akhirnya nemu aplikasi yang ngerti kebutuhan Gen Z. Gak cuma catet tugas, tapi juga ingetin budget buat nongkrong."</p>
                <div class="d-flex align-items-center gap-3">
                    <img src="https://ui-avatars.com/api/?name=Dimas+Anggara&background=random" class="rounded-circle" width="45">
                    <div>
                        <h6 class="fw-bold mb-0">Dimas Anggara</h6>
                        <small class="text-muted">Content Creator</small>
                    </div>
                </div>
            </div>

            <!-- Card 5 -->
            <div class="testimonial-card">
                <div class="mb-3 text-warning">
                    @for($i=0; $i<5; $i++) <span class="material-symbols-outlined icon-fill fs-5">star</span> @endfor
                </div>
                <p class="mb-4 text-muted">"Tampilan dashboard-nya enak dilihat, gak bikin pusing. Laporan keuangannya juga detail banget. Top markotop!"</p>
                <div class="d-flex align-items-center gap-3">
                    <img src="https://ui-avatars.com/api/?name=Bella+Putri&background=random" class="rounded-circle" width="45">
                    <div>
                        <h6 class="fw-bold mb-0">Bella Putri</h6>
                        <small class="text-muted">Akuntan</small>
                    </div>
                </div>
            </div>

            <!-- Card 6 -->
            <div class="testimonial-card">
                <div class="mb-3 text-warning">
                    @for($i=0; $i<5; $i++) <span class="material-symbols-outlined icon-fill fs-5">star</span> @endfor
                </div>
                <p class="mb-4 text-muted">"Bantu banget buat manage project freelancing. Deadline kepegang semua, invoice juga jadi lebih teratur."</p>
                <div class="d-flex align-items-center gap-3">
                    <img src="https://ui-avatars.com/api/?name=Eko+Susilo&background=random" class="rounded-circle" width="45">
                    <div>
                        <h6 class="fw-bold mb-0">Eko Susilo</h6>
                        <small class="text-muted">Web Developer</small>
                    </div>
                </div>
            </div>

            <!-- Card 7 -->
            <div class="testimonial-card">
                <div class="mb-3 text-warning">
                    @for($i=0; $i<5; $i++) <span class="material-symbols-outlined icon-fill fs-5">star</span> @endfor
                </div>
                <p class="mb-4 text-muted">"Suka fitur dark mode-nya (kalau ada update nanti hehe). Tapi sejauh ini fitur utamanya udah solid banget."</p>
                <div class="d-flex align-items-center gap-3">
                    <img src="https://ui-avatars.com/api/?name=Gita+Savitri&background=random" class="rounded-circle" width="45">
                    <div>
                        <h6 class="fw-bold mb-0">Gita Savitri</h6>
                        <small class="text-muted">Penulis</small>
                    </div>
                </div>
            </div>

            <!-- Card 8 -->
            <div class="testimonial-card">
                <div class="mb-3 text-warning">
                    @for($i=0; $i<5; $i++) <span class="material-symbols-outlined icon-fill fs-5">star</span> @endfor
                </div>
                <p class="mb-4 text-muted">"Sangat intuitif. Gak perlu tutorial panjang lebar buat paham cara pakainya. Langsung gas ngerjain tugas."</p>
                <div class="d-flex align-items-center gap-3">
                    <img src="https://ui-avatars.com/api/?name=Hendra+Wijaya&background=random" class="rounded-circle" width="45">
                    <div>
                        <h6 class="fw-bold mb-0">Hendra Wijaya</h6>
                        <small class="text-muted">Manajer Proyek</small>
                    </div>
                </div>
            </div>

            <!-- Card 9 -->
            <div class="testimonial-card">
                <div class="mb-3 text-warning">
                    @for($i=0; $i<5; $i++) <span class="material-symbols-outlined icon-fill fs-5">star</span> @endfor
                </div>
                <p class="mb-4 text-muted">"Nabung jadi lebih konsisten karena selalu diingetin sama grafiknya. Makasih KawalDiri!"</p>
                <div class="d-flex align-items-center gap-3">
                    <img src="https://ui-avatars.com/api/?name=Indah+Permata&background=random" class="rounded-circle" width="45">
                    <div>
                        <h6 class="fw-bold mb-0">Indah Permata</h6>
                        <small class="text-muted">Ibu Rumah Tangga</small>
                    </div>
                </div>
            </div>

            <!-- Card 10 -->
            <div class="testimonial-card">
                <div class="mb-3 text-warning">
                    @for($i=0; $i<5; $i++) <span class="material-symbols-outlined icon-fill fs-5">star</span> @endfor
                </div>
                <p class="mb-4 text-muted">"Aplikasi lokal rasa internasional. Kualitas UX-nya mantap. Semoga terus dikembangkan fitur-fiturnya."</p>
                <div class="d-flex align-items-center gap-3">
                    <img src="https://ui-avatars.com/api/?name=Joko+Anwar&background=random" class="rounded-circle" width="45">
                    <div>
                        <h6 class="fw-bold mb-0">Joko Anwar</h6>
                        <small class="text-muted">Sutradara</small>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>