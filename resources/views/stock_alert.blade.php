@extends('common.master')
@section('content')

<div class="content-wrapper">
    <div class="card">
        <div class="card-body d-flex align-items-center justify-content-between">
            <h4 class="mt-1 mb-1">Stock Alert Qty</h4>
            <a href="{{ route('stock.alert.add') }}" class="btn btn-info d-none d-md-block">Add</a>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table id="order-listing" class="table">
                        <thead>
                            <tr>
                                <th>Sl. No.</th>
                                <th>Device</th>
                                <th>Quantity</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1;?>
                            @if(isset($items) && count($items) > 0)
                                @foreach($items as $it)
                                <tr id="tr_{{$it->mc_id}}">
                                    <td>{{$i++}}</td>
                                    <td>{{$it->mc_type}}</td>
                                    <td>{{$it->stk_val}}</td>
                                    <td>
                                        <a href="{{ route('stock.alert.edit',['mc_id'=>$it->mc_id]) }}" title="Edit"><i class="mdi mdi-table-edit" style="font-size: 25px;"></i></a>
                                        &nbsp;
                                        <a href="javascript:void(0)" onclick="Delete('{{$it->mc_id}}');" title="Delete"><i class="mdi mdi-delete" style="font-size: 25px; color:#e53535;"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr><td colspan="4">No thresholds defined.</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
function Delete(id) {
    if (!window.confirm('Are you sure you want to delete this record?')) return;

    $.ajax({
        url: "{{ route('stock.alert.delete') }}",
        method: "POST",
        data: { mc_id: id, _token: $('meta[name="csrf-token"]').attr('content') },
        success: function(data) {
            $('#tr_'+id).remove();
            alert('Successfully Deleted');
        },
        error: function() {
            alert('Delete failed');
        }
    });
}
</script>
@endsection
