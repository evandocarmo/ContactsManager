// Google Charts Initializer
google.load("visualization", "1", {
    packages: ["corechart"]
});

// System Updates
google.setOnLoadCallback(function () {
    var data = google.visualization.arrayToDataTable(systemUpdatesChart);
    var options = {
        'legend': 'none',
        'tooltip': {
            'trigger': 'none'
        },
        'height': 150,
        'pieSliceText': 'none',
        'slices': {
            0: {
                'color': 'e66665'
            },
            1: {
                'color': '4d9379'
            },
            2: {
                'color': '82b5e0'
            },
            3: {
                'color': 'ffd602'
            }
        }
    };
    var chart = new google.visualization.PieChart(document.getElementById('waiting-piechart'));
    chart.draw(data, options);
});

// Visits
google.setOnLoadCallback(function () {
    var data = google.visualization.arrayToDataTable(visitsChart);
    var options = {
        curveType: 'function',
        legend: {
            position: 'none'
        }
    };
    var chart = new google.visualization.LineChart(document.getElementById('visits-linechart'));
    chart.draw(data, options);
});

// Waiting Contacts
google.setOnLoadCallback(function () {
    var data = google.visualization.arrayToDataTable(waitingContactsChart);
    var options = {
        'legend': 'none',
        vAxis: {
            minValue: 0
        }
    };
    var chart = new google.visualization.AreaChart(document.getElementById('updates-areachart'));
    chart.draw(data, options);
});