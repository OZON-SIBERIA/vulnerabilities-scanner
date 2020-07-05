document.addEventListener('DOMContentLoaded', () => {

    function result(data) {
        let results = "";
        for(let a = 0; a<data.length; a++) {
            if(data[a]['status'] === 'No Signs'){
                let emptymessage = "Уязвимости не обнаружены";
                results += "<tr>";
                results += "<td class=\"empty\">" + emptymessage + "</td>";
                results += "</tr>";
        }
            else{
                let id = a;
                let name = data[a]['status'];
                let startline = data[a]['startline'];
                let endline = data[a]['endline'];
                let rule = data[a]['rulenumber'];
                results += "<tr>";
                results += "<td class=\"id\">" + id + "</td>";
                results += "<td class=\"status\">" + name + "</td>";
                results += "<td class=\"startline\">" + startline + "</td>";
                results += "<td class=\"endline\">" + endline + "</td>";
                results += "<td class=\"rule\">" + rule + "</td>";
                results += "</tr>";
            }
        }
        document.getElementById("data").innerHTML = results;
    }


    const ajaxSend = (formData) => {
        fetch('/', { // файл-обработчик
            method: 'POST',
            headers: {
                'Content-Type': 'application/json', // отправляемые данные 
            },
            body: JSON.stringify(formData)
        })
            .then(response => {return response.json()})
            .then(data => {result(data)})
            .catch(error => console.error(error))
    };


    const forms = document.getElementsByTagName('form');
    for (let i = 0; i < forms.length; i++) {
        forms[i].addEventListener('submit', function (e) {
            e.preventDefault();

            let formData = new FormData(this);
            formData = Object.fromEntries(formData);

            ajaxSend(formData);
        });
    }

});