<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taller Mecánico RápidoFix</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-black text-white py-4 px-6 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-red-500">Taller Mecánico RápidoFix</h1>
        <ul class="flex space-x-4">
            <li><a href="#" class="hover:text-red-500">Inicio</a></li>
            <li><a href="#" class="hover:text-red-500">Servicios</a></li>
            <li><a href="#" class="hover:text-red-500">Contacto</a></li>
        </ul>
    </nav>

    <!-- Contenedor principal -->
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white p-8 rounded-lg shadow-lg w-96 text-center">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Bienvenido</h2>

            <a href="{{ route('login') }}" class="block w-full bg-red-500 text-white py-2 rounded-lg font-semibold mb-4 hover:bg-red-600">Iniciar Sesión</a>
            <a href="{{ route('register') }}" class="block w-full bg-gray-800 text-white py-2 rounded-lg font-semibold hover:bg-gray-900">Registrarse</a>
        </div>
    </div>
</body>
</html>