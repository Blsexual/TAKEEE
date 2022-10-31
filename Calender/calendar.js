function innit(){
    indexcheck();
}

function indexcheck(){
    fetch('calendar_index.php?uID=4&token=test&action=showEvent').then(function (response) {
    // The API call was successful!
    return response.json();
    console.log()
    }).then(function (html) {
        // This is the HTML from our response as a text string
        var as = JSON.stringify(html);
        alert(as);
        appendData(as);
    }).catch(function (err) {
        // There was an error
        console.warn('Something went wrong.', err);
    });
}

function appendData(data) {
    var mainContainer = document.getElementById("myData");
    for (var i = 0; i < data.length; i++) {
        var div = document.createElement("div");
        div.innerHTML = 'Name: ' + data[i].Version + ' ' + data[i].description;
        mainContainer.appendChild(div);
    }
}

    // function createEvent(){
    //     uID = document.getElementById("uID").value;
    //     title = document.getElementById("title").value;
    //     description = document.getElementById("description").value;
    //     startDate = document.getElementById("startDate").value;
    //     endDate = document.getElementById("endDate").value;
    //     fetch('calendar_index.php?uID='+uID+'&token=test&action=createEvent&title='+title+'&description='+description+'&startDate='+startDate+'&endDate='+endDate).then(function (response){
    //     // The API call was successful!
    //     return response.json();
    //     console.log()
    //     }).then(function (html) {
    //         // This is the HTML from our response as a text string
    //         var as = JSON.stringify(html);
    //         alert(as);
    //     }).catch(function (err) {
    //         // There was an error
    //         console.warn('Something went wrong.', err);
    //     });
    // }

function createEvent(){
    uID = document.getElementById("uID").value;
    title = document.getElementById("title").value;
    description = document.getElementById("description").value;
    startDate = document.getElementById("startDate").value;
    endDate = document.getElementById("endDate").value;
    fetch('calendar_index.php?uID='+uID+'&token=test&action=createEvent&title='+title+'&description='+description+'&startDate='+startDate+'&endDate='+endDate).then(function (response){
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


function deleteEvent(){
    uID = document.getElementById("uID").value;
    eventID = document.getElementById("eventID").value;
    fetch('calendar_index.php?deleteuID='+uID+'&eventID='+eventID).then(function (response){
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
