<script>
    // ----------------- Store toggle js handler start ------------------------- //
    function triggerProductPower(prod,pro_id){
        var url = "{{route('store_admin.toggle_product_status',['id'=> 'xx_id' ])}}";
        var url = url.replace('xx_id', pro_id);
        var toggle_id = "power-toggle-" + pro_id
        document.getElementById(toggle_id).disabled = true;
        fetch(url, {
            method: 'POST',
            credentials: "same-origin",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-TOKEN": "{{csrf_token()}}"
            },
            body: JSON.stringify({is_active: prod.value == 0 ? 1: 0})
        })
            .then(function(response) {
                return response.json();
            })
            .then(function(result) {
                if(result.success){
                    document.getElementById(toggle_id).value = prod.value == 0 ? 1: 0

                }else{
                    document.getElementById(toggle_id).value = prod.value
                }
                document.getElementById(toggle_id).disabled = false;

            })
            .catch(function(error) {
                console.log("err");
                console.error('Error:', error);
                document.getElementById(toggle_id).disabled = false;
            });

    }

    // ----------------- Store toggle js handler end ------------------------- //

</script>
