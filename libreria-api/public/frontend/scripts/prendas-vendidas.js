document.addEventListener('DOMContentLoaded', function() {
    fetchPrendasVendidas();
});

function fetchPrendasVendidas() {
    axios.get('../index.php/prendas/vendidas')
        .then(response => {
            const prendasVendidas = response.data;
            const prendasVendidasTable = document.getElementById('prendas-vendidas-table').getElementsByTagName('tbody')[0];
            prendasVendidasTable.innerHTML = '';
            prendasVendidas.forEach(prenda => {
                let row = prendasVendidasTable.insertRow();
                row.innerHTML = `
                    <td>${prenda.PrendaID}</td>
                    <td>${prenda.Nombre}</td>
                    <td>${prenda.cantidad_vendida}</td>
                    <td>${prenda.stock_restante}</td>
                `;
            });
        })
        .catch(error => console.error('Error fetching prendas vendidas:', error));
}

fetchPrendasVendidas();
