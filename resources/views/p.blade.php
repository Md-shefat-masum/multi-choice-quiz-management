<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{request()->branch_code}}</title>
    <style>
        @font-face{
            src: url("/solaiman.ttf");
            font-family: 'bangla';
        }
        html, body {
            width:  595pt;
            height: 842pt;
            margin: auto;
            font-weight: bold;
        }
        body{
            margin: 0;
            font-family: 'bangla';
        }
        .list{
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 28px;
        }
        .item{
            height: calc( 842pt / 2 - 25px);
            overflow: hidden;
            position: relative;
        }
        .name{
            position: absolute;
            top: 440px;
            left: 126px;
        }
        h3{
            position: absolute;
            top: 10px;
            left: 10px;
        }
        .branch_name{
            position: absolute;
            top: 473px;
            left: 126px;
        }
        img{
            width: 100%;
        }
        .list_{{ count($data)-1 }} .name{
            position: fixed;
            color: rgb(61, 23, 23);
            top: calc( 30% + 70px);
            left: 10px;
            z-index: 9999;
        }
        @page {
            size: 7in 9.25in;
            margin: 0;
        }
        @media print {
            .page-break {
                height: 0;
                page-break-before: always;
                margin: 0;
                border-top: none;
            }
            h3,
            h2{
                display: none;
            }
            .list_{{ count($data)-1 }} .name{
                position: absolute;
                top: 440px;
                left: 126px;
            }
        }
        h2{
            position: fixed;
            top: 30%;
            left: 10px;
            background: black;
            color: white;
            z-index: 9999;
        }
    </style>
</head>
<body>
    <h2>{{request()->branch_code}}: {{ count($data) }}, {{ $data[count($data)-1]->name }}</h2>
    @php
        $i=0;
    @endphp
    @for ($f=0; $f<ceil(count($data)/4); $f++)
        <div class="list">
            @for ($g = 0; $g < 4; $g++)
                @isset($data[$i])
                    <div class="item list_{{$i}}">
                        <img src="/bg.jpg" alt="">
                        <div class="name">{{ $data[$i]->name }}</div>
                        <div class="branch_name">{{ $data[$i++]->branch_name }}</div>
                    </div>
                @endisset
            @endfor
        </div>
        <div class="page-break"></div>
    @endfor
    <script defer>
        document.title="{{request()->branch_code}}";
        window.print();
    </script>
</body>
</html>

