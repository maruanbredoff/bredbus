<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard da Rodoviária</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<?php
include '../config.php';

// Total de vendas de passagem ao longo do tempo
function getSalesData($con) {
    $sql = "SELECT dataviagem, SUM(valor) as total_vendas FROM passagem JOIN viagem ON passagem.idviagem = viagem.idviagem GROUP BY dataviagem";
    $result = $con->query($sql);

    if (!$result) {
        die("Query failed: " . $con->error);
    }

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}

// Total de passagem vendidas por funcionário
function getTicketsByEmployee($con) {
    $sql = "SELECT f.usuario as usuario, COUNT(*) as total_passagem 
            FROM passagem 
            JOIN usuario f ON passagem.atendente = f.usuario
            GROUP BY f.usuario";
    $result = $con->query($sql);

    if (!$result) {
        die("Query failed: " . $con->error);
    }

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}

// Total de despesas ao longo do tempo
function getExpensesData($con) {
    $sql = "SELECT data_movimento, SUM(valor) as total_despesas 
    FROM contas_pagar_movi 
    GROUP BY data_movimento";
    $result = $con->query($sql);

    if (!$result) {
        die("Query failed: " . $con->error);
    }

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}

$salesData = getSalesData($con);
$ticketsByEmployee = getTicketsByEmployee($con);
$expensesData = getExpensesData($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard da Rodoviária</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div>
        <h1>Dashboard da Rodoviária</h1>
        
        <!-- Gráfico de Linhas: Total de Vendas ao Longo do Tempo -->
        <canvas id="salesChart"></canvas>
        
        <!-- Gráfico de Barras: Total de Passagens Vendidas por Funcionário -->
        <canvas id="ticketsChart"></canvas>
        
        <!-- Gráfico de Linhas: Total de Despesas ao Longo do Tempo -->
        <canvas id="expensesChart"></canvas>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Dados do Gráfico de Linhas: Total de Vendas ao Longo do Tempo
            var salesCtx = document.getElementById('salesChart').getContext('2d');
            var salesData = <?php echo json_encode($salesData); ?>;
            var salesLabels = salesData.map(function(item) { return item.data_viagem; });
            var salesValues = salesData.map(function(item) { return item.total_vendas; });

            var salesChart = new Chart(salesCtx, {
                type: 'line',
                data: {
                    labels: salesLabels,
                    datasets: [{
                        label: 'Total de Vendas',
                        data: salesValues,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
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

            // Dados do Gráfico de Barras: Total de Passagens Vendidas por Funcionário
            var ticketsCtx = document.getElementById('ticketsChart').getContext('2d');
            var ticketsData = <?php echo json_encode($ticketsByEmployee); ?>;
            var ticketsLabels = ticketsData.map(function(item) { return item.usuario; });
            var ticketsValues = ticketsData.map(function(item) { return item.total_passagens; });

            var ticketsChart = new Chart(ticketsCtx, {
                type: 'bar',
                data: {
                    labels: ticketsLabels,
                    datasets: [{
                        label: 'Passagens Vendidas',
                        data: ticketsValues,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
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

            // Dados do Gráfico de Linhas: Total de Despesas ao Longo do Tempo
            var expensesCtx = document.getElementById('expensesChart').getContext('2d');
            var expensesData = <?php echo json_encode($expensesData); ?>;
            var expensesLabels = expensesData.map(function(item) { return item.data_despesa; });
            var expensesValues = expensesData.map(function(item) { return item.total_despesas; });

            var expensesChart = new Chart(expensesCtx, {
                type: 'line',
                data: {
                    labels: expensesLabels,
                    datasets: [{
                        label: 'Total de Despesas',
                        data: expensesValues,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
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
        });
    </script>
</body>
</html>
