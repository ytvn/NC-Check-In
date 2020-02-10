@extends('layouts.app')

@section('content')
@if(!$rooms)
<div class="row justify-content-center pt-5">
    <div class="col-6">
        <div class="alert alert-primary" role="alert">
            <h3 class="text-center">No room is available.</h3>
        </div>
    </div>
</div>
@endif

<div class="row justify-content-center">
    @foreach ($rooms as $room)
        <div class="col-ms-12 col-md-6 col-lg-4 col-xl-3">
            <form action="/room/{{ $room->active ? "deactivate" : "activate" }}" method="POST">
                <input type="hidden" name="room-id" value="{{ encrypt($room->id) }}">
                @csrf
                <div class="small-box bg-{{ $room->active ? "primary" : "warning" }}">
                    <div class="inner">
                        <h3>{{ $room->name }}</h3>
                        <p>
                            <strong>Row:</strong> {{ $room->num_of_rows }}<br/>
                            <strong>Col:</strong> {{ $room->num_of_columns }}<br/>
                            <strong>State:</strong> {{ $room->active ? "Activated" : "Ready" }}<br/>
                            <strong>Seats:</strong> {{ $room->seats->count() }}<br/>
                        </p>
                    </div>
                    <div class="icon room-clear" title="Delete data of this room" data-room="{{ encrypt($room->id) }}">
                        <i class="fas fa-broom"></i>
                    </div>
                        
                    <a class="small-box-footer" onclick="javascript:$(this).parents('form').submit()" href="#">
                        {{ $room->active ? "Deactivate" : "Activate" }} <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </form>
        </div>

    @endforeach
</div>

@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $(".room-clear").click(function () {
                roomId = $(this).data("room");
                $.Swal.fire({
                    title: 'Confirmation',
                    html: 'Thao tác này sẽ xoá toàn bộ lịch sử điểm danh trên phòng này. Tuy nhiên, sẽ không xoá danh sách tham gia, chỗ ngồi trên của phòng.',
                    icon: 'warning',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Xoá lẹ'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: "/room/clear",
                            type: "POST",
                            data: {
                                room: roomId
                            }
                        }).done(function(data){
                            if(data.success){
                                $.Swal.fire(
                                    'Cleared!',
                                    'This room has been cleared.',
                                    'success'
                                ).then(()=>{
                                    location.reload();
                                });
                            }
                        }).fail(function(xhr, status, e){
                            $.Swal.fire(
                                    'Error!',
                                    'An error occurred when clearing this room.',
                                    'error'
                                );
                        })
                    }
                })
            })
            
        });
    </script>
@endsection