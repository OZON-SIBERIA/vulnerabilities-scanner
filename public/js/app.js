document.addEventListener('DOMContentLoaded', () => {

    function result(data) {
        let results = "";
        for (let a = 0; a < data.length; a++) {
            if (data[a]['status'] === 'No Signs') {
                let emptymessage = "Уязвимости не обнаружены";
                results += "<tr>";
                results += "<td class=\"empty\">" + emptymessage + "</td>";
                results += "</tr>";
            } else {

                let id = a;
                let name = data[a]['vulnerability'];
                let status = data[a]['status'];
                let startline = data[a]['startline'];
                let endline = data[a]['endline'];
                let rule = '';
                switch(data[a]['rulenumber'])
                {
                    case 1:
                        rule = 'XSS';
                        break;
                    case 2:
                        rule = 'HASH';
                        break;
                    case 3:
                        rule = 'REGEX';
                        break;
                    case 4:
                        rule = 'SQL';
                        break;
                }
                if (status === 'Prevented') {
                    results += "<tr class=\"table-success\">";
                } else if (status === 'Proved') {
                    results += "<tr class=\"table-danger\">";
                }
                results += "<th scope=\"row\" class=\"id\">" + id + "</th>";
                results += "<td class=\"vulnerability\">" + name + "</td>";
                results += "<td class=\"startline\">" + startline + "</td>";
                results += "<td class=\"endline\">" + endline + "</td>";
                results += "<td class=\"rule\"><a href='/rules/info?name=" + rule + "'target=\"_blank\">Описание</a></td>";
                results += "</tr>";
            }
        }
        document.getElementById("data").innerHTML = results;
    }

    const ajaxAnalysis = (formData) => {
        fetch('/', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(formData)
        })
            .then(response => {
                return response.json()
            })
            .then(data => {
                result(data)
            })
            .catch(error => alert('Ошибка в синтаксисе'))
    };

    /*function ajaxRules (name) {
        fetch('/rules', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(name)
        })
            .then(response => {return response.json()})
    }*/


   const forma = document.getElementById('forma');

    forma.addEventListener('submit', function (e1) {
        e1.preventDefault();
        let text = document.getElementById('code-field').value;
        let formData = new FormData(this);
        formData.append('code', text);
        formData = Object.fromEntries(formData);

        ajaxAnalysis(formData);
    });

    /*const button = document.getElementById('button-1');
    console.log(document.getElementById('list-content'));

    button.addEventListener('click', function (e3) {

        let name = 'Уязвимость реализации XSS атаки';

        ajaxRules(name);
    });*/

    /*const buttons = document.getElementsByTagName('button');
    console.log(document.getElementsByTagName('button'));

    for (let i = 0; i < buttons.length; i++)
    {
        console.log('ListenerAdded');
        buttons[i].addEventListener('click', function (e2) {
            let name = document.getElementById(this).value;

            ajaxRules(name);
        });
    }*/
});