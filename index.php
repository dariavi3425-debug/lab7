<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ЛР7: AJAX та Динамічні веб-сторінки</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; max-width: 680px; margin: 30px auto; padding: 0 20px; color: #333; }
        h2 { color: #2c3e50; border-bottom: 2px solid #3498db; padding-bottom: 10px; margin-top: 30px; }
        .form-group { margin-bottom: 16px; }
        label { font-weight: 600; display: block; margin-bottom: 6px; }
        input[type="text"], input[type="email"], select, textarea { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { background-color: #3498db; color: white; padding: 11px 18px; border: none; border-radius: 4px; font-size: 15px; cursor: pointer; transition: background 0.3s; }
        button:hover { background-color: #2980b9; }
        .joke-card { background: #fdfefe; border: 1px solid #e0e0e0; border-left: 5px solid #f39c12; padding: 15px; border-radius: 4px; margin-bottom: 20px; }
        .ajax-response { display: none; background: #e8f8f5; border-left: 5px solid #2ecc71; padding: 15px; margin-top: 20px; border-radius: 4px; }
        .nav-link { display: inline-block; margin-bottom: 15px; color: #3498db; font-weight: bold; text-decoration: none; }
        .nav-link:hover { text-decoration: underline; }
    </style>
</head>
<body>

    <a href="bonus.php" class="nav-link">&rarr; Перейти до Бонусного завдання (Динамічна таблиця API)</a>

    <h2>Завдання 2: Випадковий жарт (XMLHttpRequest)</h2>
    <div class="joke-card">
        <p id="joke-display"><em>Натисніть кнопку нижче, щоб підвантажити жарт...</em></p>
        <button id="btn-load-joke">Отримати випадковий жарт</button>
    </div>

    <h2>Завдання 3: Опитування з асинхронним відправленням (jQuery AJAX)</h2>
    <form id="ajax-survey-form">
        <div class="form-group">
            <label for="name">Ваше ім'я:</label>
            <input type="text" id="name" name="name" required placeholder="Введіть ваше ім'я">
        </div>
        <div class="form-group">
            <label for="email">Ваш Email:</label>
            <input type="email" id="email" name="email" required placeholder="example@mail.com">
        </div>
        <div class="form-group">
            <label for="genre">Улюблений жанр книг?</label>
            <select id="genre" name="genre">
                <option value="Фентезі">Фентезі</option>
                <option value="Детектив">Детектив</option>
                <option value="Наукова фантастика">Наукова фантастика</option>
                <option value="Романтика">Романтика</option>
                <option value="Сучасна проза">Сучасна проза</option>
            </select>
        </div>
        <div class="form-group">
            <label for="format">В якому форматі найчастіше читаєте?</label>
            <select id="format" name="format">
                <option value="Паперові книги">Паперові книги</option>
                <option value="Електронні книги (e-book)">Електронні книги (e-book)</option>
                <option value="Аудіокниги">Аудіокниги</option>
            </select>
        </div>
        <div class="form-group">
            <label for="feedback">Ваша улюблена книга або коментар:</label>
            <textarea id="feedback" name="feedback" rows="3" required placeholder="Поділіться вашими враженнями..."></textarea>
        </div>
        <button type="submit">Надіслати анкету (без перезавантаження)</button>
    </form>

    <div id="response-box" class="ajax-response"></div>

    <script>
        // 1. Отримання випадкового жарту через XMLHttpRequest
        document.getElementById('btn-load-joke').addEventListener('click', function() {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'jokes.txt', true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var lines = xhr.responseText.split('\n').filter(Boolean);
                    var randomIndex = Math.floor(Math.random() * lines.length);
                    document.getElementById('joke-display').innerText = lines[randomIndex];
                }
            };
            xhr.send();
        });

        // 2. Асинхронна відправка форми через jQuery AJAX
        $('#ajax-survey-form').on('submit', function(e) {
            e.preventDefault();
            
            $.ajax({
                url: 'process.php',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(res) {
                    if (res.status === 'success') {
                        $('#response-box').html(
                            '<h3 style="margin-top:0; color:#27ae60;">' + res.message + '</h3>' +
                            '<p><strong>Дата та час заповнення форми:</strong> ' + res.dateTime + '</p>'
                        ).fadeIn();
                        $('#ajax-survey-form')[0].reset();
                    }
                },
                error: function() {
                    alert('Помилка під час відправки даних на сервер.');
                }
            });
        });
    </script>

</body>
</html>