document.addEventListener('DOMContentLoaded', function() {
    const sessionTimeout = 3000; // Convert seconds to milliseconds
    let lastActivityTime = Date.now(); // Convert PHP timestamp to JavaScript timestamp
    let delayTimer;
    setTimeout(function() {
        checkSessionStatus(); // Update session activity on server after delay
    }, 3000)
    
    setInterval(checkSessionStatus,30000);
    // Function to handle user activity
    function handleUserActivity() {
        lastActivityTime = Date.now(); // Update client-side last activity time
        clearTimeout(delayTimer); // Clear previous delay timer
        delayTimer = setTimeout(function() {
            updateSessionActivity(lastActivityTime); // Update session activity on server after delay
        }, 1000); 
        // resetActivityTimeout();
    }

    document.addEventListener('mousemove', handleUserActivity);
    document.addEventListener('keydown', handleUserActivity);

    

    // Function to update session activity via AJAX
    function updateSessionActivity(clientLastActivityTime) {
        console.log(clientLastActivityTime);
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'session_management.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send('action=update_activity&last_activity=' + clientLastActivityTime);
    }

    // Function to check session status via AJAX
    function  checkSessionStatus() {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'session_management.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                console.log(xhr.responseText);
                var response = JSON.parse(xhr.responseText);
                if (!response.valid) {
                    alert('Your session has expired. Please log in again.');
                    logoutUser(); // Perform logout action if session expired
                } else {
                    console.log('Session is active.');
                    // Optionally update last activity here if needed
                }
            }
        };
        xhr.onerror = function() {
            console.error('Error checking session status:', xhr.statusText);
        };
        xhr.send('action=check_session');
    }
});