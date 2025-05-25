document.addEventListener("DOMContentLoaded", function () {
    const canvas = document.getElementById('pendingCircleGraph');
    if (!canvas) {
        console.error('Canvas element with id "pendingCircleGraph" not found.');
        return;
    }

    const ctx = canvas.getContext('2d');

    $.ajax({
        url: 'conn/chart.php',
        type: 'POST',
        data: { getPendingCount: true },
        dataType: 'json',
        success: function (data) {
            console.log('Data fetched successfully:', data);
            const pendingCount = data.pendingCount || 0;
            const completedCount = data.completedCount || 0;

            if (office !== 'Records Section') {
                $('.dashboard-card').eq(2).find('span').text(data.pendingCount);
            } else {
                $('.dashboard-card').eq(3).find('span').text(data.pendingCount);
            }
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Pending', 'Completed'],
                    datasets: [{
                        data: [pendingCount, completedCount],
                        backgroundColor: ['#FF6384', '#36A2EB'],
                        hoverBackgroundColor: ['#FF6384', '#36A2EB']
                    }]
                },
                options: {
                    cutout: '40%',
                    plugins: {
                        legend: { display: false },
                        tooltip: { enabled: false }
                    }
                }
            });
        },
        error: function (xhr, status, error) {
            console.error('Error fetching pending count:', error);
        }
    });
});
