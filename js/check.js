function cleanTempFile() {
    var xhr = new XMLHttpRequest();

    xhr.open('GET', 'deleteExpiredOTP.php', true);
    xhr.send();

}


setInterval(cleanTempFile, 60000);