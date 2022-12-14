
<script>
    var local = 'ar';
    if('{{App::isLocale("ar")?"ar":"en"}}' == 'en') local = 'en';
    function check_coupon() {
        var currency = '{{$store->currency->code}}';
        var code = $("#coupon_code").val();
        var store_id = '{{$store->id}}';
        var formData = {
            'code': code,
            'store_id': store_id,
            _token: ' <?php echo csrf_token() ?>'
        };
        $.ajax({
            type: "POST",
            url: '{{url("check_coupon")}}',
            data: formData,
            success: function(data) {
                var alert = $("#alert-danger");
                var success = $("#alert-success");
                console.log(data);
                if (data['message'] == 'success') {
                    if (alert.hasClass("show")) {
                        alert.removeClass('show');
                        alert.addClass('hide');
                    }
                    if (success.hasClass('hide')) {
                        success.removeClass('hide');
                        success.addClass('show');
                    }
                    var value = parseFloat(data['value']);
                    var type = data['type'];
                    var total = parseFloat($("#total").html());
                    switch (type) {
                        case 'AMOUNT':
                            total = total - value;
                            $("#discount").html(value + ' ' + currency);
                            if (total < 0) total = 0;
                            $("#total").html(total);
                            break;
                        case 'PERCENT':
                            var dis = (total * value) / 100;
                            total = total - dis;
                            $("#discount").html(value + '%');
                            if (total < 0) total = 0;
                            $("#total").html(total);
                            break;
                    }
                } else {
                    if (alert.hasClass("hide")) {
                        alert.removeClass('hide');
                        alert.addClass('show');
                    }
                    if (success.hasClass('show')) {
                        success.removeClass('show');
                        success.addClass('hide');
                    }
                }
            }
        });
    }
    $(document).ready(function() {
        $("#payment_method").change(function(e) {
            var method = $("#payment_method").val();
            if (method != "CASH") {
                var formData = {
                    'store_id': '{{$store->id}}',
                    'payment_method': $("#payment_method").val(),
                    _token: ' <?php echo csrf_token() ?>'
                };
                $.ajax({
                    url: '{{url("get_payment_info")}}',
                    data: formData,
                    type: "POST",
                    success: function(data) {
                        console.log(data);
                        if (data['image'] != null) {
                            var url = '{{asset("storage")}}';
                            $("#info-image").attr('src',url+data['image']);
                            $("#info-image-container").attr('style','display:flex');
                        }
                        if(local == 'ar'){
                            if(data['description_ar'] != null){
                                $("#info-container").html(data['description_ar']);
                                $("#info-container").attr('style','display:flex');
                            }
                        }else{
                            if(data['description_en'] != null){
                                $("#info-container").html(data['description_en']);
                                $("#info-container").attr('style','display:flex');
                            }
                        }
                        $("#payment_details").attr('style', 'display:block');
                    }
                });

            } else $("#payment_details").attr('style', 'display:none');
        });
        $("#delivery_type").change(function(e) {
            var type = $("#delivery_type").val();
            if (type == 0) {
                $("#address").attr('style', 'display:none');
                var delivery = parseFloat($("#delivery_charge").html());
                var total = parseFloat($("#total").html());
                total = total - delivery;
                $("#total").html(total);
                $("#delivery_charge_section").attr('style', 'display:none');
            }
            if (type == 1) {
                $("#address").attr('style', 'display:block');
                var delivery = parseFloat($("#delivery_charge").html());
                var total = parseFloat($("#total").html());
                total = total + delivery;
                $("#total").html(total);
                $("#delivery_charge_section").attr('style', 'display:block');
            }
        });
    });
</script>