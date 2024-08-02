document.addEventListener('DOMContentLoaded', function() {
    fetchMarcas();
    clearMarcaForm();
});

function clearMarcaForm() {
    document.getElementById('marca-form').reset();
    document.getElementById('marca-id').value = '';
    document.getElementById('nombre-error').textContent = '';
    document.getElementById('marca-nombre').classList.remove('is-invalid');
}

function fetchMarcas() {
    clearMarcaForm();
    axios.get('../index.php/marcas')
        .then(response => {
            const marcas = response.data;
            const marcasTable = document.getElementById('marcas-table').getElementsByTagName('tbody')[0];
            marcasTable.innerHTML = '';
            marcas.forEach(marca => {
                let row = marcasTable.insertRow();
                row.innerHTML = `
                    <td>${marca.MarcaID}</td>
                    <td>${marca.Nombre}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="editMarca(${marca.MarcaID})">Editar</button>
                        <button class="btn btn-danger btn-sm" onclick="confirmDeleteMarca(${marca.MarcaID})">Eliminar</button>
                    </td>
                `;
            });
        })
        .catch(error => console.error('Error fetching marcas:', error));
}

function saveMarca(event) {
    event.preventDefault();

    if (!validateMarcaForm()) {
        return;
    }

    const id = document.getElementById('marca-id').value;
    const nombre = document.getElementById('marca-nombre').value;
    const data = { nombre };

    let url = '../index.php/marcas';
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
        fetchMarcas();
    })
    .catch(error => {
        if (error.response && error.response.data && error.response.data.error) {
            document.getElementById('nombre-error').textContent = error.response.data.error;
            document.getElementById('marca-nombre').classList.add('is-invalid');
        } else {
            console.error('Error saving marca:', error);
        }
    });
}

function deleteMarca(id) {
    axios.delete(`../index.php/marcas/${id}`)
        .then(response => {
            fetchMarcas();
        })
        .catch(error => console.error('Error deleting marca:', error));
}

function confirmDeleteMarca(id) {
    if (confirm('¿Estás seguro de que deseas eliminar esta marca?')) {
        deleteMarca(id);
    }
}

function editMarca(id) {
    axios.get(`../index.php/marcas/${id}`)
        .then(response => {
            const marca = response.data;
            document.getElementById('marca-id').value = marca.MarcaID;
            document.getElementById('marca-nombre').value = marca.Nombre;
        })
        .catch(error => console.error('Error fetching marca:', error));
}

function validateMarcaForm() {
    const nombre = document.getElementById('marca-nombre').value.trim();
    const errorElement = document.getElementById('nombre-error');
    errorElement.textContent = '';

    if (nombre.length < 2) {
        errorElement.textContent = 'El nombre debe tener al menos 2 caracteres.';
        document.getElementById('marca-nombre').classList.add('is-invalid');
        return false;
    }

    if (nombre.length > 20) {
        errorElement.textContent = 'El nombre no puede tener más de 20 caracteres.';
        document.getElementById('marca-nombre').classList.add('is-invalid');
        return false;
    }

    document.getElementById('marca-nombre').classList.remove('is-invalid');
    return true;
}
