<?php

//include("dbConnection.php");

include('functions.php');

if (!isLoggedIn()) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
}
?>

<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HARamata</title>
    <link rel="stylesheet" type="text/css" href="css/custom.css">
    <link rel="icon" type="image/png" href="favicon-32x32.png" sizes="32x32" />
</head>

<body>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <div class="wrapper">
        <div class="wrapper-body">
            <?php include("includes/header.php"); ?>
            <form id="jsonFile" name="jsonFile" enctype="multipart/form-data" method="post">
                <fieldset>
                    <h1>Select HAR File</h1>
                    <input type='file' id='fileinput' accept=".har">
                    <input type='button' id='btnLoad' value='Load' onclick='loadFile();'>
                    <input type='button' id='btnDownload' value='Download' onclick='downloadFile();'>
                    <input type='button' id='btnSave' value='Save' onclick="saveFile();">
                </fieldset>
            </form>
            <div class="content-desc">
                <h1>HERE YOU CAN UPLOAD AND SAVE YOUR HAR FILE</h1>
                <p>Select any file with type har and upload it to the system to cut out any sensitive informations</p>
                <img src="images/image.svg" id="testing" />
            </div>
        </div>
    </div>



    <script type="text/javascript">
        function loadFile() {
            var input, file, fr;


            if (typeof window.FileReader !== 'function') {
                alert("The file API isn't supported on this browser yet.");
                return;
            }

            input = document.getElementById('fileinput');
            if (!input) {
                alert("Couldn't find the fileinput element.");
            } else if (!input.files) {
                alert("This browser doesn't seem to support the `files` property of file inputs.");
            } else if (!input.files[0]) {
                alert("Please select a file before clicking 'Load'");
            } else {
                file = input.files[0];
                fr = new FileReader();
                fr.onload = receivedText;
                fr.readAsText(file);

            }

            function receivedText(e) {
                const givenText = e.target.result;
                const harFile = JSON.parse(givenText);

                let entriesArray = harFile.log.entries;

                let safeHarFile = {
                    "log": {
                        "entries": []
                    }
                };

                entriesArray.forEach((entry) => {
                    let safeEntry = {
                        "serverIPAddress": entry["serverIPAddress"],
                        "startedDateTime": entry["startedDateTime"],
                        "timings": {
                            "wait": entry["timings"]["wait"],
                        },
                        "request": {
                            "method": entry["request"]["method"],
                            "url": entry["request"]["url"].match(/^(?:https?:\/\/)?(?:[^@\n]+@)?(?:www\.)?([^:\/\n\?\=]+)/im)[1], //use regex to keep only the base url
                            "headers": []
                        },
                        "response": {
                            "status": entry["response"]["status"],
                            "statusText": entry["response"]["statusText"],
                            "headers": []
                        },
                    }

                    let safeHeaderNames = ["content-type", "pragma", "age", "host", "expires", "cache-control", "last-modified"];


                    entry["request"]["headers"].forEach((header) => {
                        if (safeHeaderNames.includes(header["name"].toLowerCase())) {
                            let safeHeader = {
                                "name": header["name"], //in order to keep original header case
                                "value": header["value"]
                            }

                            safeEntry["request"]["headers"].push(safeHeader);
                        }
                    });

                    entry["response"]["headers"].forEach((header) => {
                        if (safeHeaderNames.includes(header["name"].toLowerCase())) {
                            let safeHeader = {
                                "name": header["name"], //in order to keep original header case
                                "value": header["value"]
                            }

                            safeEntry["response"]["headers"].push(safeHeader);
                        }
                    });

                    safeHarFile["log"]["entries"].push(safeEntry);
                });

                //console.log(safeHarFile);
                window.final = JSON.stringify(safeHarFile); // file to download
                console.log(final);
            }

        }

        function downloadFile() {
            var a = document.createElement("a");
            var file = new Blob([window.final], {
                type: 'json/plain'
            });
            a.href = URL.createObjectURL(file);
            a.download = 'parsed.har';
            a.click();
        }

        // function getUserIp() {

        //     fetch('http://ip-api.com/json/?fields=isp,query')
        //         .then(results => results.json())
        //         .then((myData) => {

        //             fetch("/registration/ipAndIsp.php", {
        //                 method: 'POST',
        //                 body: JSON.stringify(myData)
        //             })
        //                 .then(response => {
        //                     console.log(response);
        //                 });
        //         });

        // }

        function saveFile() {

            fetch('http://ip-api.com/json/?fields=isp,query')
                .then(results => results.json())
                .then((myData) => {

                    fetch("/registration/api_ipAndIsp.php", {
                            method: 'POST',
                            body: JSON.stringify(myData)
                        })
                        .then(response => {
                            console.log(response);
                        });
                });

            var safeHarObj = window.final;

            $.post("/registration/api_saveToDb.php", safeHarObj, function(response) {
                console.log(response);
            }, "json");




        }
    </script>

</body>

</html>