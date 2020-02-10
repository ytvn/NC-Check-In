@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-3">
        <div class="info-box mb-3 bg-info">
            <span class="info-box-icon"><i class="fas fa-check-double"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Đang điểm danh</span>
                <span class="info-box-number">{{ $room->name }}</span>
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="info-box mb-3 bg-warning">
            <span class="info-box-icon"><i class="fas fa-tag"></i></span>
            
            <div class="info-box-content">
                <span class="info-box-text">Tổng số đại biểu được triệu tập</span>
                <span class="info-box-number">{{ $room->seats->count() }}</span>
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="info-box mb-3 bg-success">
            <span class="info-box-icon"><i class="far fa-heart"></i></span>
            
            <div class="info-box-content">
                <span class="info-box-text">Số đại biểu có mặt</span>
                <span class="info-box-number">{{ $room->seats()->where("state", true)->count() }}</span>
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="info-box mb-3 bg-danger">
            <span class="info-box-icon"><i class="far fa-heart"></i></span>
            
            <div class="info-box-content">
                <span class="info-box-text">Số đại biểu vắng mặt</span>
                <span class="info-box-number">{{ $room->seats()->where("state", false)->count() }}</span>
            </div>
        </div>
    </div>
</div>

<div class="row mt-5">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Thống kê đại biểu theo đơn vị</h3>
            </div>
            <div class="card-body">
                <table id="delegatesSummaryByFaculty" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Khoa</th>
                            <th>Triệu tập</th>
                            <th>Có mặt</th>
                            <th>Vắng mặt</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($delegatesByFaculty as $facultyName => $faculty)
                        <tr>
                            <td>{{ $facultyName}}</td>
                            <td>{{ $faculty->count() }}</td>
                            <td>
                                <div class="card card-outline collapsed-card p-0 m-0">
                                    <div class="card-header">
                                        <h3 class="card-title">{{ $faculty->where("state", true)->count() }} đại biểu</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>  
                                    <div class="card-body">
                                        {!! $faculty->where("state", true)->map(function($seat){return $seat->delegate->id . " - ".$seat->delegate->name . " (Ghế ". $seat->seat.")";})->implode("<br/>") !!}
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="card card-outline collapsed-card p-0 m-0">
                                    <div class="card-header">
                                        <h3 class="card-title">{{ $faculty->where("state", false)->count() }} đại biểu</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>  
                                    <div class="card-body">
                                        {!! $faculty->where("state", false)->map(function($seat){return $seat->delegate->id . " - ".$seat->delegate->name . " (Ghế ". $seat->seat.")";})->implode("<br/>") !!}
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<div class="row mt-5">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Thống kê đại biểu</h3>
            </div>
            <div class="card-body">
                <table id="delegatesSummary" class="table table-bordered table-hover display compactt">
                    <thead>
                        <tr>
                            <th>mã đại biểu</th>
                            <th>MSSV</th>
                            <th>họ và tên</th>
                            <th>khoa</th>
                            <th>tổ thảo luận</th>
                            <th>ghế</th>
                            <th>trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($room->seats as $seat)
                        <tr>
                            <td>{{ $seat->delegate->id }}</td>
                            <td>{{ $seat->delegate->student_id }}</td>
                            <td>{{ $seat->delegate->name }}</td>
                            <td>{{ $seat->delegate->faculty }}</td>
                            <td>{{ $seat->delegate->group }}</td>
                            <td>{{ $seat->seat }}</td>
                            <td>{{ $seat->state ? "Có mặt" : ($seat->activities->count() > 0 ? "Ra ngoài" : "Chưa điểm danh") }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection


@section('script') 
<script>
    $('#delegatesSummary thead tr').clone(true).appendTo( '#delegatesSummary thead' );
    $('#delegatesSummary thead tr:eq(1) th').each( function (i) {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Tìm theo '+title+'" />' );
        
        $( 'input', this ).on( 'keyup change', function () {
            if ( table.column(i).search() !== this.value ) {
                table
                .column(i)
                .search( this.value )
                .draw();
            }
        } );
    } );
    
    var table = $('#delegatesSummary').DataTable( {
        orderCellsTop: true,
        fixedHeader: true
    } );
</script>   
@endsection