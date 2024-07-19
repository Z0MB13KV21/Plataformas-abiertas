document.addEventListener('DOMContentLoaded', function() {
    fetchMarcasSelect();
    fetchPrendas();
    clearPrendaForm();
});

let marcasMap = {};

function fetchMarcasSelect() {
    axios.get('index.php/marcas')
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
}

function fetchPrendas() {
    axios.get('index.php/prendas')
        .then(response => {
            const prendas = response.data;
            const prendasList = document.getElementById('prendas-list');
            prendasList.innerHTML = '';
            prendas.forEach(prenda => {
                const marcaNombre = marcasMap[prenda.MarcaID] || 'Desconocida'; 
                const li = document.createElement('li');
                li.classList.add('list-group-item');
                li.innerHTML = `
                    ID: ${prenda.PrendaID}, Nombre: ${prenda.Nombre}, Talla: ${prenda.Talla}, Precio: ${prenda.Precio}, Disponible: ${prenda.Stock}, Marca: ${marcaNombre}
                    <button class="btn btn-warning btn-sm float-right ml-2" onclick="editPrenda(${prenda.PrendaID})">Editar</button>
                    <button class="btn btn-danger btn-sm float-right" onclick="deletePrenda(${prenda.PrendaID})">Eliminar</button>
                `;
                prendasList.appendChild(li);
            });
            clearPrendaForm();
        })
        .catch(error => console.error('Error fetching prendas:', error));
}

function savePrenda() {
    const id = document.getElementById('prenda-id').value;
    const nombre = document.getElementById('prenda-nombre').value;
    const talla = document.getElementById('prenda-talla').value;
    const precio = document.getElementById('prenda-precio').value;
    const stock = document.getElementById('prenda-stock').value;
    const marcaId = document.getElementById('prenda-marca-id').value;
    const data = { nombre, talla, precio, stock, marca_id: marcaId };

    let url = 'index.php/prendas';
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
        fetchPrendas();
    })
    .catch(error => console.error('Error saving prenda:', error));
}

function deletePrenda(id) {
    axios.delete(`index.php/prendas/${id}`)
        .then(response => {
            fetchPrendas(); 
        })
        .catch(error => console.error('Error deleting prenda:', error));
}

function editPrenda(id) {
    axios.get(`index.php/prendas/${id}`)
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
