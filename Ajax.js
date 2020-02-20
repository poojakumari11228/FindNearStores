document.getElementById("zip-submit").onclick = function () {


    //get codde from html input field
    var code = document.getElementById("zip-code").value;
    //Ajax
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            //display response
            document.getElementById("container").innerHTML = this.responseText;
        }
    };

    xhttp.open("GET", "FindStores.php?code="+code, true);
    xhttp.send();

    return false;
};