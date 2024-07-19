function fetchTop5Marcas() {
    axios.get('index.php/marcas/top5')
        .then(response => {
            const top5Marcas = response.data;
            const top5MarcasList = document.getElementById('top5-marcas-list');
            top5MarcasList.innerHTML = '';
            top5Marcas.forEach(marca => {
                const li = document.createElement('li');
                li.textContent = `ID: ${marca.MarcaID}, Marca: ${marca.Nombre}, Vendidos: ${marca.cantidad_vendida}`;
                top5MarcasList.appendChild(li);
            });
        })
        .catch(error => console.error('Error fetching top 5 marcas:', error));
}

fetchTop5Marcas();
