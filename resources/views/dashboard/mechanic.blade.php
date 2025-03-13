@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Vehículos en Reparación</h1>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Matrícula</th>
                <th>Estado</th>
                <th>Verificado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="vehicle-list">
            <!-- Los datos se llenarán dinámicamente con JavaScript -->
        </tbody>
    </table>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    fetch("/mechanic/vehicle")
        .then(response => response.json())
        .then(data => {
            let tableBody = document.getElementById("vehicle-list");
            tableBody.innerHTML = "";

            data.forEach(vehicle => {
                let row = `
                    <tr data-id="${vehicle.id}">
                        <td>${vehicle.id}</td>
                        <td>${vehicle.brand}</td>
                        <td>${vehicle.model}</td>
                        <td>${vehicle.license_plate}</td>
                        <td>
                            <select class="status-select">
                                <option value="In queue" ${vehicle.status == 'In queue' ? 'selected' : ''}>In queue</option>
                                <option value="In repair" ${vehicle.status == 'In repair' ? 'selected' : ''}>In repair</option>
                                <option value="Repaired" ${vehicle.status == 'Repaired' ? 'selected' : ''}>Repaired</option>
                            </select>
                        </td>
                        <td>
                            <input type="checkbox" class="verified-check" ${vehicle.verified ? 'checked' : ''}>
                        </td>
                        <td>
                            <button class="btn btn-success save-btn">Guardar</button>
                            <button class="btn btn-danger delete-btn">Eliminar</button>
                        </td>
                    </tr>
                `;
                tableBody.innerHTML += row;
            });

            // Asignar eventos a los botones
            document.querySelectorAll(".save-btn").forEach(btn => {
                btn.addEventListener("click", function() {
                    let row = this.closest("tr");
                    let vehicleId = row.dataset.id;
                    let updatedVehicle = {
                        id: vehicleId,
                        brand: row.cells[1].innerText,
                        model: row.cells[2].innerText,
                        license_plate: row.cells[3].innerText,
                        status: row.querySelector(".status-select").value,
                        verified: row.querySelector(".verified-check").checked ? 1 : 0
                    };

                    // Guardar datos en localStorage
                    localStorage.setItem("vehicle_" + vehicleId, JSON.stringify(updatedVehicle));

                    // Eliminar el vehículo
                    fetch(`/mechanic/vehicle/${vehicleId}`, { method: "DELETE", headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" } })
                        .then(response => response.json())
                        .then(() => {
                            // Crear el vehículo con los datos actualizados
                            return fetch("/mechanic/vehicle", {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json",
                                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                },
                                body: JSON.stringify(updatedVehicle)
                            });
                        })
                        .then(response => response.json())
                        .then(() => {
                            alert("Vehículo actualizado correctamente");
                            location.reload();
                        })
                        .catch(error => console.error("Error:", error));
                });
            });

            document.querySelectorAll(".delete-btn").forEach(btn => {
                btn.addEventListener("click", function() {
                    let row = this.closest("tr");
                    let vehicleId = row.dataset.id;

                    fetch(`/mechanic/vehicle/${vehicleId}`, { method: "DELETE", headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" } })
                        .then(response => response.json())
                        .then(() => {
                            alert("Vehículo eliminado correctamente");
                            location.reload();
                        })
                        .catch(error => console.error("Error eliminando:", error));
                });
            });
        })
        .catch(error => console.error("Error cargando vehículos:", error));
});
</script>
@endsection
