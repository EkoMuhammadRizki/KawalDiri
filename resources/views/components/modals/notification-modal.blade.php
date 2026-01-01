<div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold" id="notificationModalLabel">Notifikasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-0">
                @if(isset($notifications) && $notifications->count() > 0)
                <div class="list-group list-group-flush">
                    @foreach($notifications as $notification)
                    <div class="list-group-item border-0 px-4 py-3 {{ $notification->read_at ? '' : 'bg-light' }}">
                        <div class="d-flex w-100 justify-content-between mb-1">
                            <h6 class="mb-0 fw-bold {{ $notification->read_at ? 'text-muted' : 'text-primary' }}">
                                {{ $notification->data['title'] ?? 'Pemberitahuan' }}
                            </h6>
                            <div class="d-flex align-items-center gap-2">
                                <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link text-muted p-0 ms-2" style="text-decoration: none;" title="Hapus Notifikasi">
                                        <span class="material-symbols-outlined fs-6">close</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <p class="mb-1 small text-secondary">{{ $notification->data['message'] ?? '' }}</p>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-5">
                    <span class="material-symbols-outlined text-muted fs-1 opacity-25 mb-3">notifications_off</span>
                    <h6 class="fw-bold text-muted">Tidak ada notifikasi</h6>
                    <p class="small text-muted mb-0">Anda belum memiliki pemberitahuan baru.</p>
                </div>
                @endif
            </div>
            <div class="modal-footer border-top-0 pt-0">
                @if(isset($unreadNotificationsCount) && $unreadNotificationsCount > 0)
                <form action="{{ route('notifications.markRead') }}" method="POST" class="w-100">
                    @csrf
                    <button type="submit" class="btn btn-light text-primary w-100 fw-bold rounded-3">
                        Tandai Semua Dibaca
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>