document.addEventListener('DOMContentLoaded', function() {
    fetchMarcasSelect();
    fetchPrendas();
    clearPrendaForm();
});

let marcasMap = {};

function fetchMarcasSelect() {
    axios.get('../index.php/marcas')
        .then(response => {
            const marcas = response.data;
            const marcaSelect = document.getElementById('prenda-marca-id');
            marcaSelect.innerHTML = '<option value="" disabled>Seleccione una marca</option>';
            marcas.forEach(marca => {
                const option = document.createElement('option');
                option.value = marca.MarcaID;
                option.textContent = marca.Nombre;
                marcaSelect.appendChild(option);

                marcasMap[marca.MarcaID] = marca.Nombre;
            });
        })
        .catch(error => {
            console.error('Error fetching marcas:', error);
            alert('No se pudieron cargar las marcas.');
        });
}

function clearPrendaForm() {
    document.getElementById('prenda-form').reset();
    document.getElementById('prenda-id').value = '';
    document.getElementById('prenda-marca-id').value = '';
    document.getElementById('nombre-error').textContent = '';
    document.getElementById('prenda-nombre').classList.remove('is-invalid');
}

function fetchPrendas() {
    axios.get('../index.php/prendas')
        .then(response => {
            const prendas = response.data;
            const prendasTableBody = document.querySelector('#prendas-table tbody');
            prendasTableBody.innerHTML = '';
            prendas.forEach(prenda => {
                const marcaNombre = marcasMap[prenda.MarcaID] || 'Desconocida';
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${prenda.PrendaID}</td>
                    <td>${prenda.Nombre}</td>
                    <td>${prenda.Talla}</td>
                    <td>${prenda.Precio}</td>
                    <td>${prenda.Stock}</td>
                    <td>${marcaNombre}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="editPrenda(${prenda.PrendaID})">Editar</button>
                        <button class="btn btn-danger btn-sm" onclick="confirmDeletePrenda(${prenda.PrendaID})">Eliminar</button>
                    </td>
                `;
                prendasTableBody.appendChild(row);
            });
            clearPrendaForm();
        })
        .catch(error => console.error('Error fetching prendas:', error));
}

function savePrenda() {
    if (!validatePrendaForm()) {
        return;
    }

    const id = document.getElementById('prenda-id').value;
    const nombre = document.getElementById('prenda-nombre').value;
    const talla = document.getElementById('prenda-talla').value;
    const precio = document.getElementById('prenda-precio').value;
    const stock = document.getElementById('prenda-stock').value;
    const marcaId = document.getElementById('prenda-marca-id').value;
    const data = { nombre, talla, precio, stock, marca_id: marcaId };

    let url = '../index.php/prendas';
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
        if (response.data.error) {
            document.getElementById('nombre-error').textContent = response.data.error;
            document.getElementById('prenda-nombre').classList.add('is-invalid');
        } else {
            fetchPrendas();
        }
    })
    .catch(error => {
///        console.error('Error saving prenda:', error);
        if (error.response) {
 ///           console.log('Response data:', error.response.data);
    ///        console.log('Response status:', error.response.status);
       ///     console.log('Response headers:', error.response.headers);
            if (error.response.data.error) {
                document.getElementById('nombre-errorprenda').textContent = error.response.data.error;
                document.getElementById('prenda-nombre').classList.add('is-invalid');
            }
        }
    });
}

function confirmDeletePrenda(id) {
    if (confirm('¿Estás seguro de que deseas eliminar esta prenda?')) {
        deletePrenda(id);
    }
}

function deletePrenda(id) {
    axios.delete(`../index.php/prendas/${id}`)
        .then(response => {
            fetchPrendas(); 
        })
        .catch(error => console.error('Error deleting prenda:', error));
}

function editPrenda(id) {
    axios.get(`../index.php/prendas/${id}`)
        .then(response => {
            const prenda = response.data;
            document.getElementById('prenda-id').value = prenda.PrendaID;
            document.getElementById('prenda-nombre').value = prenda.Nombre;
            document.getElementById('prenda-talla').value = prenda.Talla;
            document.getElementById('prenda-precio').value = prenda.Precio;
            document.getElementById('prenda-stock').value = prenda.Stock;
            document.getElementById('prenda-marca-id').value = prenda.MarcaID;
        })
        .catch(error => console.error('Error fetching prenda:', error));
}

function validatePrendaForm() {
    const nombre = document.getElementById('prenda-nombre').value.trim();
    const errorElement = document.getElementById('nombre-error');
    errorElement.textContent = '';

    if (nombre.length < 2) {
        errorElement.textContent = 'El nombre debe tener al menos 2 caracteres.';
        document.getElementById('prenda-nombre').classList.add('is-invalid');
        return false;
    }

    if (nombre.length > 20) {
        errorElement.textContent = 'El nombre no puede tener más de 20 caracteres.';
        document.getElementById('prenda-nombre').classList.add('is-invalid');
        return false;
    }

    document.getElementById('prenda-nombre').classList.remove('is-invalid');
    return true;
}
