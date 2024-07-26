$(document).ready(function () {
    $("<div id='tooltip'></div>").css({
            position: "absolute",
            display: "none",
            border: "1px solid #fdd",
            padding: "2px",
            "background-color": "#fee",
            opacity: 0.80
    }).appendTo("body");

    $("#currency_chart").bind("plothover", function (event, pos, item) {

                    if (item) {
                            var y = item.datapoint[1];
                            var num = item.datapoint[0];
                            var x = item.series.data[num][0];

                            $("#tooltip").html("Курс: " + y+' <br /> Дата: '+x)
                                    .css({top: item.pageY-53, left: item.pageX-40})
                                    .fadeIn(200);
                    } else {
                            $("#tooltip").hide();
                    }
    });
    
    var d1 = [];
    
    $('#charsset tbody tr').each(function(){
        var rate = parseFloat($(this).children('.rate').text());
        d1.push([$(this).children('.date').text(), rate]);
    });

    $.plot("#currency_chart", [{data:d1.reverse(), label: "Курс валют", color:"#5b9bd1"}] , {
                    series: {
                            lines: {
                                    show: true
                            }
                    },
                    grid: {
                                borderColor: "#eee",
                                borderWidth: 1,
				hoverable: true
			},
                    xaxis: {
                            mode: "categories",
                            tickLength: 0,
                            show: false
                    }
            });
});


