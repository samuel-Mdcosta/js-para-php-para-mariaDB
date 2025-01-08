function enviar(){
    console.log("Enviando dados...");
    var nome = document.getElementById("nome").value;
    var idade = document.getElementById("idade").value;
    var serie = document.getElementById("serie").value;

    let dados = {
        nome: nome,
        idade: idade,
        serie: serie
    }

    fetch('http://localhost/teste/teste.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(dados),
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok ' + response.statusText);
        }
        return response.text(); // Change to text to inspect the raw response
    })
    .then(text => {
        try {
            const data = JSON.parse(text); // Try to parse the text as JSON
            console.log('Success:', data);
        } catch (error) {
            console.error('Error parsing JSON:', error, text); // Log the error and the raw response
        }
    })
    .catch((error) => {
        console.error('Fetch error:', error);
    });
}