function cleanTempFile() {
    var xhr = new XMLHttpRequest();
    console.log('performed');
    xhr.open('GET', 'deleteExpiredOTP.php', true);
    xhr.send();

}


setInterval(cleanTempFile, 500000);