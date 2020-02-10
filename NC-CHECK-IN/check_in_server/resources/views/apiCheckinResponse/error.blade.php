<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        body {
            background-color: rgba(0, 0, 0, 0.4);
            color : red;
            font: "Roboto","Source Sans Pro", -apple-system, BlinkMacSystemFont, "Segoe UI";
        }

        .content{
            text-align:center;
        }

        h3{
            font-size: 2rem;
        }

        .title {

        }
    </style>
</head>
<body>
    <div class="content">
        @if(isset($title))
            <h3 class="title">{{ $title }}</h3>
        @endif
        <div>{!! $message !!}</div>
    </div>
</body>
</html>