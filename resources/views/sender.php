<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<style>
    * {
        font-family: cursive;
    }
</style>
<body onload="load()" class="wrapper" style="margin:auto; background-image: url('bg.jpg')">
    <!-- APP ROOT -->
    <div class="container-fluid" id="application" style="background-color: rgba(255, 255, 255, 0.1)">
        <!-- HEADER -->
        <div id="header" class="container p-5 d-flex">
            <a href="javascript:void(0)" onclick="location.reload()" id="refresh" class="navbar-brand rounded-circle p-3" style="background-color: rgba(0, 0, 0, 0.9)"><img class="icon" width="30" height="30" src="refresh.png"></a>
            <nav class="navbar navbar-expand-lg navbar-dark" style="border-bottom: 2px solid darkseagreen; background-color: rgba(0, 0, 0, 0.9); width: fit-content; display: block; margin-left: auto; border-radius: 30px">
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <a onclick="show('send')" id="nav-send" class="nav-item nav-link active" href="javascript:void(0)">Send<span class="sr-only">(current)</span></a>
                        <a onclick="show('config')" id="nav-config" class="nav-item nav-link" href="javascript:void(0)">Config</a>
                        <a onclick="show('reports')" id="nav-reports" class="nav-item nav-link" href="javascript:void(0)">Reports</a>
                    </div>
                </div>
            </nav>
        </div>
        <!-- CONTENT -->
        <div id="content" class="container bg-white p-5" style="margin: auto; border-radius: 30px">
            <?php if(isset($_GET['code'])) { ?>
                <h2 style="display: none" id="result" class="alert alert-success text-center"><?=$_GET['code']?></h2>
            <?php } ?>
            <?php if(isset($_GET['message'])) { ?>
                <h2 class="alert alert-success text-center"><?=$_GET['message']?></h2>
            <?php } ?>
            <div id="send" class="container">
                <div class="d-flex justify-content-center">
                    <i class="material-icons text-muted" style="font-size: 80px">contact_mail</i>
                    <h1 class="text-primary p-5">SENDER</h1>
                </div>
                <div style="width: 100%; height: 400px; overflow: auto">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">Sender</th>
                            <th scope="col">Sender Email</th>
                            <th scope="col">Queue</th>
                            <th scope="col">Target Sends</th>
                        </tr>
                        </thead>
                        <tbody id="gen"></tbody>
                    </table>
                </div>
                <hr>
                <form style="display: none" method="post" action="smtp/send">
                    <input id="email" required type="email" name="target" placeholder="email">
                    <input id="submit" type="submit" value="send">
                </form>
                <div class="form-group" style="margin: auto">
                    <label>Target emails : </label>
                    <textarea class="form-control rounded text-center mb-3" id="list" value="" required rows="10" placeholder="email1, email2, email3,...." style="overflow: auto; width: 100%" name="list"></textarea>
                    <p class="text-center"><button class="btn btn-success m-2 text-white" style="width: 300px" type="submit" value="send" onclick="robotSender()">Send</button></p>
                </div>
                <p class="text-center"><button class="btn btn-primary m-2 text-white" style="width: 300px" type="submit" value="send" onclick="testServer()">Test Server</button></p>
            </div>
            <div id="config" class="container">
                <div class="d-flex justify-content-center">
                    <i class="material-icons text-muted" style="font-size: 80px">settings</i>
                    <h1 class="text-primary p-5">CONFIG</h1>
                </div>
                <div class="form-group" style="margin: auto">
                    <form onsubmit="sessionStorage.setItem('delivery', document.getElementById('sd').value)" method="post" action="smtp/config">
                        <div id="sender-delivery">
                            <h1><i class="material-icons" style="font-size: 50px; color: red">send</i> Senders</h1>
                            <hr>
                            <label>Start Sender :</label>
                            <select id="select" name="ss" class="form-control rounded text-center" style="text-align-last:center;">
                                <?php
                                    $length = (integer)$_SESSION['sender_length'];
                                    for ($i = 0; $i<$length; $i++) {
                                        if($i === $_SESSION['sender']) {
                                ?>
                                        <option selected value="<?=$i?>"><?=$i?></option>
                                        <?php } else { ?>
                                        <option value="<?=$i?>"><?=$i?></option>
                                <?php } }?>
                            </select>
                            <label>Rotation Per Mail :</label>
                            <input id="rv" value="<?=isset($_SESSION['rotation_value']) ? $_SESSION['rotation_value'] : ''?>" name="rv" class="form-control rounded text-center" required placeholder="Rotation per mail: example:5" style="width: 100%"><br>
                            <label>Sender emails :</label>
                            <textarea id="sd" name="senders" class="form-control rounded text-center mb-3" required rows="10" placeholder="Mail Senders: exmaple:email1:pass1|email2:pass2|..." style="overflow: auto; width: 100%"><?=isset($_SESSION['sender-delivery']) ? $_SESSION['sender-delivery'] : ''?></textarea>
                        </div>
                        <br>
                        <div id="compose">
                            <h1><i class="material-icons" style="font-size: 50px; color: red">send</i> Compose</h1>
                            <hr>
                            <label>From :</label>
                            <input value="<?=isset($_SESSION['from']) ? $_SESSION['from'] : ''?>" name="from" class="form-control rounded text-center" required placeholder="Mail From: example:HMZ" style="width: 100%"><br>
                            <label>Subject :</label>
                            <input value="<?=isset($_SESSION['subject']) ? $_SESSION['subject'] : ''?>" name="subject" class="form-control rounded text-center" required placeholder="Mail Subject: example:Test Subject" style="width: 100%"><br>
                            <label>Body :</label>
                            <textarea name="body" class="form-control rounded text-center mb-3" id="list" value="" required rows="10" placeholder="Mail Body: exmaple:<body><div>....</body>" style="overflow: auto; width: 100%"><?=isset($_SESSION['body']) ? $_SESSION['body'] : ''?></textarea>
                        </div>
                        <p class="text-center"><input class="btn text-white" style="width: 300px; background-color: deepskyblue" type="submit" value="Save"></p>
                    </form>
                </div>
            </div>
            <div id="reports" class="container">
                <div class="d-flex justify-content-center">
                    <i class="material-icons text-muted" style="font-size: 80px">analytics</i>
                    <h1 class="text-primary p-5">REPORTS</h1>
                </div>
                <label>Plan :</label>
                <hr>
                <div class="d-flex justify-content-center">
                    <div class="d-flex justify-content-center">
                        <p class="text-center">DONE</p>
                        <h1 id="CD" class="text-center text-danger" style="font-size: 150px">0</h1>
                    </div>
                    <div class="d-flex justify-content-center">
                        <p class="text-center">SENDS</p>
                        <h1 id="FC" class="text-center text-primary" style="font-size: 150px">0</h1>
                    </div>
                    <div class="d-flex justify-content-center">
                        <p class="text-center">SENDER</p>
                        <h1 id="S" class="text-center text-success" style="font-size: 150px">0</h1>
                    </div>
                </div>
            </div>
            <form onsubmit="localStorage.clear(); sessionStorage.removeItem('stats'); sessionStorage.removeItem('list')" class="d-flex justify-content-center" method="post" action="smtp/init">
                <input id="reset" class="btn btn-warning text-white" style="width: 300px" type="submit" value="reset">
            </form>
            <div id="show-in-reports">
                <table class="table table-striped table-dark">
                    <thead>
                    <tr>
                        <th scope="col">From</th>
                        <th scope="col">Subject</th>
                        <th scope="col">Sender</th>
                        <th scope="col">Target</th>
                        <th scope="col">Time</th>
                        <th scope="col">Status</th>
                    </tr>
                    </thead>
                    <tbody id="stats">
                    </tbody>
                </table>
            </div>

        </div>
        <!-- FOOTER -->
        <div id="footer" class="container p-4">
            <footer class="page-footer font-small blue p-1">
                <!-- Copyright -->
                <div class="footer-copyright text-center text-white py-3" style="background-color: rgba(0, 0, 0, 0.5); border-radius: 30px">© 2020 Copyright:
                    <a href="mailto:alaouiismaili28@gmail.com" style="color: skyblue">@HMZ</a>
                </div>
                <!-- Copyright -->
            </footer>
        </div>
    </div>
