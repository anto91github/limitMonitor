<div class="mt-2">
    @include('layouts.includes.messages')
</div>
<div class="row">
    <div class="col-sm-6 col-lg-3">
        <div class="card mb-4">
            <div class="card-body">
                <div>Total Client</div>
                <div class="fs-4 fw-semibold">{{ $count_client }}</div>
                <div class="progress progress-thin my-2">
                </div><small class="text-medium-emphasis">Total data client yang sudah terdaftar</small>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card mb-4">
            <div class="card-body">
                <div>Total Pending Order</div>
                <div class="fs-4 fw-semibold">{{ $count_pending }}</div>
                <div class="progress progress-thin my-2">
                </div><small class="text-medium-emphasis">Total data order yang masih berstatus pending</small>
            </div>
        </div>
    </div>
</div>
