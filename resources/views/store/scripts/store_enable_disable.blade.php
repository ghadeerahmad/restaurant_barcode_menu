<script>
        function change_status(store_id) {
            var formData = {
                'store_id': store_id,
                _token: ' <?php echo csrf_token() ?>'
            };
            $.ajax({
                type: "POST",
                url: '{{url("/store/change_status")}}',
                data: formData,
                success: function(data) {
                    console.log(data);
                    document.getElementById('snackbar').innerHTML = data['success'];
                    showToast();
                }
            });
        };
</script>