</body>

<!--JAVASCRIPT CODE-->
<script>
    function testServer() {
        document.getElementById('email').value = 'alaouiismaili28@gmail.com';
        document.getElementById('submit').click();
    }

    /**
     * View toggling
     * @param view
     * @param reload
     */
    function show(view, reload=true) {
        for(let v of ['send', 'config', 'reports']) {
            document.getElementById(v).style.display = 'none';
            document.getElementById('nav-' + v).classList.remove('active');
            document.getElementById('show-in-reports').style.display = 'none';
        }
        if(view === 'reports') document.getElementById('show-in-reports').style.display = 'block';
        document.getElementById(view).style.display = 'block';
        document.getElementById('nav-' + view).classList.add('active');
        sessionStorage.setItem('view', view);
    }

    /**
     * Main Loader
     */
    function load() {
        // Load view
        if(sessionStorage.getItem('view') !== null) {
            show(sessionStorage.getItem('view'));
        }
        else {
            show('send');
        }
        if(sessionStorage.getItem('emails') !== null) {
            document.getElementById('list').innerText = sessionStorage.getItem('emails');
        }
        if(sessionStorage.getItem('delivery') !== null) {
            document.getElementById('sd').innerText = sessionStorage.getItem('delivery');
            let g = document.getElementById('gen');
            let select = document.getElementById('select');
            let rv = document.getElementById('rv').value;
            let chosen = select.options[select.selectedIndex].value;
            let data = sessionStorage.getItem('delivery').split('|');
            let i = 0;
            for(let d of data) {
                let queue_status = (i === parseInt(chosen)) ? 'Ready' : 'In Queue';
                let style = (i === parseInt(chosen)) ? 'primary' : 'muted';
                let target = parseInt(rv);
                let email = d.split(':')[0];
                g.innerHTML +=
                    '<tr>\n' +
                        '<td class="text-' + style + '">' + i++ + '</td>\n' +
                        '<td class="text-' + style + '">' + email + '</th>\n' +
                        '<td class="text-' + style + '">' + queue_status + '</th>\n' +
                        '<td>' + target + '</th>\n' +
                    '</tr>'
            }
        }
        // Load Stats
        try {
            if(document.getElementById('result').innerText.includes('-')) {
                document.getElementById('S').innerText = document.getElementById('result').innerText.split('-')[2];
            }
            if(sessionStorage.getItem('stats') === null) {
                if(document.getElementById('result').innerText.includes('-')) {
                    sessionStorage.setItem('stats', document.getElementById('result').innerText);
                }
            }
            else {
                if(document.getElementById('result').innerText.includes('-')) {
                    if(!sessionStorage.getItem('stats').includes(document.getElementById('result').innerText)) {
                        sessionStorage.setItem('stats', sessionStorage.getItem('stats') + ',' + document.getElementById('result').innerText);
                    }
                    let table = document.getElementById('stats');
                    let list = sessionStorage.getItem('stats').split(',');
                    document.getElementById('FC').innerText = '' + list.length;
                    for(let l of list) {
                        let data = l.split('-');
                        table.innerHTML +=
                            '<tr>\n' +
                            '<th scope="row">' + data[0] + '</th>\n' +
                            '<td>' + data[1] + '</td>\n' +
                            '<td>' + data[2] + '</td>\n' +
                            '<td>' + data[3] + '</td>\n' +
                            '<td>' + data[4] + '</td>\n' +
                            '<td class="text-success">SUCCESS</td>\n' +
                            '</tr>';
                    }
                }
            }
        } catch (e) {}
        // Send Campaign
        if(localStorage.getItem('counter') !== 'NaN' && localStorage.getItem('counter') !== null && localStorage.getItem('counter') !== '0') {
            document.getElementById('CD').innerText = localStorage.getItem('counter');
            console.log('working on email = ' + localStorage.getItem('email-' + localStorage.getItem('counter')));
            document.getElementById('email').value = localStorage.getItem('email-' + localStorage.getItem('counter'));
            location.reload();
            let intValue = parseInt(localStorage.getItem('counter')) - 1;
            localStorage.setItem('counter', '' +  intValue);
            document.getElementById('submit').click();
            try {
                localStorage.removeItem('email-' + intValue + 2);
            } catch (e) {}
        }
    }

    /**
     * Start send campaign
     */
    function robotSender() {
        console.log('Robot Started...');
        localStorage.clear();
        let data = document.getElementById('list').value;
        sessionStorage.setItem('emails', data);
        let emails = data.split(',');
        let i = 0;
        for(let e of emails) {
            localStorage.setItem('email-' + (++i), e);
        }
        localStorage.setItem('counter', '' + emails.length);
        sessionStorage.setItem('view', 'reports');
        location.reload();
    }

    function getTime() {
        let today = new Date();
        let time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
        return time;
    }
</script>
