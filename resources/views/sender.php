<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<?php
    if(isset($_GET['message'])){
        echo '<h2 id="result" class="alert alert-success text-center">'.$_GET['message'].'</h2>';
    }
?>
<body onload="load()" class="wrapper bg-dark p-5" style="margin-top: 5%">
    <div class="container bg-white p-5" style="margin: auto; border-radius: 30px">
        <h1 class="text-center text-primary p-5">SENDER</h1>
        <hr>
        <form style="display: none" method="post" action="smtp/send">
            <input id="email" required type="email" name="target" placeholder="email">
            <input id="submit" type="submit" value="send">
        </form>
        <div class="form-group" style="margin: auto">
            <textarea class="rounded text-center mb-3" id="list" value="" required rows="10" placeholder="email1, email2, email3,...." style="overflow: auto; width: 100%" name="list"></textarea>
            <p class="text-center"><button class="btn btn-success m-2 text-white" style="width: 300px" type="submit" value="send" onclick="robotSender()">Send</button></p>
        </div>
        <form  class="d-flex justify-content-center" method="post" action="smtp/init">
            <input id="reset" class="btn btn-warning text-white" style="width: 300px" type="submit" value="reset">
        </form>
        <p class="text-center"><button id="toggle" class="btn btn-danger m-2 text-white" style="width: 300px" type="submit" value="pause" onclick="stop()">Pause</button></p>
        <br>
    </div>

</body>


<script>
    function stop() {
        localStorage.setItem('stop', '1');
        location.reload();
    }
    function resume() {
        localStorage.setItem('stop', '2');
        let intValue = parseInt(localStorage.getItem('counter')) + 1;
        localStorage.setItem('counter', '' +  intValue);
        location.reload();
    }
    function load() {
        if(localStorage.getItem('stop') !== 'null') {
            if(localStorage.getItem('stop') !== '1') {
                let i = document.getElementById('toggle');
                i.innerText = 'stop';
                i.setAttribute('onclick', 'stop()');
                i.classList.remove('btn-primary');
                i.classList.add('btn-danger');
            }
            else {
                let i = document.getElementById('toggle');
                i.innerText = 'resume';
                i.setAttribute('onclick', 'resume()');
                i.classList.remove('btn-danger');
                i.classList.add('btn-primary');
                return;
            }
        }
        if(localStorage.getItem('counter') !== 'NaN' && localStorage.getItem('counter') !== 'null' && localStorage.getItem('counter') !== '0') {
            console.log('working on email = ' + localStorage.getItem('email-' + localStorage.getItem('counter')));
            document.getElementById('email').value = localStorage.getItem('email-' + localStorage.getItem('counter'));
            location.reload();
            let intValue = parseInt(localStorage.getItem('counter')) - 1;
            localStorage.setItem('counter', '' +  intValue);
            document.getElementById('submit').click();
        }
    }

    function robotSender() {
        console.log('Robot Started...');
        localStorage.clear();
        let data = document.getElementById('list').value;
        let emails = data.split(',');
        console.log(emails);
        let i = 0;
        for(let e of emails) {
            localStorage.setItem('email-' + (++i), e);
        }
        localStorage.setItem('counter', '' + emails.length);
        location.reload();
    }
</script>
