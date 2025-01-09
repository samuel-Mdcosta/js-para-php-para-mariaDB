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
        return response.text(); 
    })
    .then(text => {
        try {
            const data = JSON.parse(text); //muda o texto para JSON
            console.log('Success:', data);
        } catch (error) {
            console.error('Error parsing JSON:', error, text); //imprime o erro e o texto em json
        }
    })
    .catch((error) => {
        console.error('Fetch error:', error);
    });
}