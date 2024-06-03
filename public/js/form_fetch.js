document.addEventListener("DOMContentLoaded", () => {
   const errorBox = document.getElementById("error")
    if(document.getElementById('form') !== null){
        document.getElementById('form').addEventListener('submit', function(event) {
            event.preventDefault();
            sendData();
        });
        function sendData() {
            const formData = new FormData(document.getElementById('form'));
            const requestOptions = {
                method: 'POST',
                body: formData
            };
            fetch(window.location.href, requestOptions)
                .then(response => {
                    return response.json();
                })
                .then(data => {
                    if (data.redirect) {
                        window.location.href = data.redirect;
                    }
                    errorBox.textContent = data.error;
                })
                .catch(error => {
                    console.error('Помилка:', error);
                });
        }
    }


})