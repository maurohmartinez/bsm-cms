<div class="col-12 mb-3">
    @if($yearId)
        <div class="card" wire:loading.remove>
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <h3 class="mb-0 fw-light">Total lessons <strong>{{ $count['total'] }} for year</h3>
                    <select wire:model.live="yearId" class="form-control form-control-sm ms-1">
                        @foreach(\App\Models\Year::all() as $year)
                        <option value="{{ $year->id }}">{{ $year->name }}</option>
                        @endforeach
                    </select>
                </div>
                @if($count['total'] !== $count['total_from_subjects'])
                    <p class="text-danger fw-light">
                        <i class="la la-warning me-1"></i>Please fix the discrepancy in the amount of hours offered by subjects — <strong>{{ $count['total_from_subjects'] }}</strong> instead of <strong>{{ $count['total'] }}</strong>!
                    </p>
                @endif
                <div class="progress progress-separated my-3">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $count['first_semester_percentage_available'] }}%" aria-label="Regular"></div>
                    <div class="progress-bar bg-secondary opacity-10" role="progressbar" style="width: {{ 50 - $count['first_semester_percentage_available'] }}%" aria-label="System"></div>
                    <div class="progress-bar bg-info" role="progressbar" style="width: {{ $count['second_semester_percentage_available'] }}%" aria-label="System"></div>
                    <div class="progress-bar bg-secondary opacity-10" role="progressbar" style="width: {{ 50 - $count['second_semester_percentage_available'] }}%" aria-label="System"></div>
                </div>
                <div class="row">
                    <div class="col-auto d-flex align-items-center pe-2">
                        <span class="legend me-2 bg-primary"></span>
                        <span>Assigned First Semester</span>
                        <span class="d-none d-md-inline d-lg-none d-xxl-inline ms-2 text-secondary">{{ $count['first_semester_total']['assigned'] }}</span>
                    </div>
                    <div class="col-auto d-flex align-items-center px-2">
                        <span class="legend me-2"></span>
                        <span>Available First Semester</span>
                        <span class="d-none d-md-inline d-lg-none d-xxl-inline ms-2 text-secondary">{{ $count['first_semester_total']['available'] }}</span>
                    </div>
                    <div class="col-auto d-flex align-items-center px-2">
                        <span class="legend me-2 bg-info"></span>
                        <span>Assigned Second Semester</span>
                        <span class="d-none d-md-inline d-lg-none d-xxl-inline ms-2 text-secondary">{{ $count['second_semester_total']['assigned'] }}</span>
                    </div>
                    <div class="col-auto d-flex align-items-center ps-2">
                        <span class="legend me-2"></span>
                        <span>Available Second Semester</span>
                        <span class="d-none d-md-inline d-lg-none d-xxl-inline ms-2 text-secondary">{{ $count['second_semester_total']['available'] }}</span>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div wire:loading class="card p-5 w-100">
        <div class="d-flex align justify-content-center align-items-center">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading details...</span>
            </div>
            <span class="ms-2">Loading details...</span>
        </div>
    </div>
</div>
