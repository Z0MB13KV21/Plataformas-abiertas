document.addEventListener('DOMContentLoaded', function() {
    fetchTop5Marcas();
});

function fetchTop5Marcas() {
    axios.get('../index.php/marcas/top5')
        .then(response => {
            const top5Marcas = response.data;
            const top5MarcasTable = document.getElementById('top5-marcas-table').getElementsByTagName('tbody')[0];
            top5MarcasTable.innerHTML = '';
            top5Marcas.forEach(marca => {
                let row = top5MarcasTable.insertRow();
                row.innerHTML = `
                    <td>${marca.MarcaID}</td>
                    <td>${marca.Nombre}</td>
                    <td>${marca.cantidad_vendida}</td>
                `;
            });
        })
        .catch(error => console.error('Error fetching top 5 marcas:', error));
}

fetchTop5Marcas();
