function onLoader(get) {

    switch (get) {
        case "history":

            setHistory();
            setInterval(function() {
                setHistory();
            }, 4000);

            break;
        case "home":
            Player();

            break;

        default:

            break;
    }

}

function Player(func) {
    let xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        if (xhttp.readyState == XMLHttpRequest.DONE) {
            const info = JSON.parse(xhttp.responseText);

            if (func == 'fa-solid fa-play') {
                let stream = new Audio(info.StationStreamURL);
                stream.play();

            }

        }
    };
    xhttp.open('GET', 'index.php?a=daemon&q=info', true);
    xhttp.send();

}



function setHistory() {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        if (xhttp.readyState == XMLHttpRequest.DONE) {
            const json = JSON.parse(xhttp.responseText);
            document.title = json[0].SongName + " - " + json[0].SongArtist;

            let jsonlength = json.length;
            for (let index = 0; index < jsonlength; index++) {
                const element = json[index];


                let date = new Date(element.SongPlayed * 1000);

                let row = document.getElementById("row_" + index);

                row.classList.remove("invisible");
                const img = document.getElementById("img_" + index);

                img.src = element.SongImage;
                img.alt = element.SongName + " - " + element.SongArtist;
                document.getElementById("name_" + index).innerHTML = "<b>" + element.SongName + "</b>";
                document.getElementById("artist_" + index).innerHTML = element.SongArtist;
                document.getElementById("time_" + index).innerHTML = date.getHours().toString().padStart(2, '0') + ":" + date.getMinutes().toString().padStart(2, '0');


            }
        }
    }
    xhttp.open("GET", "index.php?a=daemon&q=history");
    xhttp.send();
}


function playnow() {
    Player();
    // let button = document.getElementById('playpause');
    // button.innerHTML = '<i class="fa-solid fa-pause fa-3x"></i>';



}