<?php
session_start();
if (!isset($_SESSION['userId'])) {
    header("location:login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Socket</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="assets/javascript/jquery.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <style>
        hr {
            margin-top: 1rem;
            margin-bottom: 1rem;
            border: 0;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
        }

        .table-responsive {
            height: 400px;
            overflow: scroll;
        }

        thead tr:nth-child(1) th {
            background: white;
            position: sticky;
            top: 0;
            z-index: 10;
        }
    </style>
</head>

<body>

    <script>
        wsUri = 'ws://localhost:8585';
        websocket = new WebSocket(wsUri);
        websocket.onopen = function(e) {
            writeStatus("CONNECTED");

        };

        websocket.onclose = function(event) {
            var reason;

            // See https://www.rfc-editor.org/rfc/rfc6455#section-7.4.1
            if (event.code == 1000) {
                reason = "Normal closure, meaning that the purpose for which the connection was established has been fulfilled.";
            } else if (event.code == 1001) {
                reason = "An endpoint is \"going away\", such as a server going down or a browser having navigated away from a page.";
            } else if (event.code == 1002) {
                reason = "An endpoint is terminating the connection due to a protocol error";
            } else if (event.code == 1003) {
                reason = "An endpoint is terminating the connection because it has received a type of data it cannot accept (e.g., an endpoint that understands only text data MAY send this if it receives a binary message).";
            } else if (event.code == 1004) {
                reason = "Reserved. The specific meaning might be defined in the future.";
            } else if (event.code == 1005) {
                reason = "No status code was actually present.";
            } else if (event.code == 1006) {
                reason = "The connection was closed abnormally, e.g., without sending or receiving a Close control frame";
            } else if (event.code == 1007) {
                reason = "An endpoint is terminating the connection because it has received data within a message that was not consistent with the type of the message (e.g., non-UTF-8 [https://www.rfc-editor.org/rfc/rfc3629] data within a text message).";
            } else if (event.code == 1008) {
                reason = "An endpoint is terminating the connection because it has received a message that \"violates its policy\". This reason is given either if there is no other sutible reason, or if there is a need to hide specific details about the policy.";
            } else if (event.code == 1009) {
                reason = "An endpoint is terminating the connection because it has received a message that is too big for it to process.";
            } else if (event.code == 1010) { // Note that this status code is not used by the server, because it can fail the WebSocket handshake instead.
                reason = "An endpoint (client) is terminating the connection because it has expected the server to negotiate one or more extension, but the server didn't return them in the response message of the WebSocket handshake. <br /> Specifically, the extensions that are needed are: " + event.reason;
            } else if (event.code == 1011) {
                reason = "A server is terminating the connection because it encountered an unexpected condition that prevented it from fulfilling the request.";
            } else if (event.code == 1015) {
                reason = "The connection was closed due to a failure to perform a TLS handshake (e.g., the server certificate can't be verified).";
            } else {
                reason = "Unknown reason";
            }
            writeStatus(reason)
        }
        websocket.onmessage = function(e) {
            addTable("server", e.data);
        };

        websocket.onerror = function(e) {
            writeStatus(e.data);
        };

        function writeStatus(message) {
            $('#connection_status').html(message)
        }

        function sendMessage() {
            var message = $('#message_text').val();
            websocket.send(message);
            addTable("user", message)
        }

        function addTable(sender, data) {
            var receiver = ""
            if (sender == "server") {
                receiver = "user"
            } else {
                receiver = "server"
            }
            var table = $('#messages_tbody');
            var tr = '<tr>';
            tr += "<td>" + sender + "</td>"
            tr += "<td>" + receiver + "</td>"
            tr += "<td>" + data + "</td></tr>"
            table.append(tr)
        }
    </script>

    <header>
        <div class="collapse bg-dark" id="navbarHeader">
            <div class="container">
                <div class="row">
                    <div class="col-sm-8 col-md-7 py-4">
                        <h4 class="text-white">About</h4>
                        <p class="text-muted">Vulnerable WebSocket Application.</p>
                    </div>
                    <div class="col-sm-4 offset-md-1 py-4">
                        <h4 class="text-white">Contact</h4>
                        <ul class="list-unstyled">
                            <li><a href="https://www.linkedin.com/in/serhatcck/" target="_blank" class="text-white">Linkedin</a></li>
                            <li><a href="https://github.com/Serhatcck" target="_blank" class="text-white">Github</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="navbar navbar-dark bg-dark box-shadow">
            <div class="container d-flex justify-content-between">
                <a href="/vulnsocket" class="navbar-brand d-flex align-items-center">

                    <strong>WebSocket - CSWSH</strong>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </div>
    </header>
    <main role="main">

        <section class="jumbotron text-center">
            <div class="container">
                <h1 class="jumbotron-heading">Exploiting WebSocket Vulnerabilities</h1>
                <p class="lead text-muted">There are some websocket vulnerabilities you can test on this page.</p>
                Start Server: <pre>python3 socket_servers/socket_cswsh.py </pre>
            </div>
        </section>

        <div class="album py-5 bg-light">
            <div class="container">

                <div class="row">
                    <div class="col-md-6">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Command</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>profile</td>
                                    <td>Get Profile Information</td>
                                </tr>
                                <tr>
                                    <td>setPassword:{password}</td>
                                    <td>Sets the value between "{}" as password</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h5>Connection Status :</h5>
                        <span id="connection_status"></span>
                    </div>
                    <hr>

                    <div class="col-md-6">
                        <h5>Send Message</h5>
                    </div>
                    <div class="col-md-6">
                        <h5>All Messages</h5>
                    </div>
                    <div class="col-md-6">
                        <div class="col-md-12">
                            <textarea class="form-control" cols=30 rows=3 id="message_text"></textarea>
                            <a href="javascript:;" onclick="sendMessage()" class="btn btn-md btn-primary" style="float:right">send</a>
                        </div>
                    </div>
                    <div class="col-md-6 table-responsive">
                        <table class="table table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Sender</th>
                                    <th>Receiver</th>
                                    <th>Content</th>
                                </tr>
                            </thead>
                            <tbody id="messages_tbody">

                            </tbody>
                        </table>
                    </div>


                </div>
            </div>
        </div>

    </main>
</body>

</html>