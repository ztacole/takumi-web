<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('assets/images/takumi_logo.png') }}">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <title>Takumi</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Poppins:ital,wght@0,500;0,800;1,500&display=swap');

        :root {
            --navy: #222A3D;
            --light-navy: #495b86;
            --light-blue: #8fabd6;
            --dark-gray: #333333;
            --gray: #8B8B8B;
            --light-gray: #f5f5f5;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins';
        }

        body {
            background-color: var(--light-navy);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            max-width: 400px;
            width: 100%;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        /* Judul */
        h2 {
            font-size: 20px;
            margin-bottom: 20px;
            color: #333;
        }

        /* Grup input kode */
        .input-group {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        /* Input angka */
        .input-group input {
            width: 60px;
            height: 60px;
            font-size: 32px;
            text-align: center;
            border: 2px solid #ccc;
            border-radius: 5px;
            outline: none;
            transition: border-color 0.3s ease;
        }

        .input-group input:focus {
            border-color: var(--light-navy);
            border-width: 4px;
        }

        /* Pesan error */
        #error-msg {
            margin-top: 15px;
            font-size: 18px;
            font-weight: bold;
        }

        .logo {
            width: 100%;
            height: 100%;
            margin-bottom: 25px;
            padding-right: 50px;

        }
    </style>
</head>

<body>
    <div class="container">
        <img src="{{ asset('assets/images/takumi_logo.png') }}" alt="" class="logo">
        <h2>Masukkan Kode Verifikasi</h2>
        <p id="error-msg" style="color: red; display: none;">Kode salah. Silakan coba lagi!</p>
        <div class="input-group">
            <input type="password" id="digit1" maxlength="1" oninput="moveToNext(this, 'digit2')" onkeydown="moveToPrev(event, this, null)" autofocus>
            <input type="password" id="digit2" maxlength="1" oninput="moveToNext(this, 'digit3')" onkeydown="moveToPrev(event, this, 'digit1')">
            <input type="password" id="digit3" maxlength="1" oninput="moveToNext(this, 'digit4')" onkeydown="moveToPrev(event, this, 'digit2')">
            <input type="password" id="digit4" maxlength="1" oninput="submitCode()" onkeydown="moveToPrev(event, this, 'digit3')">
        </div>
    </div>

    <script>
        function moveToNext(current, nextId) {
            if (current.value.length === 1) {
                document.getElementById(nextId).focus();
            }
        }

        function moveToPrev(event, current, prevFieldId) {
            if (event.key === "Backspace" && current.value === "") {
                document.getElementById(prevFieldId)?.focus();
            }
        }

        function submitCode() {
            let code =
                document.getElementById('digit1').value +
                document.getElementById('digit2').value +
                document.getElementById('digit3').value +
                document.getElementById('digit4').value;

            if (code.length === 4) {
                // Kirim kode ke halaman ini sendiri dengan AJAX
                fetch('/login', {
                        method: 'POST',
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            auth_code: code
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.location.href = 'https://backend24.site/Rian/XI/takumi/dashboard';
                        } else {
                            document.getElementById('error-msg').style.display = 'block';
                            resetInputs();

                            console.log(data);
                        }
                    })
                    .catch(error => {
                        document.getElementById('error-msg').style.display = 'block';
                        resetInputs();

                        console.error('Error:', error);
                    });
            }
        }

        function resetInputs() {
            document.getElementById('digit1').value = '';
            document.getElementById('digit2').value = '';
            document.getElementById('digit3').value = '';
            document.getElementById('digit4').value = '';
            document.getElementById('digit1').focus();
        }
    </script>
</body>

</html>