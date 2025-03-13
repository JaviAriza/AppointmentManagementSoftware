    <html>
        <head>
            <style>
                body { background: #f3f4f6; font-family: Arial, sans-serif; margin: 0; overflow: hidden; }
                nav.header { background: black; color: white; padding: 15px; display: flex; justify-content: center; align-items: center; height: 60px; position: absolute; width: 100%; margin-top: -80px }
                nav.header h1 { color: red; font-size: 28px; margin: 0; }
            </style>
        </head>
    @extends('layouts.app')

    @section('content')

    <nav class="header"><h1>Taller Mecánico RápidoFix</h1></nav>
    <div class="container">
        <h1>Vehículos</h1>

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
                            <input type="checkbox" class="validated-check" ${vehicle.validated ? 'checked' : ''}> <!-- Cambié "verified" por "validated" -->
                        </td>
                        <td>
                            <button class="btn btn-success save-btn">Guardar</button>
                            <button class="btn btn-danger delete-btn">Eliminar</button>
                        </td>
                    </tr>
                `;
                tableBody.innerHTML += row;
            });

            document.querySelectorAll(".save-btn").forEach(btn => {
                btn.addEventListener("click", function() {
                    let row = this.closest("tr");
                    let vehicleId = row.dataset.id;
                    let updatedVehicle = {
                        status: row.querySelector(".status-select").value,
                        validated: row.querySelector(".validated-check").checked ? 1 : 0
                    };


                    fetch(`/mechanic/vehicle/${vehicleId}`, {
                        method: "PUT",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify(updatedVehicle)
                    })
                    .then(response => response.json())
                    .then(() => {
                        alert("Vehículo actualizado correctamente");


                        row.querySelector(".status-select").value = updatedVehicle.status;
                        row.querySelector(".validated-check").checked = updatedVehicle.validated;
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


                            row.remove();
                        })
                        .catch(error => console.error("Error eliminando:", error));
                });
            });
        })
        .catch(error => console.error("Error cargando vehículos:", error));
});


    </script>

    @endsection
    </html>
