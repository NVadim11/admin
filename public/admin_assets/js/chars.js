$(document).ready(function () {
    $("<div id='tooltip'></div>").css({
            position: "absolute",
            display: "none",
            border: "1px solid #fdd",
            padding: "2px",
            "background-color": "#fee",
            opacity: 0.80
    }).appendTo("body");

    $("#chart_1").bind("plothover", function (event, pos, item) {

                    if (item) {
                            var y = item.datapoint[1].toFixed(0);

                            $("#tooltip").html("Посетителей: " + y)
                                    .css({top: item.pageY+5, left: item.pageX+5})
                                    .fadeIn(200);
                    } else {
                            $("#tooltip").hide();
                    }
    });
    $.post('/admin/?act=getWeekvisits', function (data) {
        if (data.sux == 1)
        {
            $.plot("#chart_1",  [{data:data.items, label: "Кол-во посетителей в день", color:"#5b9bd1"}] , {
                    series: {
                            bars: {
                                    show: true,
                                    barWidth: 0.6,
                                    align: "center"
                            }
                    },
                    grid: {
                                borderColor: "#eee",
                                borderWidth: 1,
				hoverable: true
			},
                    xaxis: {
                            mode: "categories",
                            tickLength: 0
                    }
            });
        }
        else
        {
            swal('Ошибка при передачи данных');
        }
    }, 'json');


});