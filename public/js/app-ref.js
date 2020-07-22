document.addEventListener('DOMContentLoaded', () => {

    /*function result(data)
    {
        let scheme = "";
        document.getElementById("description-content").innerHTML = data[0]['description'];
        scheme += "<img id=\"scheme-img\" src="+ data[0]["scheme"] + ">";
        document.getElementById("reference-scheme").innerHTML = scheme;
    }*/

function ajaxRules (name) {
    fetch('/rules/info?name=' + name, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
        },
    })
        .then(response => {return response.json()})
        //.then(data => {result(data)})
}

    const buttons = document.getElementsByClassName('button-switch')

    for (let i = 0; i < buttons.length; i++)
    {
        console.log('ListenerAdded');
        buttons[i].addEventListener('click', function (e2) {

            let name = buttons[i].value;
            console.log(name);
            ajaxRules(name);
        });
    }
});