<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Electricity Consumption Calculator</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #00d2d3, #03a9f4);
            font-family: 'Arial', sans-serif;
        }
        .container {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.2);
            padding: 40px;
            max-width: 600px;
            margin-top: 50px;
        }
        h2 {
            color: #000000;
            margin-bottom: 30px;
            font-family: 'Roboto', sans-serif;
            font-size: 1.75rem;
        }
        .form-group label {
            font-weight: bold;
            color: #000000;
        }
        .btn-primary {
            background-color: #00d2d3;
            border-color: #00d2d3;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        .btn-primary:hover {
            background-color: #00b1b2;
            border-color: #00b1b2;
            transform: scale(1.05);
        }
        table {
            margin-top: 20px;
            border-collapse: collapse;
            width: 100%;
        }
        table th {
            background-color: #00d2d3;
            color: #ffffff;
            text-align: center;
            padding: 10px;
        }
        table tr:nth-child(even) {
            background-color: #f1f8f7;
        }
        table td {
            text-align: center;
            padding: 10px;
            border: 1px solid #dee2e6;
        }
        .result-section {
            background-color: #e0f2f1;
            border-radius: 8px;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .result-section h4 {
            color: #004d40;
            margin-bottom: 15px;
            font-size: 1.25rem;
        }
        .result-section p {
            margin-bottom: 10px;
            font-weight: bold;
            color: #004d40;
            font-size: 1rem;
        }
        @media (max-width: 768px) {
            .container {
                padding: 20px;
                margin-top: 20px;
            }
            h2 {
                font-size: 1.5rem;
            }
            .result-section h4 {
                font-size: 1.1rem;
            }
            .result-section p {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <h2 class="text-center">Electricity Consumption Calculator</h2>
    <form method="post" action="">
        <div class="form-group">
            <label for="voltage">Voltage (V):</label>
            <input type="number" step="any" class="form-control" id="voltage" name="voltage" required>
        </div>
        <div class="form-group">
            <label for="current">Current (A):</label>
            <input type="number" step="any" class="form-control" id="current" name="current" required>
        </div>
        <div class="form-group">
            <label for="rate">Current Rate (sen/kWh):</label>
            <input type="number" step="any" class="form-control" id="rate" name="rate" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Calculate</button>
    </form>

    <?php
    function calculatePower($voltage, $current) {
        return $voltage * $current;
    }

    function calculateEnergyPerHour($power) {
        return $power / 1000;
    }

    function calculateCostPerHour($energyPerHour, $rate) {
        return $energyPerHour * ($rate / 100);
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $voltage = floatval($_POST['voltage']);
        $current = floatval($_POST['current']);
        $rate = floatval($_POST['rate']);

        $power = calculatePower($voltage, $current);
        $energyPerHour = calculateEnergyPerHour($power);
        $totalPerHour = calculateCostPerHour($energyPerHour, $rate);

        echo "<div class='result-section'>";
        echo "<h4>Results</h4>";
        echo "<p>Power: " . number_format($power, 5) . " W</p>";
        echo "<p>Energy per Hour: " . number_format($energyPerHour, 5) . " kWh</p>";
        echo "<p>Total Cost per Hour: RM " . number_format($totalPerHour, 2) . "</p>";
        echo "</div>";

        echo "<table class='table table-bordered mt-3'>
                <thead>
                    <tr>
                        <th># Hour</th>
                        <th>Energy (kWh)</th>
                        <th>Total (RM)</th>
                    </tr>
                </thead>
                <tbody>";

        for ($hour = 1; $hour <= 24; $hour++) {
            $energy = $energyPerHour * $hour;
            $total = $totalPerHour * $hour;
            echo "<tr>
                    <td>$hour</td>
                    <td>" . number_format($energy, 5) . "</td>
                    <td>RM " . number_format($total, 2) . "</td>
                  </tr>";
        }

        echo "</tbody></table>";
    }
    ?>
</div>
</body>
</html>
