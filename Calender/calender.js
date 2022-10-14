function innit(){
    indexcheck();
}

function indexcheck(){
    fetch('calender_index.php').then(function (response) {
    // The API call was successful!
    return response.json();
    }).then(function (html) {
        // This is the HTML from our response as a text string
        var as = JSON.stringify(html);
        alert(as);
    }).catch(function (err) {
        // There was an error
        console.warn('Something went wrong.', err);
    });
}