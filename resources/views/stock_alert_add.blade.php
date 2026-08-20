@extends('common.master')
@section('content')

<div class="content-wrapper">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Add Stock Alert Threshold</h4>
            <form method="POST" action="{{ route('stock.alert.store') }}">
                @csrf
                <div class="form-group">
                    <label for="mc_type">Device</label>
                    <select class="form-control" id="mc_id" name="mc_id" required>
                        <option value="">-- Select Device --</option>
                        @foreach($machines as $m)
                            <option value="{{ $m->mc_id }}" {{ (old('mc_id') == $m->mc_id || (isset($selected) && $selected == $m->mc_id)) ? 'selected' : '' }}>{{ $m->mc_type }}</option>
                        @endforeach
                    </select>
                    @error('mc_id')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <div class="form-group">
                    <label for="qty">Quantity</label>
                    <input type="number" class="form-control" id="stk_val" name="stk_val" min="0" value="{{ old('stk_val') }}" required>
                    @error('stk_val')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{ route('stock.alert') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>

@endsection
