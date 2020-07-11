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
                let name = data[a]['vulnerability'];
                let status = data[a]['status'];
                let startline = data[a]['startline'];
                let endline = data[a]['endline'];
                let rule = data[a]['rulenumber'];
                if(status === 'Prevented')
                {
                    results += "<tr class=\"table-success\">";
                }
                else if(status === 'Proved')
                    {
                        results += "<tr class=\"table-danger\">";
                    }
                results += "<th scope=\"row\" class=\"id\">" + id + "</th>";
                results += "<td class=\"vulnerability\">" + name + "</td>";
                results += "<td class=\"startline\">" + startline + "</td>";
                results += "<td class=\"endline\">" + endline + "</td>";
                results += "<td class=\"rule\">" + rule + "</td>";
                results += "</tr>";
            }
        }
        document.getElementById("data").innerHTML = results;
    }

    const ajaxSend = (formData) => {
        fetch('/', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(formData)
        })
            .then(response => {return response.json()})
            .then(data => {result(data)})
            .catch(error => alert('Ошибка в синтаксисе'))
    };

    const forma = document.getElementById('forma');

    forma.addEventListener('submit', function (e) {
        e.preventDefault();
        let text = document.getElementById('code-field').value;
        let formData = new FormData(this);
        formData.append("code", text);
        formData = Object.fromEntries(formData);

        ajaxSend(formData);
    });
});