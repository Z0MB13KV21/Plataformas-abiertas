function fetchPrendasVendidas() {
    axios.get('index.php/prendas/vendidas')
        .then(response => {
            const prendasVendidas = response.data;
            const prendasVendidasList = document.getElementById('prendas-vendidas-list');
            prendasVendidasList.innerHTML = '';
            prendasVendidas.forEach(prenda => {
                const li = document.createElement('li');
                li.textContent = `ID: ${prenda.PrendaID}, Nombre: ${prenda.Nombre}, Vendidos: ${prenda.cantidad_vendida}, Disponible: ${prenda.stock_restante}`;
                prendasVendidasList.appendChild(li);
            });
        })
        .catch(error => console.error('Error fetching prendas vendidas:', error));
}

fetchPrendasVendidas();
