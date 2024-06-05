document.addEventListener("DOMContentLoaded", () => {
   const errorBox = document.getElementById("error")
   const form = document.getElementById('form')
    if(form !== null){
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            sendData();
        });

        function sendData() {
            const formData = new FormData(form);
            const requestOptions = {
                method: "POST",
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