window.addEventListener("DOMContentLoaded", init);

function init() {
    let sendButtons = document.querySelectorAll('.send-button');
    //let resetButton = document.querySelector('#reset');

    sendButtons.forEach(function(button) {
        button.addEventListener('click', sendData);
    });

    function sendData() {
        const trainerRating = this.parentElement.querySelector('.trainerRating');
        const trainerComment = this.parentElement.querySelector('.trainerComment');
        const trainer = this.parentElement.querySelector('.trainer');
        const user = this.parentElement.querySelector('.user');

        let isValid = true;

        if (isValid) {
            let request = new XMLHttpRequest();
            let url = "insertRating.php";
            const result = this.parentElement.querySelector('.resultGif');
            result.innerHTML = '<img src="images/ajax_loader.gif" alt="loading">';

            request.open("POST", url, true);
            request.setRequestHeader("Content-Type", "application/json");
            request.onreadystatechange = function () {
                if (request.readyState === 4 && request.status === 200) {
                    const inputs = document.querySelectorAll('.formField input, .formField textarea');
                    let jsonData = JSON.parse(request.response);

                    // inputs.forEach((element) => {
                    //     element.value = '';
                    // });

                    result.innerHTML = jsonData.message;
                    setTimeout(function () {
                        result.innerHTML = "";
                    }, 2000);
                }
            };

            let data = JSON.stringify({
                "score": trainerRating.value,
                "comment": trainerComment.value,
                "user_id": user.value,
                "trainer_id": trainer.value
            });
            request.send(data);
        }
    }
}
