<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="/RSA" method="POST">
        @csrf
        <textarea type="text" name="src" placeholder="Исходное сообщение" style="resize:vertical;"> </textarea>
        <div class="line">
            <select name="key_len">
                <option value="512">512</option>
                <option value="1024">1024</option>
                <option value="2048">2048</option>
                <option value="4096">4096</option>
            </select>
            <button name="function" value="encrypt">Шифровать</button>
            <button name="function" value="decrypt">Дешифровать</button>
        </div>
    </form>
</body>

<style>
    form {
        display: flex;
        flex-direction: column;

        max-width: 500px;
    }

    form .line {
        width: 100%;
        margin-top: 5px;

        display: flex;
        justify-content: space-between;
    }

    form>.line>* {
        width: 30%;
    }
</style>

</html>