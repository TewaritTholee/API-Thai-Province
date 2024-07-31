<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thailand Province List</title>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="App">
        <h1>Thailand Province List</h1>
        <label for="province">Province:</label>
        <select id="province" class="select2"></select>
        <br><br>
        <label for="district">District:</label>
        <select id="district" class="select2"></select>
        <br><br>
        <label for="subdistrict">Sub-district:</label>
        <select id="subdistrict" class="select2"></select>
        <br><br>
        <pre id="selected"></pre>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="app.js"></script>
</body>

</html>


<style>
    .App {
        text-align: center;
        margin-top: 50px;
    }

    label {
        display: inline-block;
        width: 100px;
        text-align: right;
    }

    .select2 {
        width: 300px;
    }
</style>


<script>
    $(document).ready(function() {
        let provinces = [];
        let amphures = [];
        let tambons = [];
        let selected = {
            province_id: undefined,
            amphure_id: undefined,
            tambon_id: undefined
        };

        // Fetch data
        fetch(
                "https://raw.githubusercontent.com/kongvut/thai-province-data/master/api_province_with_amphure_tambon.json"
            )
            .then((response) => response.json())
            .then((result) => {
                provinces = result;
                populateSelect("#province", provinces);
            });

        // Initialize Select2
        $(".select2").select2();

        function populateSelect(selector, list) {
            const $select = $(selector);
            $select.empty().append('<option>Select ...</option>');
            list.forEach((item) => {
                $select.append(
                    `<option value="${item.id}">${item.name_th} - ${item.name_en}</option>`
                );
            });
        }

        $("#province").on("change", function() {
            const provinceId = $(this).val();
            selected.province_id = provinceId ? Number(provinceId) : undefined;
            selected.amphure_id = undefined;
            selected.tambon_id = undefined;

            $("#district").val(null).trigger("change");
            $("#subdistrict").val(null).trigger("change");

            if (provinceId) {
                const province = provinces.find((p) => p.id === Number(provinceId));
                amphures = province ? province.amphure : [];
                populateSelect("#district", amphures);
            }

            updateSelectedDisplay();
        });

        $("#district").on("change", function() {
            const amphureId = $(this).val();
            selected.amphure_id = amphureId ? Number(amphureId) : undefined;
            selected.tambon_id = undefined;

            $("#subdistrict").val(null).trigger("change");

            if (amphureId) {
                const amphure = amphures.find((a) => a.id === Number(amphureId));
                tambons = amphure ? amphure.tambon : [];
                populateSelect("#subdistrict", tambons);
            }

            updateSelectedDisplay();
        });

        $("#subdistrict").on("change", function() {
            const tambonId = $(this).val();
            selected.tambon_id = tambonId ? Number(tambonId) : undefined;
            updateSelectedDisplay();
        });

        function updateSelectedDisplay() {
            $("#selected").text(JSON.stringify(selected, null, 4));
        }
    });
</script>