$(function () {
    "use strict";
    let base_url = $('input[name="app-url"]').attr('data-app_url');

    $(document).on('change','#product_category_id',function () {
        let product_category_id = $('#product_category_id').val();
        $('#sort_article_groups') .find('p') .remove();
        $.ajax({
            method: 'GET',
            url: base_url+"/api/product-wise-groups/"+product_category_id,
            success: function(response){
                let html_div = '';
                if(response.length > 0) {
                    $.each(response,function(index,value){
                        html_div += `
                        <li class="list-group-item break-word" data-id="${value.id}">
                        <span class="handle"><iconify-icon icon="jam:move" width="16"></iconify-icon></span> ${value.title}</li>`;
                    });
                } else {
                    let message = $('#no_article_group_found').val();
                    html_div = `<p class="alert alert-danger">${message}</p>
                    `;
                }

                $('#sort_article_groups').html(html_div);
            }
        });
    });

    $(document).ready(function(){
        let target = $('.sort_menu');
        target.sortable({
            handle: '.handle',
            placeholder: 'highlight',
            axis: "y",
            update: function (e, ui){
                let sortData = target.sortable('toArray',{ attribute: 'data-id'})
                axios.post(base_url+'/sort-article-group',{
                    ids: sortData.join(',')
                });
            }
        })
    });
});

