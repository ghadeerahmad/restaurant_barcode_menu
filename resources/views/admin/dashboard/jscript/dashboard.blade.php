<script>
    
        function change_status(store_id) {
            
            var formData = {
                'store_id': store_id,
                _token: ' <?php echo csrf_token() ?>'
            };
            $.ajax({
                type: "POST",
                url: '{{url("admin/store/change_status")}}',
                data: formData,
                success: function(data) {
                    document.getElementById('snackbar').innerHTML = data['success'];
                    showToast();
                }
            });
        };
    $(document).ready(function() {
        $("#show_store").click(function(e) {
            document.getElementById('store_body').innerHTML = '<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>';
            document.getElementById('store_info').click();
            e.preventDefault();
            var formData = {
                'store_id': $("#store_id").val(),
                _token: ' <?php echo csrf_token() ?>'
            };
            $.ajax({
                type: "POST",
                url: '{{url("admin/store/info")}}',
                data: formData,
                success: function(data) {
                    console.log(data);
                    var name = '<p><strong>{{__("chef.store_name_ar")}}: </strong>' + data['name_ar'] + '</p><p><strong>{{__("chef.store_name_en")}}: </strong>' + data['name_en'] + '</p>';
                    var description = '<p><strong>{{__("admin.store_description_ar")}}: </strong>' + data['description_ar'] + '</p><p><strong>{{__("admin.store_description_en")}}: </strong>' + data['description_en'] + '</p>';
                    var plan = '<p><strong>{{__("admin.store_plan")}}: </strong>' + data['plan']['name_ar'] + '-' + data['plan']['name_en'] + '</p>';
                    var sub_end = '<p><strong>{{__("admin.sub_end")}}: </strong>' + data['sub_end'] + '</p>';
                    document.getElementById('store_body').innerHTML = name + description + plan + sub_end;
                    //showToast();
                }
            });
        });
    });
</script>