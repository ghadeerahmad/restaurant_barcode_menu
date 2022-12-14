<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body{
            display: flex;
        }
        .container {
            margin: auto;
            border-radius: 10px;
            margin-top: 50px;
            padding: 25px 35px;
            display: block;
            width: fit-content;
            box-shadow: 0 3px 5px -1px rgba(0,0,0,.2),0 5px 8px 0 rgba(0,0,0,.14),0 1px 14px 0 rgba(0,0,0,.12)!important;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">

        {!! DNS2D::getBarcodeHTML(URL('store/'.$table->store_id.'/tables',$table->id), 'QRCODE') !!}
        <p class="text-center" style="direction: {{App::isLocale('ar')?'rtl':'ltr'}};">{{__('orders.table_code').': '.$table->code}}</p>
    </div>
</body>

</html>