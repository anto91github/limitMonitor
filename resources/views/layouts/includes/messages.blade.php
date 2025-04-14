@if(Session::get('success', false))
    <?php $data = Session::get('success'); ?>
    @if (is_array($data))
        @foreach ($data as $msg)
            <div class="alert alert-success" role="alert">
                <i class="fa fa-check"></i>
                {{ $msg }}
            </div>
        @endforeach
    @else
        <div class="alert alert-success" role="alert">
            <i class="fa fa-check"></i>
            {{ $data }}
        </div>
    @endif
@endif

@if(Session::get('error', false))
    <?php $data = Session::get('error'); ?>
    @if (is_array($data))
        @foreach ($data as $msg)
            <div class="alert alert-danger" role="alert">
                <i class="fa fa-exclamation-triangle"></i>
                {{ $msg }}
            </div>
        @endforeach
    @else
        <div class="alert alert-danger" role="alert">
            <i class="fa fa-exclamation-triangle"></i>
            {{ $data }}
        </div>
    @endif
@endif

@if(Session::get('warning', false))
    <?php $data = Session::get('warning'); ?>
    @if (is_array($data))
        @foreach ($data as $msg)
            <div class="alert alert-warning" role="alert">
                <i class="fa fa-exclamation-circle"></i>
                {{ $msg }}
            </div>
        @endforeach
    @else
        <div class="alert alert-warning" role="alert">
            <i class="fa fa-exclamation-circle"></i>
            {{ $data }}
        </div>
    @endif
@endif

@if(Session::get('info', false))
    <?php $data = Session::get('info'); ?>
    @if (is_array($data))
        @foreach ($data as $msg)
            <div class="alert alert-info" role="alert">
                <i class="fa fa-info-circle"></i>
                {{ $msg }}
            </div>
        @endforeach
    @else
        <div class="alert alert-info" role="alert">
            <i class="fa fa-info-circle"></i>
            {{ $data }}
        </div>
    @endif
@endif