//check the status every time and perform action on it
function checkStatus() {
    var userId = document.getElementById("login_user_id").value;
    if (userId) {
        fetch('action.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                'user_id': userId,
                'action': 'check_user_status'
            })
        })
            .then(response => response.text())
            .then(data => {
                let response;
                try {
                    response = JSON.parse(data.trim());
                } catch (e) {
                    console.log("Failed to parse JSON response: " + e);
                    return;
                }
                console.log("Response received: " + response[0].status);
                if (response[0].status == 'Inactive') {
                    window.location.reload();
                }
            })
            .catch(error => {
                console.error("Fetch Error: " + error);
                window.location.href = 'errorPage.php';
            });
    } else {
        console.warn("User ID not found");
    }
}
checkStatus();
setInterval(checkStatus, 5000);