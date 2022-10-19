function innit(){
    indexcheck();
}

function indexcheck(){
    fetch('calender_index.php').then(function (response) {
    // The API call was successful!
    return response.json();
    console.log()
    }).then(function (html) {
        // This is the HTML from our response as a text string
        var as = JSON.stringify(html);
        alert(as);
    }).catch(function (err) {
        // There was an error
        console.warn('Something went wrong.', err);
    });
}

function createEvent(){
    uID = document.getElementById("uID").value;
    title = document.getElementById("title").value;
    description = document.getElementById("description").value;
    startDate = document.getElementById("startDate").value;
    endDate = document.getElementById("endDate").value;
    fetch('calender_index.php?uID=1&createEvent=1&title='+title+'&description='+description+'&startDate='+startDate+'&endDate='+endDate);
    location.reload();
}

function deleteEvent(){
    uID = document.getElementById("uID").value;
    eventID = document.getElementById("eventID").value;
    fetch('calender_index.php?deleteuID='+uID+'&eventID='+eventID);
    location.reload();
}
