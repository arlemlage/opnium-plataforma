$(function () {
    "use strict";
    let base_url = $('input[name="app-url"]').attr('data-app_url');
    let target = $('.sort_category');
    target.sortable({
        handle: '.handle',
        placeholder: 'highlight',
        axis: "y",
        update: function (e, ui){
            let sortData = target.sortable('toArray',{ attribute: 'data-id'});
            axios.post(base_url+'/sort-product-category',{
                ids: sortData.join(',')
            });
        }
    })
});
