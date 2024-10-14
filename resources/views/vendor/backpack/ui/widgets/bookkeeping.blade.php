<div class="card mb-4">
    <div class="card-body d-flex justify-content-start">
        <div class="col-auto pe-md-5">
            <div class="row align-items-center">
                <div class="col-auto">
                        <span class="bg-primary text-white avatar">
                          <i class="la la-wallet fs-2"></i>
                        </span>
                </div>
                <div class="col">
                    <div class="font-weight-medium">
                        Cash
                    </div>
                    <div class="text-secondary fw-bold {{ $widget['content']['cash'] < 0 ? 'text-danger' : ($widget['content']['cash'] < 500 ? 'text-waring' : 'text-success') }}">
                        €{{ $widget['content']['cash'] }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-auto ps-md-5">
            <div class="row align-items-center">
                <div class="col-auto">
                        <span class="bg-warning text-white avatar">
                          <i class="la la-bank fs-2"></i>
                        </span>
                </div>
                <div class="col">
                    <div class="font-weight-medium">
                        Bank
                    </div>
                    <div class="text-secondary fw-bold {{ $widget['content']['bank'] < 0 ? 'text-danger' : ($widget['content']['bank'] < 500 ? 'text-waring' : 'text-success') }}">
                        €{{ $widget['content']['bank'] }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-auto ps-md-5">
            <div class="row align-items-center">
                <div class="col-auto">
                        <span class="bg-success text-white avatar">
                          <i class="la la-users fs-2"></i>
                        </span>
                </div>
                <div class="col">
                    <div class="font-weight-medium">
                        Students
                    </div>
                    <div class="text-secondary fw-bold">
                        €{{ $widget['content']['tuition_to_pay'] }}
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
