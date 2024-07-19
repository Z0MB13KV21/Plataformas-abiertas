document.addEventListener('DOMContentLoaded', function() {
    fetchMarcas();
    clearMarcaForm();
});

function clearMarcaForm() {
    document.getElementById('marca-form').reset();
    document.getElementById('marca-id').value = '';
}

function fetchMarcas() {
    clearMarcaForm();
    axios.get('index.php/marcas')
        .then(response => {
            const marcas = response.data;
            const marcasList = document.getElementById('marcas-list');
            marcasList.innerHTML = '';
            marcas.forEach(marca => {
                const li = document.createElement('li');
                li.classList.add('list-group-item');
                li.innerHTML = `
                    ID: ${marca.MarcaID}, Nombre: ${marca.Nombre}
                    <button class="btn btn-warning btn-sm float-right ml-2" onclick="editMarca(${marca.MarcaID})">Editar</button>
                    <button class="btn btn-danger btn-sm float-right" onclick="deleteMarca(${marca.MarcaID})">Eliminar</button>
                `;
                marcasList.appendChild(li);
            });

            document.getElementById('marca-form').reset();
        })
        .catch(error => console.error('Error fetching marcas:', error));
}

function saveMarca() {
    const id = document.getElementById('marca-id').value;
    const nombre = document.getElementById('marca-nombre').value;
    const data = { nombre };

    let url = 'index.php/marcas';
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
    .catch(error => console.error('Error saving marca:', error));
}

function deleteMarca(id) {
    axios.delete(`index.php/marcas/${id}`)
        .then(response => {
            fetchMarcas();
        })
        .catch(error => console.error('Error deleting marca:', error));
}

function editMarca(id) {
    axios.get(`index.php/marcas/${id}`)
        .then(response => {
            const marca = response.data;
            document.getElementById('marca-id').value = marca.MarcaID;
            document.getElementById('marca-nombre').value = marca.Nombre;
        })
        .catch(error => console.error('Error fetching marca:', error));
}
