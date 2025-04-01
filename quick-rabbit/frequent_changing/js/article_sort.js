$(function () {
    "use strict";
    let base_url = $('input[name="app-url"]').attr('data-app_url');

    $(document).on('change','#product_category_id',function() {
        let product_category_id = $('#product_category_id').val();
        $('#article_group_id') .find('option') .remove() .end() .append('<option value="">Select</option>');

        $('#sort_articles').find('p') .remove();
        let html_div = `<p class="alert alert-danger">No article found!</p>`;
        $('#sort_articles').html(html_div);

        $.ajax({
            method: 'GET',
            url: app_url+"/api/product-wise-groups/"+product_category_id,
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

    $(document).on('change','#article_group_id',function () {
        let article_group_id = $('#article_group_id').val();
        $('#sort_articles') .find('p') .remove();
        $.ajax({
            method: 'GET',
            url: base_url+"/api/group-wise-articles/"+article_group_id,
            success: function(response){
                let html_div = '';
                if(response.length > 0) {
                    $.each(response,function(index,value){
                        html_div += `
                        <li class="list-group-item" data-id="${value.id}">
                        <span class="handle"></span> ${value.title}</li>`;
                    });
                } else {
                    let message = $('#no_article_found').val();
                    html_div = `<p class="alert alert-danger">${message}</p>
                    `;
                }

                $('#sort_articles').html(html_div);
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
                axios.post(base_url+'/sort-article',{
                    ids: sortData.join(',')
                });
            }
        })
    });
});

