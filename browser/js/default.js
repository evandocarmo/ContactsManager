var endereco;
$(document).ready(function ()
{

    if (typeof endereco === 'undefined')
    {
        endereco = "";
    }

    $("#address-input").geocomplete({
        map: "#canvas-map dd",
        mapOptions: {
            zoom: 2,
            scrollwheel: true
        },
        details: "form",
        detailsAttribute: "data-geo",
        types: ["geocode", "establishment"],
        location: endereco
    }).bind("geocode:error", function (event, result)
    {
        if (result === "ZERO_RESULTS")
        {
            alert("O Google n\u00E3o detectou o endere\u00E7o, tente retirar o complemento, ou numero do apartamento.");
        }
    });
    $("#address-button").click(function ()
    {
        $("#address-input").trigger("geocode");
    });

    $('#cat_color').colorpicker({flat: true, changeColor: function (hsb, hex, rgb) {
        $('input[name="cat_color"]').val('#' + hex);
    }});

    $('input[name=fie_date], input[name=vis_date], input[name=fia_date]').mask("00/00/0000", {placeholder: "__/__/____"});
    $.validator.addMethod("vdate",
            function (value, element)
            {
                if (/^(0[1-9]|[12][0-9]|3[01])[- /.](0[1-9]|1[012])[- /.](19|20)[0-9]{2}$/.test(value))
                {
                    var v = value.replace(/[- /]/g, '.').split('.');
                    var d = parseInt(v[0], 10), m = parseInt(v[1], 10), y = parseInt(v[2], 10);
                    var o = new Date(y, m - 1, d);
                    return o.getDate() == d && o.getMonth() + 1 == m && o.getFullYear() == y ? true : false;
                }
                else
                {
                    return false;
                }
            },
            "Invalid Date");
    $.extend($.expr[":"], {
        "containsIN": function (elem, i, match, array)
        {
            return (elem.textContent || elem.innerText || "").toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
        }
    });
    $("input[name=\"mobile-search\"]").keyup(function ()
    {
        //split the current value of searchInput
        var data = this.value.split(" ");
        //create a jquery object of the rows
        var jo = $("tbody").find("tr:not(#filter-mobile)");
        if (this.value === "")
        {
            jo.show();
            return;
        }
        //hide all the rows
        jo.hide();
        //Recusively filter the jquery object to get results.
        jo.filter(function (i, v)
        {
            var $t = $(this);
            for (var d = 0; d < data.length; ++d)
            {
                if ($t.is(":containsIN('" + data[d] + "')"))
                {
                    return true;
                }
            }
            return false;
        })
                //show the rows that match.
                .show();
    }).focus(function ()
    {
        this.value = "";
        $(this).css({
            "color": "black"
        });
        $(this).unbind('focus');
    }).css({
        "color": "#C0C0C0"
    });
    $("div.profile-fieldservice form").validate({
        rules: {
            fie_date: {
                required: true,
                vdate: true
            },
            fie_conductor: {
                required: true
            }
        },
        messages: {
            fie_date: {
                required: "Date is required"
            },
            fie_conductor: {
                required: "Conductor is required"
            }
        }
    });
    $("div.fieldservice-work-form form").validate({
        rules: {
            fia_date: {required: true, vdate: true},
            fia_cond: {required: true}
        },
        messages: {
            fia_date: {required: "Date is required"},
            fia_cond: {required: "Conductor is required"}
        }
    });
});