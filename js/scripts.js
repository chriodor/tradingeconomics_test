const ctx = document.getElementById('chart_canvas');

var chartDraw;

function compareData(ev) {
    if (jQuery(ev.target).attr("id") === "countrySelect_first") {
        if (jQuery("#countrySelect_first").val() === "All") {
            jQuery("#countrySelect_sec").val("All");
        }
    }

    if (jQuery(ev.target).attr("id") === "countrySelect_sec") {
        if (jQuery("#countrySelect_sec").val() === "All") {
            jQuery("#countrySelect_first").val("All");
        }
    }

    if (jQuery("#dataTypeSelect").val() !== "") {

        if (jQuery("#dataTypeSelect").val() !== "CREDIT") {

            jQuery("#selectRatingsType").parent().hide();
            jQuery("#countrySelect_first").parent().show();
            jQuery("#countrySelect_sec").parent().show();

            if (jQuery("#countrySelect_first").val() !== "" && jQuery("#countrySelect_sec").val() !== "") {
                jQuery.post(alapMainHttp + "apis/getData.php", {"type": jQuery("#dataTypeSelect").val(), "country_first": jQuery("#countrySelect_first").val(), "country_sec": jQuery("#countrySelect_sec").val()}, function (dat) {
                    if (dat["response"] === "OK") {
                        if (chartDraw !== undefined) {
                            chartDraw.destroy();
                        }


                        showData_first = [];
                        showData_sec = [];

                        getLabels = [];
                        jQuery.each(dat["data"], function (a, b) {
                            getLabels.push(a);


                            showData_sec.push(b[1]);
                            showData_first.push(b[2]);
                        });

                        let secData;
                        label_first = label_sec = "";
                        hasSecData = false;
                        switch (jQuery("#dataTypeSelect").val()) {
                            case "GDP":
                                label_first = "Billion USD (2021)";
                                label_sec = "Billion USD (2022)";
                                hasSecData = true;
                                break;
                            case "COVID":
                                label_first = "Cases";
                                break;
                            case "EXP/IMP":
                                label_first = "Export";
                                label_sec = "Import";
                                hasSecData = true;
                                break;
                        }

                        dataSetList = [{
                                label: label_first,
                                data: showData_first,
                                borderWidth: 1
                            }];

                        if (hasSecData) {
                            secData = {
                                label: label_sec,
                                data: showData_sec,
                                borderWidth: 1
                            };
                        }

                        if (secData !== undefined) {
                            dataSetList.unshift(secData);
                        }

                        chartDraw = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: getLabels,
                                datasets: dataSetList
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });

                    } else {
                        customAlert(dat["message"]);
                    }
                }, "json");
            }
        } else if (jQuery("#dataTypeSelect").val() === "CREDIT") {
            jQuery("#selectRatingsType").parent().show();
            jQuery("#countrySelect_first").parent().hide();
            jQuery("#countrySelect_sec").parent().hide();

            if (jQuery("#selectRatingsType").val() !== "") {
                jQuery.post(alapMainHttp + "apis/creditRatings.php", {"ratings_type": jQuery("#selectRatingsType").val()}, function (dat) {

                    console.debug(dat);
                    if (chartDraw !== undefined) {
                        chartDraw.destroy();
                    }

                    getLabels = [];
                    getData = [];
                    jQuery.each(dat, function (a, b) {
                        getLabels.push(a);
                        getData.push(b);
                    });

                    chartDraw = new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: getLabels,
                            datasets: [{
                                    label: ["Count"],
                                    data: getData,
                                    borderWidth: 1
                                }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                }, "json");
            }
        }
    }
}