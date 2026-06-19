    fetch("data.php").then(response => response.json()).then(data => {
        console.log(typeof(data));
        console.log(data[0]["id"]);
    });