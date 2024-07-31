<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thai Province Data</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet">
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
        <div class="form-group">
            <label for="search-select">ค้นหาจังหวัด อำเภอ ตำบล</label>
            <select id="search-select" class="form-control">
                <option value="">เลือก...</option>
            </select>
        </div>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>รหัสจังหวัด</th>
                    <th>ชื่อจังหวัด</th>
                    <th>รหัสเขต</th>
                    <th>ชื่ออำเภอ</th>
                    <th>รหัสตำบล</th>
                    <th>ชื่อตำบล</th>
                </tr>
            </thead>
            <tbody id="data-table">
                <!-- Data will be inserted here -->
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>
    <script>
        let dataCache = [];

        async function fetchData() {
            const response = await fetch('https://raw.githubusercontent.com/kongvut/thai-province-data/master/api_province_with_amphure_tambon.json');
            const data = await response.json();
            dataCache = data; // Save data to cache

            const tableBody = document.getElementById('data-table');
            const searchSelect = document.getElementById('search-select');
            tableBody.innerHTML = '';

            data.forEach(province => {
                province.amphure.forEach(amphure => {
                    amphure.tambon.forEach(tambon => {
                        // Add option to select2
                        const option = document.createElement('option');
                        option.value = `${province.name_th}-${amphure.name_th}-${tambon.name_th}`;
                        option.textContent = `${province.name_th} - ${amphure.name_th} - ${tambon.name_th}`;
                        searchSelect.appendChild(option);
                    });
                });
            });

            // Initialize select2
            $('#search-select').select2();

            // Add event listener for select2 change
            $('#search-select').on('change', function() {
                const selectedValue = $(this).val();
                if (selectedValue === "") {
                    displayAllData();
                } else {
                    displaySelectedData(selectedValue);
                }
            });

            // Display all data initially
            displayAllData();
        }

        function displayAllData() {
            const tableBody = document.getElementById('data-table');
            tableBody.innerHTML = '';

            dataCache.forEach(province => {
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

        function displaySelectedData(selectedValue) {
            const tableBody = document.getElementById('data-table');
            tableBody.innerHTML = '';

            if (!selectedValue) return;

            const [selectedProvince, selectedAmphure, selectedTambon] = selectedValue.split('-');

            dataCache.forEach(province => {
                if (province.name_th === selectedProvince) {
                    province.amphure.forEach(amphure => {
                        if (amphure.name_th === selectedAmphure) {
                            amphure.tambon.forEach(tambon => {
                                if (tambon.name_th === selectedTambon) {
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
                                }
                            });
                        }
                    });
                }
            });
        }

        fetchData();
    </script>
</body>
</html>
