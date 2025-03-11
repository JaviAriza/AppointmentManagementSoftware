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


    .container { display: inline-grid; margin-top: 5%;margin-left: 6%}


    .box { background: white; padding: 60px 20px 20px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); text-align: center; width: 600px; min-height: 300px; position: relative; display: flex; flex-direction: column; align-items: center; }
    .box nav.card-nav { background: black; color: white; padding: 10px 20px; border-radius: 12px 12px 0 0; text-align: center; font-size: 20px; width: 600px; position: absolute; top: 0; left: 0; }
    .add-button { width: 130px; height: 130px; background: red; color: white; border: none; border-radius: 50%; font-size: 36px; line-height: 80px; cursor: pointer; text-align: center; margin-top: 60px; }
    .add-button-cars { width: 130px; height: 130px; background: green; color: white; border: none; border-radius: 50%; font-size: 36px; line-height: 80px; cursor: pointer; text-align: center; margin-top: 60px; }
    .controlPanel{margin-left: 42%; position: absolute;}
  </style>
</head>
<body>

  <nav class="header"><h1>Taller Mecánico RápidoFix</h1></nav>
  <div class="controlPanel"><h2>Panel Administrador</h2></div>

  <div class="container">
    <div class="box">
      <nav class="card-nav">Solicitudes</nav>
      <p>Aquí puedes registrar y administrar tus solicitudes.</p>
      <button class="add-button">+</button>
    </div>
  </div>

  <div class="container">
      <div class="box">
        <nav class="card-nav">Coches</nav>
        <p>Aquí puedes registrar y administrar tus solicitudes.</p>
        <button class="add-button-cars">+</button>
      </div>
    </div>


</body>
</html>
