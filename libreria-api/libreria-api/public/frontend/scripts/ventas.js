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

            // Crear una lista de promesas para obtener los nombres de las marcas
            const prendaPromises = prendas.map(prenda =>
                axios.get(`../index.php/marcas/${prenda.MarcaID}`)
                    .then(marcaResponse => ({
                        prenda: prenda,
                        marca: marcaResponse.data
                    }))
            );

            // Ejecutar todas las promesas y luego actualizar el select
            Promise.all(prendaPromises)
                .then(results => {
                    results.forEach(result => {
                        const { prenda, marca } = result;
                        const option = document.createElement('option');
                        option.value = prenda.PrendaID;
                        option.textContent = `${prenda.Nombre} - Talla: ${prenda.Talla} - Precio: $${prenda.Precio} - Marca: ${marca.Nombre}`;
                        prendaSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching marcas:', error));
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

            // Crear una lista de promesas para obtener los detalles de las prendas y las marcas
            const prendaPromises = ventas.map(venta =>
                axios.get(`../index.php/prendas/${venta.PrendaID}`)
                    .then(prendaResponse => {
                        const prenda = prendaResponse.data;
                        return axios.get(`../index.php/marcas/${prenda.MarcaID}`)
                            .then(marcaResponse => ({
                                venta: venta,
                                prenda: prenda,
                                marca: marcaResponse.data
                            }));
                    })
            );

            // Ejecutar todas las promesas y luego actualizar la tabla
            Promise.all(prendaPromises)
                .then(results => {
                    results.forEach(result => {
                        const { venta, prenda, marca } = result;
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${venta.VentaID}</td>
                            <td>${prenda.Nombre} - Talla: ${prenda.Talla} - Precio: $${prenda.Precio} - Marca: ${marca.Nombre}</td>
                            <td>${venta.Fecha}</td>
                            <td>${venta.Cantidad}</td>
                            <td>
                                <button class="btn btn-warning btn-sm" onclick="editVenta(${venta.VentaID})">Editar</button>
                                <button class="btn btn-danger btn-sm" onclick="deleteVenta(${venta.VentaID})">Eliminar</button>
                            </td>
                        `;
                        ventasTableBody.appendChild(row);
                    });
                })
                .catch(error => console.error('Error fetching prendas or marcas:', error));
            
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
    const cantidadInput = document.getElementById('venta-cantidad');
    const cantidad = parseInt(cantidadInput.value.trim(), 10);

    if (isNaN(cantidad) || cantidad <= 0) {
        showError(cantidadInput, 'La cantidad debe ser un número positivo.');
        return;
    }

    // Validar si la cantidad es menor o igual al stock disponible
    validateStock(prendaId, cantidad, id, fecha, cantidadInput);
}

function validateStock(prendaId, cantidad, id, fecha, cantidadInput) {
    axios.get(`../index.php/prendas/${prendaId}`)
        .then(response => {
            const prenda = response.data;
            const stock = prenda.Stock;

            if (cantidad > stock) {
                showError(cantidadInput, `La cantidad excede el stock disponible (${stock}).`);
                return;
            }

            // Si la cantidad es válida, enviar los datos al servidor
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
                clearVentaForm();
            })
            .catch(error => {
                console.error('Error saving venta:', error);
                alert('Error al guardar la venta.');
            });
        })
        .catch(error => {
            console.error('Error fetching prenda:', error);
            alert('Error al verificar el stock de la prenda.');
        });
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
        showError(document.getElementById('venta-fecha'), 'La fecha es obligatoria.');
        return false;
    }

    if (isNaN(cantidad) || cantidad <= 0) {
        showError(document.getElementById('venta-cantidad'), 'La cantidad debe ser un número positivo.');
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

function showError(input, message) {
    const errorDiv = document.createElement('div');
    errorDiv.className = 'invalid-feedback';
    errorDiv.textContent = message;
    input.classList.add('is-invalid');
    input.parentNode.appendChild(errorDiv);
    input.addEventListener('input', function() {
        input.classList.remove('is-invalid');
        errorDiv.remove();
    });
}

// Añadido para manejar la actualización del campo de cantidad cuando se selecciona una prenda
document.getElementById('venta-prenda-id').addEventListener('change', function() {
    const prendaId = this.value;
    if (prendaId) {
        axios.get(`../index.php/prendas/${prendaId}`)
            .then(response => {
                const prenda = response.data;
                const stock = prenda.Stock;
                const cantidadInput = document.getElementById('venta-cantidad');
                
                // Establecer el valor máximo del input de cantidad
                cantidadInput.max = stock;
                cantidadInput.value = Math.min(cantidadInput.value, stock); // Asegúrate de que el valor actual no exceda el nuevo stock
            })
            .catch(error => {
                console.error('Error fetching prenda:', error);
                alert('Error al obtener los detalles de la prenda.');
            });
    } else {
        const cantidadInput = document.getElementById('venta-cantidad');
        cantidadInput.max = '';
    }
});
