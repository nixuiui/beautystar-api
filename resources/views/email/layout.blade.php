
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700&display=swap" rel="stylesheet">
    {{-- <title>Document</title> --}}
    <style>
        * {
            box-sizing: border-box;
        }
        body{
            font-family: 'Open Sans', sans-serif;
            background: #FEFEFE;
            font-size: 14px;
            margin: 0px;
        }

        .container-mail{
            width: 600px;
            margin: 0 auto;
            background: #FFF;
            border-top: 2px solid #d97092;
            border-right: 1px solid #efefef;
            border-left: 1px solid #efefef;
            border-bottom: 1px solid #efefef;
        }

        .header {
            background: #FFF;
            border-bottom: 1px solid #EFEFEF;
        }

        .footer {
            background: #F5F5F5;
            border-top: 2px solid #d97092;
            padding: 25px;
            text-align: center;
        }

        .logo {
            text-align: center;
        }

        .logo img {
            width: 250px;
            height: auto;
            padding: 15px 10px;
            margin: 0 auto;
        }

        .sign {
            padding: 25px;
            font-size: 14px;
            color: #666 !important;
        }

        .content {
            padding: 25px;
        }

        .content > .title {
            font-family: 'Open Sans', sans-serif;
            font-size: 17px;
            font-weight: 400;
            letter-spacing: 1px;
            letter-spacing: 1px;
        }

        .title {
            margin-bottom: 25px;
        }

        .sub-title {
            margin-bottom: 40px;
        }

        .content > p {
            /* text-align: left; */
            font-family: 'Open Sans', sans-serif;
            font-size: 14px;
        }
    
        .link {
            padding: 10px 25px;
            text-decoration: none;
            font-family: 'Open Sans', sans-serif;
            text-align: center;
            background-color: #ff617c;
            color: #fff !important;
            border-radius: 5px; 
            margin-top: 30px; 
            margin:0 auto;
            font-size: 15px;
            letter-spacing: 1px;
        }

        table {
            font-family: 'Open Sans', sans-serif;
            font-size: 13.5px;
            border-collapse: collapse;
            width: 100%;
        }

        td {
            padding:10px 10px;
        }
        
        .text-center {
            text-align: center;
        }

        .abu {
            background-color: #dadada;
            color: #000 !important;
        }
        .row {
            display: inline-block;
            max-width: 100%;
            width: 100%;
            font-size: 15px;
        }
        .left {
            width: 65%;
            display: inline-block;
            padding:5px 5px;
            line-height: 25px;
        }
        .right {
            width: 29%;
            display: inline-block;
            padding:5px 5px;
            float: right;
            text-align: right;
            line-height: 25px;
        }
        .border-btm{
            border-bottom:2px solid #696969;
        }
        .right-sub {
            text-align: right;
        }

        .right-sub > p > span {
            margin-right: 30px;
            font-size: 14px;
        }
        .btn-bayar {
            background-color: #d97092;
            padding:10px 40px;
            width: 100%;
            text-decoration: none;
            color: #fff  !important;
            font-size: 14px;
            border-radius:5px;
            display: block;
            font-weight: 600;
            letter-spacing: 1px;
        }
        .btn-bayar:hover {
            text-decoration: none;
            font-weight: 600;
        }
        .btn {
            width: 100%;
            text-align: center;
            margin-top:30px;
        }
        .mb-20 {
            margin-bottom: 20px;
        }
        .mb-30 {
            margin-bottom: 30px;
        }
        .mb-40 {
            margin-bottom: 40px;
        }

        .card {
            border: 1px solid #DFDFDF;
            border-radius: 3px;
        }
        .card .card-header {
            padding: 10px;
            background: #EFEFEF;
        }
        .card .card-body {
            line-height: 25px;
            padding: 10px;
        }

        .border-top {
            border-top: 1px solid #DFDFDF;
        }

        .list-item .left, .list-item .right {
            padding: 15px 0;
        }

    </style>
    @yield('style')
</head>
<body>
    
    <div class="container-mail">
        <div class="header">
            <div class="logo">
                <a href="{{ env('APP_URL_WEB') }}">
                    <img src="{{ env('APP_URL_WEB') . '/image/logo_text.png' }}" alt="BeautyStar-Logo">
                </a>
            </div>
        </div>
        
        @yield('content')

        <div class="sign">
            Happy Makeup, <br>
            Beauty Star Team.
        </div>

        <div class="footer">
            <strong>Temukan kami</strong>
            <p>
                &copy; 2019 Beauty Star
            </p>
        </div>
    </div>

</body>
</html>