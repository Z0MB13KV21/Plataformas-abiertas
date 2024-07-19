document.addEventListener('DOMContentLoaded', function() {
    fetchVentas();
    fetchPrendasSelect();
    clearVentaForm();
});

function fetchPrendasSelect() {
    axios.get('index.php/prendas')
        .then(response => {
            const prendas = response.data;
            const prendaSelect = document.getElementById('venta-prenda-id');
            prendaSelect.innerHTML = '<option value="" disabled>Seleccione una prenda</option>';
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
    document.getElementById('venta-prenda-id').value = '';
}

function fetchVentas() {
    axios.get('index.php/ventas')
        .then(response => {
            const ventas = response.data;
            const ventasList = document.getElementById('ventas-list');
            ventasList.innerHTML = '';
            ventas.forEach(venta => {
                const li = document.createElement('li');
                li.classList.add('list-group-item');
                li.innerHTML = `
                    ID: ${venta.VentaID}, Prenda ID: ${venta.PrendaID}, Fecha: ${venta.Fecha}, Cantidad: ${venta.Cantidad}
                    <button class="btn btn-warning btn-sm float-right ml-2" onclick="editVenta(${venta.VentaID})">Editar</button>
                    <button class="btn btn-danger btn-sm float-right" onclick="deleteVenta(${venta.VentaID})">Eliminar</button>
                `;
                ventasList.appendChild(li);
            });
            clearVentaForm();
        })
        .catch(error => console.error('Error fetching ventas:', error));
}

function saveVenta() {
    const id = document.getElementById('venta-id').value;
    const prendaId = document.getElementById('venta-prenda-id').value;
    const fecha = document.getElementById('venta-fecha').value;
    const cantidad = document.getElementById('venta-cantidad').value;

    const data = { PrendaID: prendaId, Fecha: fecha, Cantidad: cantidad };

    let url = 'index.php/ventas';
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
    axios.delete(`index.php/ventas/${id}`)
        .then(response => {
            fetchVentas(); 
        })
        .catch(error => console.error('Error deleting venta:', error));
}

function editVenta(id) {
    axios.get(`index.php/ventas/${id}`)
        .then(response => {
            const venta = response.data;
            document.getElementById('venta-id').value = venta.VentaID;
            document.getElementById('venta-prenda-id').value = venta.PrendaID;
            document.getElementById('venta-fecha').value = venta.Fecha;
            document.getElementById('venta-cantidad').value = venta.Cantidad;
        })
        .catch(error => console.error('Error fetching venta:', error));
}
