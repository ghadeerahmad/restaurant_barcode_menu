<script>
    $(document).ready(function(){
        $('#order_settings').submit(function(e){
            e.preventDefault();
            var delivery = $('input[id="delivery"]:checked').length == 1?1:0;
            var cash = $('input[id="cash"]:checked').length == 1?1:0;
            var other_payment = $('input[id="other_payment"]:checked').length == 1?1:0;
            //console.log($('input[id="delivery"]:checked'));
            var data = {
                'delivery':delivery,
                'cash':cash,
                'other_payment':other_payment,
                _token:'<?php echo csrf_token(); ?>'
            };
            $.ajax({
                type:'POST',
                url:'{{url("store/update_order_settings")}}',
                data:data,
                success:function(data){
                    console.log(data);
                    $("#snackbar").html(data['message']);
                    showToast();
                }
            });
        });
    });
</script>