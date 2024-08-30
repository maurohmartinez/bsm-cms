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
                    <div class="text-secondary">
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
                    <div class="text-secondary">
                        €{{ $widget['content']['bank'] }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
