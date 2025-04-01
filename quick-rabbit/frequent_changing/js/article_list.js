(function($){
    "use strict";
    let app_url = $('input[name="app-url"]').attr('data-app_url');

    $(document).ready(function() {
        let product_id = $('#product_id').find(":selected").val();
        $.ajax({
            method: 'GET',
            url: app_url+"/api/product-wise-groups/"+product_id,
            success: function(response){
                let list = response;
                let select = document.getElementById("article_group_id");
                let i = 0;
                for(i = 0; i < list.length ;i ++){
                    let el = document.createElement("option");
                    let group = list[i];
                    let grouptitle = group.title;
                    let groupId = group.id;
                    el.textContent = grouptitle;
                    el.value = groupId;
                    select.appendChild(el);
                }
            }
        });
    });

    $(document).on('change','#product_id',function() {
        let product_id = $('#product_id').val();
        $('#article_group_id') .find('option') .remove() .end() .append('<option value="">Select</option>');
        $.ajax({
            method: 'GET',
            url: app_url+"/api/product-wise-groups/"+product_id,
            success: function(response){
                let list = response;
                let select = document.getElementById("article_group_id");
                let i = 0;
                for(i = 0; i < list.length ;i ++){
                    let el = document.createElement("option");
                    let group = list[i];
                    let grouptitle = group.title;
                    let groupId = group.id;
                    el.textContent = grouptitle;
                    el.value = groupId;
                    select.appendChild(el);
                }
            }
        });
    });

})(jQuery);
