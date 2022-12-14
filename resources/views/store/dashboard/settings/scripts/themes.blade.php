<script>
    function activate(id){
        var formData = {
            'theme_id':id,
            _token:'<?php echo csrf_token();?>'
        };
        $.ajax({
            type:"POST",
            data:formData,
            url:'{{url("store/themes/activate")}}',
            success:function(data){
                $("#snackbar").html(data['message']);
                showToast();
                //if(data['status']==1) location.reload();
                // $("#snackbar").html(data['message']);
                // showToast();
            }
        });
    }
</script>