
<script>
    var local = 'ar';
    var total = $("#total").val();
    var hasTable = {{session('table')==null?0:1}};
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
                            var url = '{{asset("storage")}}/';
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
            if (type != 1) {
                $("#address").attr('style', 'display:none');
                var delivery = parseFloat($("#delivery_charge").html());
                var total = parseFloat($("#total-price").html());
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
    
    var lat_lng;
    $(document).ready(function() {
        $("#delivery").click(function(){
            var charges = parseFloat('{{$store->min_delivery}}');
            var total = parseFloat($("#total-price").val());
            //console.log(total);
            if(total >= charges){
                if(navigator.geolocation){
                    navigator.permissions.query({name:'geolocation'}).then(function(result){
                        console.log(result.state);
                        if(result.state == 'granted')
                            navigator.geolocation.getCurrentPosition(geoSuccess,geoError);
                        else{
                            $("#location-alert").addClass("popup");
                            $("#location-alert").attr('style','z-index:99999;opacity:1');
                        }
                    });
                        
                }
            }else{
                document.getElementsByName('delivery_type')[0].checked = false;
                var message = local == 'ar'?'الحد الأدنى للتوصيل هو '+charges:'minmum total for delivery is '+charges;
                displayErrorMessage(message);
                
            }
        });
        $("#close-map").click(function(){
            $("#select-location").attr('style','z-index:-1;opacity:0');
            $("#select-location").removeClass('popup');
        });
        $("#location-alert-close").click(function(){
            $("#location-alert").attr('style','z-index:-1;opacity:0');
            $("#location-alert").removeClass('popup');
        });
        $("#submit-location").click(function(){
            $("#select-location").attr('style','z-index:-1;opacity:0');
            $("#select-location").removeClass('popup');
            
            var address = $("#address").val();
            if(address != null){
                $("#address_info").val(address);
            }
            initSmallMap(lat_lng);
            
        });
        $("#order_now").click(function(){
            submit_order();
        });
        $("#error-close").click(function(){
            $("#errorMessage").removeClass('popup');
            $("#errorMessage").attr('style','z-index:-1;opacity:0');
        });
        $("#submit_form").click(function(e){
            e.preventDefault();
            submit_order();
        });
    });
    var geoSuccess = function(position){
        console.log(position);
        lat_lng = {'lat':position.coords.latitude,'lng':position.coords.longitude}; 
        addMarker(lat_lng);
        $("#select-location").addClass('popup');
        $("#select-location").attr('style','z-index:9999;opacity:1');
    }
    var geoError = function(error){
        $("#location-alert").addClass("popup");
        $("#location-alert").attr('style','z-index:99999');
    }
    function submit_order(){
        if(hasTable==0){
        var type = document.getElementsByName('delivery_type');
        var r = false;
        for(var radio of type){
            if(radio.checked){
                
                switch(radio.value){
                    case '1':
                    var lat = $("#lat").val();
                    var lng = $("#lng").val();
                    var address = $("#address").val();
                    if((lat == '' || lng == '') && address == ''){
                        message = local == 'ar'?'يرجى إدخال بيانات الموقع':'please enter location information';
                        displayErrorMessage(message);
                        return;
                    }
                    break;
                    case '2':
                        r=true;
                    break;
                    case '0':
                        r=true;
                    break;
                }
            }
        }
        if(!r){
            message = local=='ar'?'يرجى تحديد طريقة استلام الطلب':'please select delivey type first';
            displayErrorMessage(message);
            return;
        }
    }
        var name = $("#customer_name").val();
        var phone = $("#phone").val();
        if(name == '' || phone == '')
        {
            var message = local == 'ar'?'يرجى إدخال اسم الزبون ورقم الهاتف':'please enter customer name and phone';
            displayErrorMessage(message);
            return;
        }
        if(hasTable==1){
            var table_code = $("#table_code").val();
            if(table_code == ''){
                var message = local=='ar'?'يرجى إدخال كود الطاولة':'Please enter table code';
                displayErrorMessage(message);
                return;
            }
        }
        document.getElementById('order_form').submit();
    }
    function displayErrorMessage(message){
        $("#message").html(message);
        $("#errorMessage").attr('style','z-index:99999;opacity:1');
        $("#errorMessage").addClass('popup');
    }
</script>