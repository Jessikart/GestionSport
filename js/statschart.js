document.addEventListener("DOMContentLoaded", function() {
   var ctx = document.getElementById('statschart').getContext('2d');
console.log(matchLabels)
    var statschart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: matchLabels, // Récupéré depuis Twig
            datasets: [{
                label: 'Buts marqués',
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                data: matchData // Récupéré depuis Twig
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
});
