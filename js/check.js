function cleanTempFile() {
    var xhr = new XMLHttpRequest();

    xhr.open('GET', 'deleteExpiredOTP.php', true);
    xhr.send();

}

cleanTempFile();
setInterval(cleanTempFile, 60000);