document.addEventListener('DOMContentLoaded', function() {
    fetchMarcasConVentas();
});

function fetchMarcasConVentas() {
    axios.get('../index.php/marcas/conVentas')
        .then(response => {
            const marcasConVentas = response.data;
            const marcasConVentasTable = document.getElementById('marcas-con-ventas-table').getElementsByTagName('tbody')[0];
            marcasConVentasTable.innerHTML = '';
            marcasConVentas.forEach(marca => {
                let row = marcasConVentasTable.insertRow();
                row.innerHTML = `
                    <td>${marca.MarcaID}</td>
                    <td>${marca.Nombre}</td>
                `;
            });
        })
        .catch(error => console.error('Error fetching marcas con ventas:', error));
}
