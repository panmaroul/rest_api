async function call_charts() {
    
    url = 'http://localhost/simpleRestAPI/src/api/energy/read.php?fbclid=IwAR1QPC0SzCTWHy5OfSPB-noAHSH5ml8Q4F3TlzkUBTXR7Bd3c9lvXms8-0w';

    // Storing response
    const response = await fetch(url);

    // Storing data in form of JSON
    var data = await response.json();
    
    mapped_data = get_data_columns(data);
    draw_graph(mapped_data['country'], mapped_data['world_share'], "Percentage of energy consumption over the world total", "myChart", "pie", true)
    draw_graph(mapped_data['country'], mapped_data['country_share_of_world_co2'], "World Share of CO2 Emissions", "myChart1", "pie", true)
    draw_graph(mapped_data['country'], mapped_data['co2_emiss_per_capita'], "CO2 emissions in tons per person", "myChart2", "bar", false)
    draw_graph(mapped_data['country'], mapped_data['co2_emiss_one_year_change'], "CO2 emissions increased over the previous year", "myChart3", "bar", false)
    draw_graph(mapped_data['country'], mapped_data['non_renewable'], "Energy consumption from non renewable sources (fossil fuels)", "myChart4", "pie", true)
}

function get_data_columns(data) {
    var map = {
        'id': [],
        'country': [],
        'population': [],
        'world_share': [],
        'non_renewable': [],
        'country_share_of_world_co2': [],
        'co2_emiss_per_capita': [],
        'co2_emiss_one_year_change': [],
    };
    for (let i=0;i<data.length; i++) {
        for (key in data[i]) {
            map[key].push(data[i][key])
        }
    }

    return map;
}

function draw_graph(xValues, yValues, title, chartName, chart, display) {
    var barColors = [];
    for (let i = 0; i < xValues.length; i++) {
        let color = Math.floor(Math.random()*0xFFFFFF << 0).toString(16).padStart(6, '0');
        barColors.push("#" + color);
    }

    new Chart(chartName, {
        type: chart,
        data: {
            labels: xValues,
            datasets: [{
                backgroundColor: barColors,
                data: yValues
            }]
        },
        options: {
            legend: {
                display: display
            },
            title: {
                display: true,
                text: title,
                rotation: 1
            }
        }
    });
}