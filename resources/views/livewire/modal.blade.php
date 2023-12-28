<div class="modal modal-blur fade" id="modal-{{ $key }}" tabindex="-1" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered {{ $class ?? '' }}" role="document">
        <div class="modal-content modal-dialog-shadow">
            @yield('modal-content-' . $key)
        </div>
    </div>
</div>

@push('after_scripts')
    <script>
        new bootstrap.Modal(document.getElementById('modal-{{ $key }}'), {
            backdrop: 'static',
        });
        document.getElementById('modal-{{ $key }}').addEventListener('shown.bs.modal', (el) => {
            el.target.querySelector('.auto-focusable-input')?.focus();
        });
        document.getElementById('modal-{{ $key }}').addEventListener('hidden.bs.modal', () => {
            Livewire.dispatch('resetModal.{{ $key }}');
        });
    </script>
@endpush
