function logoutUser() {
    var userId = document.getElementById("login_user_id").value;
    if (userId) {
        fetch('action.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                'user_id': userId,
                'action': 'leave'
            })
        })
            .then(response => response.text())
            .then(data => {
                console.log("Response received: " + data);
                let response;
                try {
                    response = JSON.parse(data);
                } catch (e) {
                    console.log("Failed to parse JSON response: " + e);
                    return;
                }

                if (response.status == 1) {
                    console.log("Logout successful, redirecting...");
                    location.href = "index.php";
                } else {
                    console.log("Logout failed");
                }
            })
            .catch(error => {
                console.error("Fetch Error: " + error);
                window.alert("Fetch Error: " + error);
            });
    } else {
        console.warn("User ID not found");
    }

}
