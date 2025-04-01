$(function () {
    "use strict";
    let target = $('.sort_agent');
    target.sortable({
        handle: '.handle',
        placeholder: 'highlight',
        axis: "y",
        update: function (e, ui){
            let sortData = target.sortable('toArray',{ attribute: 'data-id'});
            axios.post('/sort-agent-chat-sequence',{
                ids: sortData.join(','),
            });
        }
    })
});
