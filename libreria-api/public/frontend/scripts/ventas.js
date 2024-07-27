document.addEventListener('DOMContentLoaded', function() {
    fetchVentas();
    fetchPrendasSelect();
    clearVentaForm();
});

function fetchPrendasSelect() {
    axios.get('../index.php/prendas')
        .then(response => {
            const prendas = response.data;
            const prendaSelect = document.getElementById('venta-prenda-id');
            prendaSelect.innerHTML = '<option value="" disabled selected>Seleccione una prenda</option>';
            prendas.forEach(prenda => {
                const option = document.createElement('option');
                option.value = prenda.PrendaID;
                option.textContent = `${prenda.Nombre} - Talla: ${prenda.Talla} - Precio: $${prenda.Precio} - Marca: ${prenda.MarcaID}`;
                prendaSelect.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Error fetching prendas:', error);
            alert('No se pudieron cargar las prendas.');
        });
}


function clearVentaForm() {
    document.getElementById('venta-form').reset();
    document.getElementById('venta-id').value = '';
    setNewDateConstraints();
    fetchPrendasSelect();
}

function fetchVentas() {
    axios.get('../index.php/ventas')
        .then(response => {
            const ventas = response.data;
            const ventasTableBody = document.querySelector('#ventas-table tbody');
            ventasTableBody.innerHTML = '';
            ventas.forEach(venta => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${venta.VentaID}</td>
                    <td>${venta.PrendaID}</td>
                    <td>${venta.Fecha}</td>
                    <td>${venta.Cantidad}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="editVenta(${venta.VentaID})">Editar</button>
                        <button class="btn btn-danger btn-sm" onclick="deleteVenta(${venta.VentaID})">Eliminar</button>
                    </td>
                `;
                ventasTableBody.appendChild(row);
            });
            clearVentaForm();
        })
        .catch(error => console.error('Error fetching ventas:', error));
}

function saveVenta() {
    if (!validateVentaForm()) {
        return;
    }

    const id = document.getElementById('venta-id').value;
    const prendaId = document.getElementById('venta-prenda-id').value;
    const fecha = document.getElementById('venta-fecha').value;
    const cantidad = document.getElementById('venta-cantidad').value;

    const data = { PrendaID: prendaId, Fecha: fecha, Cantidad: cantidad };

    let url = '../index.php/ventas';
    let method = 'POST';
    if (id) {
        url += `/${id}`;
        method = 'PUT';
    }

    axios({
        method: method,
        url: url,
        data: data
    })
    .then(response => {
        fetchVentas();
    })
    .catch(error => console.error('Error saving venta:', error));
}

function deleteVenta(id) {
    axios.delete(`../index.php/ventas/${id}`)
        .then(response => {
            fetchVentas(); 
        })
        .catch(error => console.error('Error deleting venta:', error));
}

function editVenta(id) {
    axios.get(`../index.php/ventas/${id}`)
        .then(response => {
            const venta = response.data;
            document.getElementById('venta-id').value = venta.VentaID;
            document.getElementById('venta-prenda-id').value = venta.PrendaID;
            document.getElementById('venta-fecha').value = venta.Fecha;
            document.getElementById('venta-cantidad').value = venta.Cantidad;

            // Set date constraints for editing
            setEditDateConstraints();
        })
        .catch(error => console.error('Error fetching venta:', error));
}

function validateVentaForm() {
    const fecha = document.getElementById('venta-fecha').value;
    const cantidad = document.getElementById('venta-cantidad').value.trim();

    if (fecha === '') {
        alert('La fecha es obligatoria.');
        return false;
    }

    if (isNaN(cantidad) || cantidad <= 0) {
        alert('La cantidad debe ser un número positivo.');
        return false;
    }

    return true;
}

function setNewDateConstraints() {
    const dateInput = document.getElementById('venta-fecha');
    const today = new Date();
    const threeMonthsFromNow = new Date();
    threeMonthsFromNow.setMonth(today.getMonth() + 3);

    dateInput.min = today.toISOString().split('T')[0];
    dateInput.max = threeMonthsFromNow.toISOString().split('T')[0];
}

function setEditDateConstraints() {
    const dateInput = document.getElementById('venta-fecha');
    const today = new Date();
    const threeMonthsAgo = new Date();
    threeMonthsAgo.setMonth(today.getMonth() - 3);

    dateInput.min = threeMonthsAgo.toISOString().split('T')[0];
    dateInput.max = today.toISOString().split('T')[0];
}
