(function ($) {
    "use strict";
    let base_url = $('input[name="app-url"]').attr('data-app_url');
    let url_prefix = $('#url_prefix').val();
    let six_month_text = $("#six_month_value").val();
    let one_year_text = $("#one_year_value").val();
    let ticketChart = null;
    // select field change
    $(document).on('change', '#filter_chart_month', function () {
        let month = $(this).val();
        console.log(month)
        if(ticketChart != null){
            ticketChart.destroy();
        }
        ticketData(month);

        if(month == 6){
            $("#month_span").html(six_month_text)
        }else{
            $("#month_span").html(one_year_text)
        }

    });

    ticketData();
    function ticketData(month = 6) {
        $(document).ready(function () {
            $.ajax({
                method: 'GET',
                async: false,
                url: base_url + '/chart-data',
                data: {
                    month: month,
                },
                success: function (response) {
                    const labels = response.months;
                    const data = {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Total Ticket',
                                data: response.total_ticket,
                                backgroundColor: '#307ef399',
                                borderColor: '#307ef3',
                                borderWidth: 2
                            },
                            {
                                label: 'Open Ticket',
                                data: response.open_ticket,
                                backgroundColor: '#eba31d99',
                                borderColor: '#eba31d',
                                borderWidth: 2
                            },
                            {
                                label: 'Closed Ticket',
                                data: response.close_ticket,
                                backgroundColor: '#dc354599',
                                borderColor: '#dc3545',
                                borderWidth: 2
                            }
                        ]
                    };
                    const config = {
                        type: 'bar',
                        data: data,
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        },
                    };
                    ticketChart = new Chart(document.getElementById('dashboardGraph'), config);
                }
            });
        });
    }


    // Ticket By Category
    $(document).ready(function () {
        $.ajax({
            method: 'GET',
            async: false,
            url: base_url + '/ticket-by-category',
            success: function (response) {
                const labels = response.categories;
                const data = {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Dataset 1',
                            data: convertToArray(response.total_tickets),
                            backgroundColor: [
                                '#307ef399',
                                '#eba31d99',
                                '#dc354599',
                                '#28a74599',
                                '#007bff99',
                                '#6c757d99',
                                '#17a2b899',
                                '#dc354599',
                                '#6f42c199',
                                'rgba(15,26,4,0.6)',
                            ],
                        }
                    ]
                };
                const config = {
                    type: 'pie',
                    data: data,
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                        }
                    },
                };
                new Chart(document.getElementById('ticketByCategory'), config);
            }
        });
    });


    function convertToArray(obj) {
        return Object.keys(obj).map(function(key) {
            return obj[key] == null ? "Data" : obj[key];
        });
    }



})(jQuery);
