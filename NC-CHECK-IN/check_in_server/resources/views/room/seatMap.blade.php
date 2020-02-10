@extends('layouts.full')

@section('content')

<div class="d-flex flex-row justify-content-center" id="seatMap">
    <div class="d-flex flex-column mx-auto pr-3">
        <img src="/images/name.png" class="img-fluid logo-name" alt="Đại hội VI">

        <div class="d-flex flex-column notification mt-3 align-self-center h-100" style="overflow-y: scroll; min-width:50%">
        </div>
        <div class="mt-auto d-flex footer">
            <div class="references d-flex align-items-end">
                <a class="btn btn-app bg-success" id="sync">
                    <i class="fas fa-sync-alt fa-spin"></i>sync...
                </a>
                <a class="btn btn-app" href="/">
                    <i class="fas fa-home"></i> Home
                </a>
                <a class="btn btn-app" href="/">
                    <i class="fas fa-braille"></i> Statistic
                </a>
                <a class="btn btn-app" href="/room">
                    <i class="fas fa-hotel"></i> Room
                </a>
            </div>
            <div class="col d-flex justify-content-center">
                <div class="info-box mx-3">
                    <span class="info-box-icon bg-success present-delegates">{{ $seats->where("state",1)->count() }}</span>
                    <div class="info-box-content">
                        <span class="info-box-text">ĐẠI BIỂU</span>
                        <span class="info-box-number">CÓ MẶT</span>
                    </div>
                </div>
                <div class="info-box mx-3">
                    <span class="info-box-icon bg-danger absent-delegates">{{ $seats->where("state", "<>", 1)->count() }}</span>
                    <div class="info-box-content">
                        <span class="info-box-text">ĐẠI BIỂU</span>
                        <span class="info-box-number">VẮNG MẶT</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-info">
            <div class="main-footer py-2">
                <div class="float-right">
                    <strong>Đơn vị thực hiện: <a href="https://suctremmt.com">Đoàn khoa Mạng máy tính & Truyền thông</a></strong> 
                </div>
                <div class="">
                    <span class="text-danger"><strong>{{ $room->name }}</strong></span>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex map">
        <div class="card mb-0">
            <div class="card-body justify-content-center text-center">
                   <div class="bg-primary col-3 col-md-6 mx-auto p-1 mb-4 information">
                       <h4><strong>SÂN KHẤU</strong></h4>
                   </div>
                <table>
                    <tr>
                        @for($col = $numOfCol; $col >0; $col --)
                        {!! in_array($col, $colsHaveSpace) ? "<th class='px-4'></th>" :"" !!}
                        <th style="text-align:center">
                            <strong class="text-primary">{{ $col }}</strong>
                        </th>
                        @endfor
                        <th></th>
                    </tr>
                    
                    @for($row = 0; $rowChar = chr(65 + $row), $row < $numOfRow; $row ++)
                    <tr>
                        @for ($col = $numOfCol; $col > 0; $col--)
                            {!! in_array($col, $colsHaveSpace) ? '<td><i class="fas fa-long-arrow-alt-up"></i></td>' :"" !!}
                            <td class="p-1">
                                <span class="text-{{ $seats->has($rowChar.$col)? ($seats[$rowChar.$col]->state ? "success" : "danger") : "black-50" }} seat" id="seat-{{ $rowChar.$col}}">
                                    <i class="fas fa-user"></i>
                                    <span class="seat-info">
                                        {{ $seats->has($rowChar.$col) ? $seats[$rowChar.$col]->delegate->id : "" }}
                                    </span>
                                </span>
                            </td>
                        @endfor
                        <td> <strong class="text-primary">{{ $rowChar }}</strong></td>
                    </tr>
                    @endfor
                </table>
            </div>
        </div>
    </div>
</div>
@endsection


@section('script')
<script>
    let numOfCol = {{ $numOfCol }};
    let numOfRow = {{ $numOfRow }};
    let numOfColsHaveSpace = {{ count($colsHaveSpace) }};

    //Auto scale the map [For landscape screen]
    let height = $(window).height();
    let width = $(window).width();
    let unneccessaryHeight = $(".map .information").height();
    $("#seatMap .seat i").css({"font-size": ((height - 10 - unneccessaryHeight - numOfRow*15)/numOfRow) + "px"})

    //Set max heigh of notification frame
    $(document).ready(function(){
        let othersLeftSectionHeight = $(".logo-name").height() + $(".footer").height() + $(".footer-info").height();
        $(".notification").css({"max-height": (height - 20 - othersLeftSectionHeight) + "px"})
    })
