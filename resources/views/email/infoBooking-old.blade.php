
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
    {{-- <title>Document</title> --}}
    <style>
        body{
            font-family: 'Open Sans', sans-serif;
        }

        .container-mail{
            width: 600px;
            margin: 0 auto
        }

        .logo, .logo > img {
            width: 100%;
            height: 60px;
            text-align: center;
            margin-top:30px;
        }

        .logo > img {
            width: 70%;
            height: 50px;
            margin: 0 auto;
        }

        .content > .title {
            font-family: 'Open Sans', sans-serif;
            font-size: 17px;
            font-weight: 200;
            margin-top:35px;
            letter-spacing: 1px;
            text-align: center;
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
            color: #fff;
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
            color: #000;        
        }
        .row {
            display: inline-block;
            max-width: 100%;
            width: 100%;
            margin-top: -20px;
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
        }
        .border-btm{
            border-bottom:2px solid #696969;
            margin-top:-10px;
        }
        .right-sub {
            margin-top:-15px;
            text-align: right;
        }

        .right-sub > p > span {
            margin-right: 30px;
            font-size: 14px;
        }
        .btn-bayar {
            background-color: #ff617c;
            padding:10px 40px;
            width: 100%;
            text-decoration: none;
            color: #fff;
            font-size: 14px;
            border-radius:5px;
        }
        .btn {
            width: 100%;
            text-align: center;
            margin-top:30px;
        }
    </style>
</head>
<body>
    
    <div class="container-mail">
        <div class="logo">
            <img src="{{ asset('image/logo_text.png') }}" alt="BeautyStar-Logo">
        </div>

        <div class="content">
            <p class="title">Hello, Nama Mua</p>
            <p class="sub-title text-center">
                Kamu telah mendapatkan pesanan layanan kecantikan dari Nama User. <br>
                Berikut ini adalah detail Booking kamu :  
            </p>
            
            {{-- table Booking --}}
            <table>
                <tr class="abu">
                    <td class="title-table">ID Booking</td>
                    <td class="psm">:</td>
                    <td class="content">#1282732</td>
                </tr>
                <tr>
                    <td class="title-table">Nama Panggilan</td>
                    <td class="psm">:</td>
                    <td class="content">Nama User</td>
                </tr>
                <tr class="abu">
                    <td class="title-table">Email</td>
                    <td class="psm">:</td>
                    <td class="content">aiuosdha89sd6@gmail.com</td>
                </tr>
                <tr>
                    <td class="title-table">Telfon</td>
                    <td class="psm">:</td>
                    <td class="content">081245739834</td>
                </tr>
                <tr class="abu">
                    <td class="title-table">Lokasi Layanan</td>
                    <td class="psm">:</td>
                    <td class="content">Sukapura, Jakarta Utara. DKI Jakarta</td>
                </tr>
                <tr>
                    <td class="title-table">Beauty Artist</td>
                    <td class="psm">:</td>
                    <td class="content">Nama MUA</td>
                </tr>
                <tr class="abu">
                    <td class="title-table">Catatan</td>
                    <td class="psm">:</td>
                    <td class="content"></td>
                </tr>
            </table><br>

            {{-- Item Layanan --}}
            <p>Item Layanan : </p>
            <hr>
            <div class="row">
                <div class="left">
                    <p>
                        Engagrment Makeup for Client febriyanto Jestrab
                        <br>
                        at Jakarta Utara
                        <br>
                        18/08/2019 08:00
                        <br>
                        1 X 350.000,00
                    </p>
                </div>
                <div class="right">
                    <p>
                        <b>350.000,00</b>
                    </p>
                </div>
            </div>
            <div class="border-btm"></div>
            <div class="right-sub">
                <p>
                    <span> <b>Subtotal</b> </span>
                    <b>350.000,00</b>
                </p>
            </div>
            <div class="border-btm"></div>
            <div class="right-sub">
                <p>
                    <span><b>Grand Total</b></span>
                    <b>350.000,00</b>
                </p>
            </div>
            <br><br><br>

            <p class="text-center" style="font-size:13px;">
               Mohon tunggu konfirmasi dalam waktu paling lama 2 x 24 Jam ke depan.
            </p>
            <div class="btn">
                <a href="#" class="btn-bayar">Lihat Selangkapnya</a>
            </div><br>
        </div>
    </div>

</body>
</html>