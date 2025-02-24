<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taller Mecánico RápidoFix</title>
    <style>
        body { background: #f3f4f6; font-family: Arial, sans-serif; margin: 0; overflow: hidden; }
        nav { background: black; color: white; padding: 15px; display: flex; justify-content: center; align-items: center; height: 60px; }
        nav h1 { color: red; font-size: 28px; margin: 0; }
        .container { display: flex; justify-content: center; align-items: flex-start; height: 90vh; margin-top: 80px; }

        .box { background: white; padding: 50px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); text-align: center; align-items: center; width: 400px; display: flex; flex-direction: column; }
        .box h2 { font-size: 26px; margin-bottom: 20px; }
        .button { display: flex; justify-content: center; align-items: center; width: 80%; padding: 15px; border-radius: 8px; font-size: 18px; font-weight: bold; text-decoration: none; text-align: center; color: white; margin-bottom: 15px; }
        .login { background: red; }
        .login:hover { background: darkred; }
        .register { background: #333; }
        .register:hover { background: black; }
    </style>
</head>
<body>
    <nav>
        <h1>Taller Mecánico RápidoFix</h1>
    </nav>
    <div class="container">
        <div class="box">
            <h2>Bienvenido</h2>
            <a href="{{ route('login') }}" class="button login">Iniciar Sesión</a>
            <a href="{{ route('register') }}" class="button register">Registrarse</a>
        </div>
    </div>
</body>
</html>