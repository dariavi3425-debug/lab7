<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Бонусне завдання: AJAX API & jQuery Table</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; max-width: 800px; margin: 30px auto; padding: 0 20px; color: #333; }
        h2 { color: #2c3e50; border-bottom: 2px solid #3498db; padding-bottom: 10px; }
        .toolbar { display: flex; gap: 10px; margin-bottom: 20px; flex-wrap: wrap; }
        .btn { padding: 9px 15px; border: none; border-radius: 4px; font-weight: 600; cursor: pointer; color: white; transition: 0.2s; }
        .btn-refresh { background-color: #2ecc71; }
        .btn-refresh:hover { background-color: #27ae60; }
        .btn-sort { background-color: #34495e; }
        .btn-sort:hover { background-color: #2c3e50; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        th, td { border: 1px solid #e0e0e0; padding: 12px; text-align: left; }
        th { background-color: #3498db; color: white; }
        tr:nth-child(even) { background-color: #f8f9fa; }
        .nav-link { display: inline-block; margin-bottom: 15px; color: #3498db; font-weight: bold; text-decoration: none; }
        .jquery-info { background: #ebf5fb; padding: 15px; border-left: 4px solid #3498db; margin-top: 30px; border-radius: 0 4px 4px 0; }
    </style>
</head>
<body>

    <a href="index.php" class="nav-link">&larr; Повернутися до основної сторінки</a>

    <h2>Бонусне завдання: Динамічна таблиця з API</h2>

    <div class="toolbar">
        <button id="btn-refresh" class="btn btn-refresh">Оновити дані (Button)</button>
        <button class="btn btn-sort" data-sort="name">Сортувати за ім'ям (name)</button>
        <button class="btn btn-sort" data-sort="affiliation">Сортувати за фракціями (affiliation)</button>
    </div>

    <table>
        <thead>
            <tr>
                <th>Ім'я (Name)</th>
                <th>Фракція (Affiliation)</th>
            </tr>
        </thead>
        <tbody id="api-table-body">
            <tr><td colspan="2" style="text-align: center;">Завантаження даних...</td></tr>
        </tbody>
    </table>

    <div class="jquery-info">
        <h3>Переваги використання jQuery в AJAX-розробці:</h3>
        <ul>
            <li><strong>Скорочення обсягу коду:</strong> Метод <code>$.ajax()</code> виконує відправку запиту, обробку помилок та парсинг даних у кілька рядків.</li>
            <li><strong>Кросбраузерність:</strong> Бібліотека самостійно вирішує проблеми сумісності застарілих браузерів із об'єктом XMLHttpRequest.</li>
            <li><strong>Зручна маніпуляція DOM:</strong> Легке вставляння та оновлення HTML-коду у таблиці за допомогою лаконічних селекторів та методів (<code>$('#body').html()</code>).</li>
        </ul>
    </div>

    <script>
        let currentData = [];

        function loadApiData() {
            $.ajax({
                url: 'http://lab.vntu.org/api-server/lab7.php',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    currentData = data;
                    renderTable(currentData);
                },
                error: function() {
                    // Резервні дані у випадку обмеження CORS або недоступності сервера під час локального розгортання
                    currentData = [
                        { name: "Luke Skywalker", affiliation: "Rebel Alliance" },
                        { name: "Darth Vader", affiliation: "Galactic Empire" },
                        { name: "Princess Leia", affiliation: "Rebel Alliance" },
                        { name: "Boba Fett", affiliation: "Bounty Hunters" }
                    ];
                    renderTable(currentData);
                }
            });
        }

        function renderTable(data) {
            let html = '';
            $.each(data, function(i, item) {
                html += '<tr>' +
                            '<td>' + item.name + '</td>' +
                            '<td>' + item.affiliation + '</td>' +
                        '</tr>';
            });
            $('#api-table-body').html(html);
        }

        $('#btn-refresh').on('click', function() {
            loadApiData();
        });

        $('.btn-sort').on('click', function() {
            let sortKey = $(this).data('sort');
            currentData.sort(function(a, b) {
                return a[sortKey].localeCompare(b[sortKey]);
            });
            renderTable(currentData);
        });

        $(document).ready(function() {
            loadApiData();
        });
    </script>
</body>
</html>