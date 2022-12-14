<script>
    var local = '{{App::currentLocale()}}';
    var currency = '{{$store->currency->code}}';
function get_local_string(string_ar, string_en) {
    if (string_ar != null && string_en != null) return local == 'ar' ? string_ar : string_en;
    if (local == 'ar') {
        if (string_ar != null) return string_ar;
        return string_en;
    }
    if (local == 'en') {
        if (string_en != null) return string_en;
        return string_ar;
    }
}
    function get_order(id) {
        var tax = 0;
        var locale = '{{App::isLocale("ar")?"ar":"en"}}';
        $("#table").attr('style', 'display:none');
        $("#phone").attr('style', 'display:none');
        $("#customer-name").attr('style', 'display:none');
        $("#payment_details").attr('style', 'display:none');
        $("#payment_number").attr('style', 'display:none');
        $("#payment_image_container").attr('style', 'display:none');
        $("#map_url").attr('style', 'display:none');
        $("#comments").attr('style', 'display:none');
        $("#address").attr('style', 'display:none');
        $("#product-list").html('');
        $.ajax({
            type: 'GET',
            url: '{{url("store/orders")}}/' + id,
            success: function(data) {
                console.log(data);
                if (data['order']['customer_name'] != null) {
                    $("#order-title").html(data['order']['customer_name']);
                    $("#customer-name").html(data['order']['customer_name']);
                    $("#customer-name").attr('style', 'display:visible');
                }
                if (data['order']['customer_phone'] != null) {
                    $("#phone").html(data['order']['customer_phone']);
                    $("#phone").attr('style', 'display:visible');
                }
                if (data['order']['table'] != null) {
                    $("#table-name").html(data['order']['table']['name']);
                    $("#table").attr('style', 'display:visible');
                }
                var order_type = local == 'ar'?'نوع الطلب: ':'order type: ';
                switch(data['order']['order_type']){
                    case '0':
                        order_type += local=='ar'?'استلام باليد':'take away';
                        break;
                    case '1':
                        order_type += local=='ar'?'توصيل':'delivery';
                        break;
                    case '2':
                        order_type += local=='ar'?'الأكل في المطعم':'dine in';
                        break;
                }
                var map_url = 'https://www.google.com/maps/place/';
                if(data['order']['latitude'] != null && data['order']['longtude'] != null){
                    map_url += data['order']['latitude']+','+data['order']['longtude'];
                    $("#map_url").html('<a href="'+map_url+'">'+map_url+'</a>');
                    $("#map_url").attr('style','display:block');
                }
                if(data['order']['address'] != null){
                    var address = local =='ar'?'العنوان: ':'Address: ';
                    address += data['order']['address'];
                    $("#address").html(address);
                    $("#address").attr('style', 'display:block');
                }
                var comment = local=='ar'?'ملاحظات: ':'Comments: ';
                if(data['order']['comments'] != null){
                    comment += data['order']['comments'];
                    $("#comments").html(comment);
                    $("#comments").attr('style','display:block');
                }
                $("#order-type").html(order_type);
                if (data['products'] != null) {
                    var body = '';
                    for (let product of data['products']) {
                        if (product != null) {
                            var td = '<li>';
                            td += '<h2>'+get_local_string(product['name_ar'],product['name_en'])+' ';
                            td += local == 'ar'?'الكمية: ':'quantity: ';
                            var quantity = 0;
                            for (let item of data['order']['products'])
                                if (item['product_id'] == product['id']) {
                                    td += item['quantity'];
                                    td += '-';
                                    price = parseFloat(item['quantity'] * product['price']);
                                    td += price+' '+currency;
                                    quantity = item['quantity'];
                                }
                            td += '</h2>';
                            var sizes = '';
                            if(data['order']['sizes'] != null && data['order']['sizes'].length > 0){
                                for (let item of data['order']['sizes'])
                                    if (item['product_id'] == product['id'])
                                         sizes = '<p><strong>{{__("orders.size")}}</strong></p><ul>';
                            for (let item of data['order']['sizes'])
                                if (item['product_id'] == product['id']) {
                                    for (let size of data['sizes'])
                                        if (size['id'] == item['size_id']) {
                                            sizes += '<li>';
                                            var sizes_charge = parseFloat(size['price'] * quantity);
                                            sizes += get_local_string(size['name_ar'],size['name_en']);
                                            sizes += '-' + sizes_charge;
                                            sizes += '</li>';
                                        }
                                }
                                sizes += '</ul>';
                                td+= '<li>'+sizes+'</li>';
                            }
                            var addons='';
                            if(data['order']['addons'] != null && data['order']['addons'].length > 0){
                                for (let item of data['order']['addons'])
                                    if (item['product_id'] == product['id'])
                                        addons = '<p><strong>{{__("orders.addons")}}</strong></p><ul>';
                            for (let item of data['order']['addons'])
                                if (item['product_id'] == product['id']) {
                                    for (let addon of data['addons'])
                                        if (addon['id'] == item['addon_id']) {
                                            addons += '<li>';
                                            var addons_charge = parseFloat(addon['price'] * quantity);
                                            addons += get_local_string(addon['name_ar'],addon['name_en']);
                                            addons += '-' + addons_charge;
                                            addons += '</li>';
                                        }
                                }
                                addons += '</ul>';
                                td+= '<li>'+addons+'</li>';
                            }
                            if(data['order']['edits'] != null && data['order']['edits'].length > 0){
                                for (let item of data['order']['edits'])
                                    if (item['product_id'] == product['id'])
                                        var edits = '<p><strong>{{__("orders.edits")}}</strong></p><ul>';
                            for (let item of data['order']['edits'])
                                if (item['product_id'] == product['id']) {
                                    for (let edit of data['edits'])
                                        if (edit['id'] == item['edit_id']) {
                                            edits += '<li>';
                                            edits += get_local_string(edit['name_ar'],edit['name_en']);
                                            edits += '</li>';
                                        }

                                }
                            edits += '</ul>';
                            td += '<li>'+ edits+ '</li>';
                            }
                            var sauces = '';
                            if(data['order']['sauces'] != null && data['order']['sauces'].length > 0){
                                for (let item of data['order']['sauces'])
                                    if (item['product_id'] == product['id'])
                                        sauces = '<p><strong>{{__("orders.sauces")}}</strong></p><ul>';
                            for (let item of data['order']['sauces'])
                                if (item['product_id'] == product['id']) {
                                    for (let sauce of data['sauces'])
                                        if (sauce['id'] == item['sauce_id']) {
                                            sauces += '<li>';
                                            sauces += get_local_string(sauce['name_ar'],sauce['name_en']);
                                            var sauce_price = parseFloat(sauce['price']*quantity);
                                            sauces += '-'+sauce_price;
                                            sauces += '</li>';
                                        }

                                }
                            sauces += '</ul>';
                            td += '<li>'+sauces+'</li>';
                            }
                            body += td;
                        }
                    }
                    $("#product-list").html(body);
                    if (data['order']['tax'] != null) tax = data['order']['tax'];
                    $("#total").html(data['order']['total']);
                    if (data['order']['order_payment'] != null) {
                        $("#payment_method").html(data['order']['order_payment']['payment_method']);
                        $("#payment_details").attr('style', 'display:block');
                        $("#payment_number").attr('style', 'display:visible');
                        if (data['order']['order_payment']['image'] != null) {
                            $("#payment_image_container").attr('style', 'display:visible');
                            $("#payment_image").attr('src', '{{asset("storage/")}}' + data['order']['order_payment']['image']);
                        }
                        if (data['order']['order_payment']['payment_number'] != null)
                            $("#payment_num").html(data['order']['order_payment']['payment_number']);
                        else $("#payment_num").html('NAN');
                    } else {
                        $("#payment_method").html('CASH');
                    }
                    console.log(body);
                    $("#accept-form").attr('action', '{{url("store/orders/accept")}}/' + data['order']['id']);
                    $("#deny-form").attr('action', '{{url("store/orders/deny")}}/' + data['order']['id']);
                    $("#paid-form").attr('action', '{{url("store/orders/set_paid")}}/' + data['order']['id']);
                    $("#delivery-form").attr('action', '{{url("store/orders/on_delivery")}}/' + data['order']['id']);
                    $("#completed-form").attr('action', '{{url("store/orders/completed")}}/' + data['order']['id']);
                    $('#order-body').html(body);
                    //$("#products").attr('style', 'display:visible');
                }
            }
        });
    }
</script>