function ajaxR() {
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            let array = JSON.parse(this.response);
            console.log(array);

        }
    }
    xhr.open("GET", "db.php", true);
    xhr.setRequestHeader("Content", "application/json");
    xhr.send();
}