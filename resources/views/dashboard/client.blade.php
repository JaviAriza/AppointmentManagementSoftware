<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Taller Mecánico RápidoFix</title>
  <style>
    /* Estilos vista */
    body { background: #f3f4f6; font-family: Arial, sans-serif; margin: 0; overflow: hidden; }
    nav.header { background: black; color: white; padding: 15px; display: flex; justify-content: center; align-items: center; height: 60px; }
    nav.header h1 { color: red; font-size: 28px; margin: 0; }
    .container { display: flex; justify-content: center; align-items: flex-start; min-height: 90vh; margin-top: 20px; }
    .box { background: white; padding: 60px 20px 20px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); text-align: center; width: 600px; min-height: 300px; position: relative; display: flex; flex-direction: column; align-items: center; }
    .box nav.card-nav { background: black; color: white; padding: 10px 20px; border-radius: 12px 12px 0 0; text-align: center; font-size: 20px; width: 600px; position: absolute; top: 0; left: 0; }
    .add-button { width: 130px; height: 130px; background: red; color: white; border: none; border-radius: 50%; font-size: 36px; line-height: 80px; cursor: pointer; text-align: center; margin-top: 60px; }
    .map-container {margin-top: 390px; position: absolute; border-radius: 20px; }
    /* Estilos formulario */
    .vehicle-form { display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.2); width: 500px; z-index: 1000; }
    .vehicle-form h2 {margin-top: 0; color: #333; }
    .form-group { margin-bottom: 15px; }
    .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
    .form-group input { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
    .form-buttons { display: flex; justify-content: space-between; margin-top: 20px; }
    .form-buttons button { padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; }
    .btn-save {mbackground: red; color: white; }
    .btn-cancel {background: #ccc;color: #333;}
    .overlay {display: none;position: fixed;top: 0;left: 0;width: 100%;height: 100%;background: rgba(0,0,0,0.5);z-index: 999;}
    .error-message {color: red;font-size: 12px; margin-top: 5px; }
    .success-message { background: #d4edda; color: #155724; padding: 10px; border-radius: 4px; margin-bottom: 15px; display: none; }
    .error-alert { background: #f8d7da; color: #721c24; padding: 10px; border-radius: 4px; margin-bottom: 15px; display: none; }
    .vehicles-list { width: 100%; margin-top: 20px; text-align: left; }
    .vehicle-item { background: #f9f9f9; padding: 10px; margin-bottom: 10px; border-radius: 4px; border-left: 4px solid red; }
    .vehicle-item h3 { margin: 0 0 5px 0; }
    .vehicle-details { display: flex; justify-content: space-between; font-size: 14px; color: #666; }
    .status-badge { display: inline-block; padding: 3px 8px; border-radius: 12px; font-size: 12px; font-weight: bold; }
    .status-queue { background-color: #fef3c7; color: #92400e; }
    .status-reparation { background-color: #dbeafe; color: #1e40af; }
    .status-reparated { background-color: #d1fae5; color: #065f46; }
    .debug-section { margin-top: 20px; padding: 10px; background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px; font-size: 12px; text-align: left; width: 100%; }
    .debug-section h3 { margin-top: 0; color: #333; }
    .debug-section pre { margin: 0; white-space: pre-wrap; word-wrap: break-word; }
    .cards-container { display: flex; flex-wrap: wrap; justify-content: center; gap: 20px; width: 100%; }
    .card { background: white; padding: 60px 20px 20px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); text-align: center; width: 280px; min-height: 300px; position: relative; display: flex; flex-direction: column; align-items: center; }
    .card nav.card-nav { background: black; color: white; padding: 10px 20px; border-radius: 12px 12px 0 0; text-align: center; font-size: 20px; width: 280px; position: absolute; top: 0; left: 0; }
    .list-button { width: 130px; height: 130px; background: #75cb8b; color: white; border: none; border-radius: 50%; font-size: 15px; line-height: 80px; cursor: pointer; text-align: center; margin-top: 60px; }
    .vehicles-modal { display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.2); width: 80%; max-width: 800px; max-height: 80vh; overflow-y: auto; z-index: 1000; }
    .vehicles-modal h2 { margin-top: 0; color: #333; text-align: center; padding-bottom: 10px; border-bottom: 1px solid #eee; }
    .modal-close { position: absolute; top: 10px; right: 15px; font-size: 24px; cursor: pointer; color: #999; }
    .modal-close:hover { color: #333; }
    .no-vehicles { text-align: center; padding: 20px; color: #666; }
  </style>
</head>
<body>

  <nav class="header"><h1>Taller Mecánico RápidoFix</h1></nav>

  <!-- Mensaje de éxito -->
  @if(session('success'))
  <div class="success-message" style="display: block;">
    {{ session('success') }}
  </div>
  @endif

  <!-- Mensaje de error -->
  @if(session('error'))
  <div class="error-alert" style="display: block;">
    {{ session('error') }}
  </div>
  @endif

  <div class="container">
    <div class="cards-container">
      <!-- Card para añadir vehículo -->
      <div class="card">
        <nav class="card-nav">Añadir Vehículo</nav>
        <p>Registra un nuevo vehículo en el sistema.</p>
        <button class="add-button" id="showFormBtn">+</button>
      </div>

      <!-- Card para ver vehículos -->
      <div class="card">
        <nav class="card-nav">Mis Vehículos</nav>
        <p>Consulta todos tus vehículos registrados.</p>
        <button class="list-button" id="showVehiclesBtn">
          <i class="fas fa-list"></i>
          <span style="font-size: 18px;">Ver vehículos</span>
        </button>
      </div>
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

  <!-- Overlay para oscurecer el fondo -->
  <div class="overlay" id="overlay"></div>

  <!-- Formulario para agregar vehículo -->
  <div class="vehicle-form" id="vehicleForm">
    <h2>Registrar Nuevo Vehículo</h2>

    <form action="{{ route('vehicle.guardar') }}" method="POST">
      @csrf

      <!-- marca -->
      <div class="form-group">
        <label for="brand">Marca:</label>
        <input type="text" id="brand" name="brand" value="{{ old('brand') }}" required>
        @error('brand')
        <div class="error-message">{{ $message }}</div>
        @enderror
      </div>

      <!-- modelo -->
      <div class="form-group">
        <label for="model">Modelo:</label>
        <input type="text" id="model" name="model" value="{{ old('model') }}" required>
        @error('model')
        <div class="error-message">{{ $message }}</div>
        @enderror
      </div>

      <!-- Campo para el año -->
      <div class="form-group">
        <label for="year">Año:</label>
        <input type="number" id="year" name="year" value="{{ old('year') }}" min="1900" max="{{ date('Y') }}" required>
        @error('year')
        <div class="error-message">{{ $message }}</div>
        @enderror
      </div>

      <!-- Campo para la matrícula -->
      <div class="form-group">
        <label for="license_plate">Matrícula:</label>
        <input type="text" id="license_plate" name="license_plate" value="{{ old('license_plate') }}" required>
        @error('license_plate')
        <div class="error-message">{{ $message }}</div>
        @enderror
      </div>

      <!-- Nota informativa sobre el estado inicial -->
      <div class="form-group">
        <p style="font-size: 12px; color: #666;">
          Nota: El vehículo se registrará inicialmente como "En cola" y pendiente de validación por un mecánico.
        </p>
      </div>

      <!-- Botones del formulario -->
      <div class="form-buttons">
        <button type="button" class="btn-cancel" id="cancelBtn">Cancelar</button>
        <button type="submit" class="btn-save">Guardar</button>
      </div>
    </form>
  </div>

  <!-- Modal para mostrar la lista de vehículos -->
  <div class="vehicles-modal" id="vehiclesModal">
    <span class="modal-close" id="closeVehiclesModal">&times;</span>
    <h2>Mis Vehículos</h2>

    <!-- Lista de vehículos -->
    @if(isset($vehicles) && count($vehicles) > 0)
    <div class="vehicles-list">
      @foreach($vehicles as $vehicle)
      <div class="vehicle-item">
        <h3>{{ $vehicle->brand }} {{ $vehicle->model }}</h3>
        <div class="vehicle-details">
          <span>Año: {{ $vehicle->year }}</span>
          <span>Matrícula: {{ $vehicle->license_plate }}</span>
          <span>
            Estado:
            <span class="status-badge
              {{ $vehicle->status == 'In queue' ? 'status-queue' : '' }}
              {{ $vehicle->status == 'In reparation' ? 'status-reparation' : '' }}
              {{ $vehicle->status == 'Reparated' ? 'status-reparated' : '' }}
            ">
              {{ $vehicle->status }}
            </span>
          </span>
          <span>
            {{ $vehicle->validated ? 'Validado' : 'Pendiente de validación' }}
          </span>
        </div>
      </div>
      @endforeach
    </div>
    @else
    <div class="no-vehicles">
      <p>No tienes vehículos registrados.</p>
    </div>
    @endif
  </div>

  <!-- Sección de depuración (solo visible en desarrollo) -->
  @if(isset($debug) && config('app.env') !== 'production')
  <div class="debug-section">
    <h3>Información de depuración</h3>
    <pre>{{ json_encode($debug, JSON_PRETTY_PRINT) }}</pre>

    @if(isset($client))
    <h4>Información del cliente</h4>
    <pre>ID: {{ $client->id }}, Email: {{ $client->email }}</pre>
    @endif

    <h4>Consulta SQL directa de vehículos</h4>
    @php
    $vehiclesFromDB = DB::table('vehicle')->where('client_id', $client->id ?? 0)->get();
    @endphp
    <pre>Vehículos encontrados: {{ count($vehiclesFromDB) }}</pre>
    @foreach($vehiclesFromDB as $v)
    <pre>ID: {{ $v->id }}, Cliente: {{ $v->client_id }}, Marca: {{ $v->brand }}, Modelo: {{ $v->model }}</pre>
    @endforeach
  </div>
  @endif

  <script>
    // JavaScript para mostrar/ocultar el formulario y la lista de vehículos
    document.addEventListener('DOMContentLoaded', function() {
      const showFormBtn = document.getElementById('showFormBtn');
      const vehicleForm = document.getElementById('vehicleForm');
      const overlay = document.getElementById('overlay');
      const cancelBtn = document.getElementById('cancelBtn');
      const successMessage = document.querySelector('.success-message');
      const errorAlert = document.querySelector('.error-alert');

      // Elementos para la lista de vehículos
      const showVehiclesBtn = document.getElementById('showVehiclesBtn');
      const vehiclesModal = document.getElementById('vehiclesModal');
      const closeVehiclesModal = document.getElementById('closeVehiclesModal');

      // Mostrar el formulario y el overlay
      showFormBtn.addEventListener('click', function() {
        vehicleForm.style.display = 'block';
        overlay.style.display = 'block';
      });

      // Ocultar el formulario y el overlay al hacer clic en Cancelar
      cancelBtn.addEventListener('click', function() {
        vehicleForm.style.display = 'none';
        overlay.style.display = 'none';
      });

      // Mostrar la lista de vehículos y el overlay
      showVehiclesBtn.addEventListener('click', function() {
        vehiclesModal.style.display = 'block';
        overlay.style.display = 'block';
      });

      // Ocultar la lista de vehículos y el overlay al hacer clic en Cerrar
      closeVehiclesModal.addEventListener('click', function() {
        vehiclesModal.style.display = 'none';
        overlay.style.display = 'none';
      });

      // Ocultar el formulario, la lista de vehículos y el overlay al hacer clic fuera
      overlay.addEventListener('click', function() {
        vehicleForm.style.display = 'none';
        vehiclesModal.style.display = 'none';
        overlay.style.display = 'none';
      });

      // Ocultar el mensaje de éxito después de 3 segundos
      if (successMessage) {
        setTimeout(function() {
          successMessage.style.display = 'none';
        }, 3000);
      }

      // Ocultar el mensaje de error después de 3 segundos
      if (errorAlert) {
        setTimeout(function() {
          errorAlert.style.display = 'none';
        }, 3000);
      }

      // Si hay errores de validación, mostrar el formulario
      @if($errors->any())
      vehicleForm.style.display = 'block';
      overlay.style.display = 'block';
      @endif
    });
  </script>
</body>
</html>

