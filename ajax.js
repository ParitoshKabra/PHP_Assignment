function ajaxR() {
    let xhr = new XMLHttpRequest();
    let usersTable = document.getElementById('users');
    xhr.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            let obj = JSON.parse(this.response);
            let array = obj['testdata'];
            array.forEach(element => {
                console.log(element);
                let node = document.createElement('tr');
                let childNode1 = document.createElement('td');
                let childNode2 = document.createElement('td');
                let textnode1 = element['name'];
                let textnode2 = element['email'];
                childNode1.append(textnode1);
                childNode2.append(textnode2);
                node.appendChild(childNode1);
                node.appendChild(childNode2);
                console.log(childNode1);
                console.log(childNode2);
                usersTable.appendChild(node);
            });
        }
    }
    xhr.open("GET", "db.php", true);
    xhr.setRequestHeader("Content", "application/json");
    xhr.send();
}
ajaxR();