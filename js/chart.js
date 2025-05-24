// localStorage
var $data = JSON.parse(localStorage.getItem('loginDetails'));
// get and set from localStorage
var office = $data.office;

// Initialize Chart.js
const ctx = document.getElementById('dashboardChart').getContext('2d');
const dashboardChart = new Chart(ctx, {
    type: 'line', // Changed to line chart
    data: {
        labels: ['Incoming', 'Outgoing', 'Terminal Docs'],
        datasets: [{
            label: 'Document Tracker System',
            data: [], // Replace with dynamic data if needed
            backgroundColor: 'rgba(75, 192, 192, 0.2)', // Line fill color
            borderColor: 'rgba(75, 192, 192, 1)', // Line color
            borderWidth: 2, // Line thickness
            pointBackgroundColor: 'rgba(54, 162, 235, 1)', // Point color
            pointBorderColor: 'rgba(255, 255, 255, 1)', // Point border color
            pointBorderWidth: 2, // Point border thickness
            pointRadius: 5, // Point size
            tension: 0.4 // Curve tension for smooth lines
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 2, // Set a fixed step size for the Y-axis
                    callback: function (value) {
                        // Convert Y-axis values to big decimal format
                        return value.toLocaleString('en-US', {
                            minimumFractionDigits: 0,
                            maximumFractionDigits: 0
                        });
                    }
                }
            }
        }
    }
});

$(document).ready(function () {
    // Fetch month-year data from the server
    $.ajax({
        url: 'conn/chart.php',
        type: 'POST',
        data: {
            history: true,
            document_origination: office
        },
        dataType: 'json',
        success: function (data) {
            // Populate the dropdown with month-year values
            var monthYearSelect = $('#monthYearSelect');
            $.each(data, function (index, value) {
                monthYearSelect.append($('<option></option>').attr('value', value).text(
                    value));
            });
            console.log(data);
        },
        error: function (xhr, status, error) {
            console.error('Error fetching month-year data:', error);
        }
    });
});

$(document).ready(function () {
    // Handle month-year selection
    $('#monthYearSelect').change(function () {
        var selectedMonthYear = $(this).val();
        if (selectedMonthYear === 'all') {
            // Fetch all document counts
            getAllCount();
        } else {
            // Fetch document counts for the selected month-year
            $.ajax({
                url: 'conn/chart.php',
                type: 'POST',
                data: {
                    // set data if selected month year is not all
                    getCombinedCount: true,
                    monthYear: selectedMonthYear,
                    document_origination: office
                },
                dataType: 'json',
                success: function (data) {
                    // Update the chart with the new data
                    dashboardChart.data.datasets[0].data = [
                        data.incomingCount,
                        data.outgoingCount,
                        data.terminalDocsCount
                    ];
                    dashboardChart.update();
                    console.log(data);
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching document counts:', error);
                }
            });
        }
    });

    //function to get all documents count by type (incoming, outgoing, terminal)
    function getAllCount() {
        $.ajax({
            url: 'conn/chart.php',
            type: 'POST',
            data: {
                getAllCombineCounts: true,
                document_origin: office
            },
            dataType: 'json',
            success: function (data) {
                // Update the dashboard cards with the counts
                $('.dashboard-card').eq(0).find('span').text(data.incomingCount);
                $('.dashboard-card').eq(1).find('span').text(data.outgoingCount);
                $('.dashboard-card').eq(2).find('span').text(data.terminalDocsCount);

                // Update the chart with the new data
                dashboardChart.data.datasets[0].data = [
                    data.incomingCount,
                    data.outgoingCount,
                    data.terminalDocsCount
                ];
                dashboardChart.update();
                console.log(data);
            },
            error: function (xhr, status, error) {
                console.error('Error fetching all document counts:', error);
            }
        });
    }

    // Call getAllCount and load the chart on page load
    getAllCount();
    console.log('Page loaded and chart initialized.');
});