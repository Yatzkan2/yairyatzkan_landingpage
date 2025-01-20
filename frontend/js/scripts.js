document.getElementById('signup-form').addEventListener('submit', function(event) {
    event.preventDefault(); 
    const formData = new FormData(this);
    const queryString = new URLSearchParams(formData).toString();
    
    //CREATING REQUEST
    const xhr = new XMLHttpRequest();
    xhr.open('POST', `http://localhost:83/submit.php?${queryString}`, true);
    xhr.setRequestHeader('Accept', 'application/json');
    
    //HANDLE SUCCESSFULL RESPONSE
    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 300) {
            
            const response = JSON.parse(xhr.responseText);
            let msg ="";
            if (response.status == "error") {
                msg = "something went wrong";
            } else {
                msg = response.message;
            }
            alert(msg);
        } else {
            console.error('The request failed!');
        }
    };

    //HANDLE ERROR
    xhr.onerror = function() {
        console.error('Request error...');
    };

    //SENDING REQUEST TO "SUBMIT.PHP"
    xhr.send(formData);
});
