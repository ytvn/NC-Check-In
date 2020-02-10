<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <style>
        .html{
            font-size: 20px;
        }
        body {
            background-color: rgba(0, 0, 0, 0.4);
            color : white;
            font: "Roboto","Source Sans Pro", -apple-system, BlinkMacSystemFont, "Segoe UI";
        }

        .name{
            text-align:center;
        }

        h3{
            font-size: 2rem;
            padding-bottom: 10px;
        }

        .seat{
            font-size: 2rem;
            padding-bottom: 5px;
        }


    </style>
</head>
<body>
    <div class="content">

        <h3 class="name">{{ $name }}</h3>
        <table style="align:center">
            <tr>
                <td style="align: center;vertical-align:center"><div class="seat"><strong>{{ $seat }}</strong></div></td>
                <td style="align: left;vertical-align:center"><div>Khoa: {{ $faculty }}</div>
                    <div>Điểm danh thành công: <strong>{{ $room->name }}</strong></div>
                </td>
            </tr>
        </table>
        
        
    </div>
</body>
</html>