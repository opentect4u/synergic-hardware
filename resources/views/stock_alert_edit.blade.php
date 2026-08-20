@extends('common.master')
@section('content')

<div class="content-wrapper">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Edit Stock Alert Threshold</h4>
            <form method="POST" action="{{ route('stock.alert.update',['mc_id'=>$threshold->mc_id ?? '']) }}">
                @csrf
                <div class="form-group">
                    <label for="mc_id">Device</label>
                    @php $deviceName = '';
                        foreach($machines as $m) { if(($threshold->mc_id ?? null) == $m->mc_id) { $deviceName = $m->mc_type; break; } }
                    @endphp
                    <input type="text" class="form-control" value="{{ $deviceName }}" disabled>
                    <input type="hidden" name="mc_id" value="{{ $threshold->mc_id ?? '' }}">
                </div>

                <div class="form-group">
                    <label for="stk_val">Quantity</label>
                    <input type="number" class="form-control" id="stk_val" name="stk_val" min="0" value="{{ old('stk_val') ?? ($threshold->stk_val ?? '') }}" required>
                    @error('stk_val')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('stock.alert') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>

@endsection
