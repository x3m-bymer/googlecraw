<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Bootstrap, from Twitter</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="./ball/css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
        body {
            padding-top: 60px;
            padding-bottom: 40px;
        }
    </style>
    <link href="./ball/css/bootstrap-responsive.css" rel="stylesheet">

</head>
<body>

<div class="container">
    <div class="row">
        <div class="btn-group">
            <-- Button to trigger modal -->
            <a href="#myModal" role="button" class="btn" data-toggle="modal">Добавить задачу</a>

            <-- Modal -->
            <div class="modal hide fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel">Новая за1дача</h3>
                </div>
                <div class="modal-body">
                    <form action="">
                        <textarea name="" id="" cols="30" rows="10"></textarea>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Закрыть</button>
                    <button class="btn btn-primary" onclick="javascript:saveRequest()">Сохранить</button>

                </div>
                <div id="result" style="color: red; font-size: 12px"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="span12">
            <table class="table" id="myTable">
                <thead>
                <tr>
                    <th>
                        Удалить<br/><a href="#" onclick="javascript:clear_dir();">все</a><br/><a href="">выделенные</a>
                    </th>
                    <th>
                        Название файла
                    </th>
                    <th>
                        Дата создания
                    </th>
                    <th>
                        Статус
                    </th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>

</div>
<!-- Le javascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="./ball/js/jquery.js"></script>
<script src="./ball/js/bootstrap.js"></script>
<script>
    var connection = new WebSocket('ws://html5rocks.websocket.org/echo', ['soap', 'xmpp']);
    // When the connection is open, send some data to the server
    connection.onopen = function () {
        connection.send('Ping'); // Send the message 'Ping' to the server
    };

    // Log errors
    connection.onerror = function (error) {
        console.log('WebSocket Error ' + error);
    };

    // Log messages from the server
    connection.onmessage = function (e) {
        console.log('Server: ' + e.data);
    };
    $( document ).ready(function() {
        getListing(function(){
            //alert('END');
        });
    });

    $('#myModal').on('hidden', function () {
        $('#result').html('');
    })

    function clearTableRows(){
        $('#myTable tbody').find('tr').remove();
        //$("myTable").find("tr").remove();
    }
    function getListing(cb){ //получить листинг директории
        postSend({ cmd: "ls" }, function(data){
            if(data){
                var arr = data.split("\n");
                var count = 0;
                arr.forEach(function(name){
                    if(name){
//                        count++;
                        addTableItem(parse_filename(name));
                    }
                });
                cb();
            }
        });
    }

    function timeConverter(UNIX_timestamp){
        var a = new Date(UNIX_timestamp*1000);
        var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        var year = a.getFullYear();
        var month = months[a.getMonth()];
        var date = a.getDate();
        var hour = a.getHours();
        var min = a.getMinutes();
        var sec = a.getSeconds();
        var time = date+','+month+' '+year+' '+hour+':'+min+':'+sec ;
        return time;
    }

    function parse_filename(str){
        var w = str.split ('.');
        var fname = w[0];
        //alert(fname);
        var tmp = fname.split("_");
        var unix_timestamp = tmp[1];
        var formattedTime = timeConverter(unix_timestamp);
        var arr = [];
        arr.push('<input type="checkbox" value="">');
        arr.push('<a href="backend/new/'+str+'">'+str+'</a>');
        arr.push(formattedTime);
        arr.push(tmp[0]);
        return arr;
    }
    function postSend(data, cb){
        $.ajax({
            type: "POST",
            data : data,
            cache: false,
            url: "backend/process.php",
            success: function(data){
                cb(data);
            }
        });
    }
    function clear_dir(){
        postSend({ cmd: "clear_dir" }, function(data){
            alert(data);
        });
    }
    function addTableItem(data){
        var str = data.join('</td><td>');
        $('#myTable tbody').append('<tr><td>'+str+'</td></tr>');
    }
    function saveRequest(){
        var text = $('textarea').val();
        postSend({ cmd: "new_file", data: text }, function(data){
            if(text){
                clearTableRows();
                getListing(function(){
                    $('#myModal').modal('hide');
                });
            } else {
                $('#result').html('data empty');
            }
        });
    }
</script>
</body>
</html>
