<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thai Province Data</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding: 20px;
        }
        table {
            width: 100%;
        }
        th, td {
            white-space: nowrap;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mb-4">Thai Province Data</h1>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Province ID</th>
                    <th>Province Name</th>
                    <th>Amphure ID</th>
                    <th>Amphure Name</th>
                    <th>Tambon ID</th>
                    <th>Tambon Name</th>
                </tr>
            </thead>
            <tbody id="data-table">
                <!-- Data will be inserted here -->
            </tbody>
        </table>
    </div>
    <script>
        async function fetchData() {
            const response = await fetch('https://raw.githubusercontent.com/kongvut/thai-province-data/master/api_province_with_amphure_tambon.json');
            const data = await response.json();

            const tableBody = document.getElementById('data-table');
            tableBody.innerHTML = '';

            data.forEach(province => {
                province.amphure.forEach(amphure => {
                    amphure.tambon.forEach(tambon => {
                        const row = document.createElement('tr');
                        
                        const provinceIdCell = document.createElement('td');
                        provinceIdCell.textContent = province.id;
                        row.appendChild(provinceIdCell);
                        
                        const provinceNameCell = document.createElement('td');
                        provinceNameCell.textContent = province.name_th;
                        row.appendChild(provinceNameCell);

                        const amphureIdCell = document.createElement('td');
                        amphureIdCell.textContent = amphure.id;
                        row.appendChild(amphureIdCell);

                        const amphureNameCell = document.createElement('td');
                        amphureNameCell.textContent = amphure.name_th;
                        row.appendChild(amphureNameCell);

                        const tambonIdCell = document.createElement('td');
                        tambonIdCell.textContent = tambon.id;
                        row.appendChild(tambonIdCell);

                        const tambonNameCell = document.createElement('td');
                        tambonNameCell.textContent = tambon.name_th;
                        row.appendChild(tambonNameCell);

                        tableBody.appendChild(row);
                    });
                });
            });
        }

        fetchData();
    </script>
</body>
</html>