</script>
<script>
    let lastTracking = "{{ $lastActivity ? encrypt($lastActivity->id) : "" }}";
    let a = 1;
    let syncSeatMap = () => {
        $.ajax({
            url: "/seat-layout/sync",
            data: {
                lastTracking: lastTracking
                },
            type: "POST"
        }).done((data)=>{
            if (data.data.length){
                lastTracking = data.lastTracking;
                data.data.forEach(seat => {
                    if(seat.action == "IN"){
                        //Blind color
                        $("#seat-"+seat.seat).removeClass("text-success text-muted text-danger").addClass("text-success");
                        setTimeout(function(){$("#seat-"+seat.seat).removeClass("text-success").addClass("text-muted")},500);
                        setTimeout(function(){$("#seat-"+seat.seat).removeClass("text-muted").addClass("text-success")},1000);
                        setTimeout(function(){$("#seat-"+seat.seat).removeClass("text-success").addClass("text-muted")},1500);
                        setTimeout(function(){$("#seat-"+seat.seat).removeClass("text-muted").addClass("text-success")},2000);
                        setTimeout(function(){$("#seat-"+seat.seat).removeClass("text-success").addClass("text-muted")},2500);
                        setTimeout(function(){$("#seat-"+seat.seat).removeClass("text-muted").addClass("text-success")},3000);
                        $(".notification").prepend('<div class="d-flex"><div class="info-box bg-success p-0 px-1"><span class="d-flex align-self-center px-3 justify-content-center" style="font-weight:900;font-size:3rem">'+seat.seat+'</span><div class="info-box-content" style="min-width:280px"><h4 class="info-box-text"><strong>'+seat.name+'</strong></h4><div class="progress"><div class="progress-bar" data-progress=100 style="width: 100%"></div></div><span class="progress-description pr-2"><strong>Khoa: </strong>'+seat.faculty+'</span></div><span class="info-box-icon p-0"><img class="rounded" src="' + (seat.image ? seat.image : "/images/delegates/default.png") + '" alt=""></span></div><a class="btn btn-app mt-auto mb-4"><i class="fas fa-sign-in-alt fa-rotate-270 text-success fa-3x"></i>IN</a></div>').fadeIn("slow")

                    }else if(seat.action == "OUT"){
                        $("#seat-"+seat.seat).removeClass("text-success text-muted text-danger").addClass("text-danger");
                        setTimeout(function(){$("#seat-"+seat.seat).removeClass("text-danger").addClass("text-muted")},500);
                        setTimeout(function(){$("#seat-"+seat.seat).removeClass("text-muted").addClass("text-danger")},1000);
                        setTimeout(function(){$("#seat-"+seat.seat).removeClass("text-danger").addClass("text-muted")},1500);
                        setTimeout(function(){$("#seat-"+seat.seat).removeClass("text-muted").addClass("text-danger")},2000);
                        setTimeout(function(){$("#seat-"+seat.seat).removeClass("text-danger").addClass("text-muted")},2500);
                        setTimeout(function(){$("#seat-"+seat.seat).removeClass("text-muted").addClass("text-danger")},3000);
                        $(".notification").prepend('<div class="d-flex"><div class="info-box bg-danger p-0 px-1"><span class="d-flex align-self-center px-3 justify-content-center" style="font-weight:900;font-size:3rem">'+seat.seat+'</span><div class="info-box-content" style="min-width:280px"><h4 class="info-box-text"><strong>'+seat.name+'</strong></h4><div class="progress"><div class="progress-bar" data-progress=100 style="width: 100%"></div></div><span class="progress-description pr-2"><strong>Khoa: </strong>'+seat.faculty+'</span></div><span class="info-box-icon p-0"><img class="rounded" src="' + (seat.image ? seat.image : "/images/delegates/default.png") + '" alt=""></span></div><a class="btn btn-app mt-auto mb-4"><i class="fas fa-sign-out-alt fa-rotate-90 text-danger fa-3x"></i>OUT</a></div>').fadeIn("slow")
                    }

                    $(".notification > div:nth-child(11)").remove();
                    //Update absent and present deligates
                    $(".present-delegates").html(data.presentDelegates);
                    $(".absent-delegates").html(data.absentDelegates);
                });
            }
            $("#sync").removeClass("bg-danger").addClass("bg-success");
        }).fail((xhr, status, e)=>{
            if(xhr.status == 419){
                location.reload();
            }
            $("#sync").removeClass("bg-success").addClass("bg-danger");
        })
    }

    let syncInterval = setInterval(syncSeatMap, 1000);
    let notificationAnimation = setInterval(() => {
        let notification = $(".notification>div");
        $.each(notification, function (key, obj) {
            let dom = $(".progress-bar", obj);
            let current = parseInt(dom.data("progress"));
            if (current <=0 ){
                $(obj).fadeOut(300, function(){ $(this).remove();});;
            }
            dom.data("progress", current-0.05);
            dom.css({width: (current-0.05) + "%"});
        })
    }, 300);

</script>
    
@endsection