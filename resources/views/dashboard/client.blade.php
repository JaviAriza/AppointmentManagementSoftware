<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Taller Mecánico RápidoFix</title>
  <style>
    body { background: #f3f4f6; font-family: Arial, sans-serif; margin: 0; overflow: hidden; }
    nav.header { background: black; color: white; padding: 15px; display: flex; justify-content: center; align-items: center; height: 60px; }
    nav.header h1 { color: red; font-size: 28px; margin: 0; }
    .container { display: flex; justify-content: center; align-items: flex-start; min-height: 90vh; margin-top: 20px; }
    .box { background: white; padding: 60px 20px 20px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); text-align: center; width: 600px; min-height: 300px; position: relative; display: flex; flex-direction: column; align-items: center; }
    .box nav.card-nav { background: black; color: white; padding: 10px 20px; border-radius: 12px 12px 0 0; text-align: center; font-size: 20px; width: 600px; position: absolute; top: 0; left: 0; }
    .add-button { width: 130px; height: 130px; background: red; color: white; border: none; border-radius: 50%; font-size: 36px; line-height: 80px; cursor: pointer; text-align: center; margin-top: 60px; }
    .map-container {margin-top: 390px; position: absolute; border-radius: 20px; }
  </style>
<link rel="stylesheet" href="{{ asset('css/clientBlade.css') }}">
</head>
<body>

  <nav class="header"><h1>Taller Mecánico RápidoFix</h1></nav>
  <div class="container">
  <div class="box">
    <nav class="card-nav">Vehículos</nav>
    <p>Aquí puedes registrar y administrar tus vehículos.</p>
    <button class="add-button">+</button>
  </div>

  <div class="map-container">
    <iframe 
      width="600" 
      height="200" 
      loading="lazy" 
      allowfullscreen 
      referrerpolicy="no-referrer-when-downgrade" 
      src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12745.679184394314!2d-5.749153043392452!3d37.37425870942081!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd126f78e4cf5f9b%3A0x3cdba3bc29f25d62!2sC.%20Roda%20de%20la%20Mancha%2023%2C%2041500%20Mairena%20del%20Alcor%2C%20Sevilla!5e0!3m2!1ses!2ses!4v1709382920661">
    </iframe>
  </div>
</div>
</body>
</html>
