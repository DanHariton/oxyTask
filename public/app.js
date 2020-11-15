let form = document.getElementById('user-add-form');
let consoleResponse = document.getElementById('console-return');

form.onsubmit = function (event) {
    event.preventDefault();
    axios({
        method: 'PUT',
        url: Routing.generate('user_rest_create'),
        data: {
            name: document.getElementById('user-name-form').value,
            password: document.getElementById('user-password-form').value,
            email: document.getElementById('user-email-form').value,
            role: document.getElementById('user-role-form').value
        }
    })
        .then(function (response) {
            consoleResponse.value = consoleResponse.value + JSON.stringify(response.data) + '\n';
        })
        .catch(function (error) {
            consoleResponse.value = consoleResponse.value + JSON.stringify(error.response.data) + '\n';
        });
}