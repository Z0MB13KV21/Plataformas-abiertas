document.addEventListener('DOMContentLoaded', function() {
    fetchMarcasConVentas();
});

function fetchMarcasConVentas() {
    axios.get('index.php/marcas/conVentas')
        .then(response => {
            const marcasConVentas = response.data;
            const marcasConVentasList = document.getElementById('marcas-con-ventas-list');
            marcasConVentasList.innerHTML = '';
            marcasConVentas.forEach(marca => {
                const li = document.createElement('li');
                li.textContent = `ID: ${marca.MarcaID}, Nombre: ${marca.Nombre}`;
                marcasConVentasList.appendChild(li);
            });
        })
        .catch(error => console.error('Error fetching marcas con ventas:', error));
}
