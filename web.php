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
                    <h3 id="myModalLabel">Новая задача</h3>
                </div>
                <div class="modal-body">
                    <form action="">
                        <textarea name="" id="" cols="30" rows="10"></textarea>
                    </form>
                    <div id="results">dsdfhhh</div>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Закрыть</button>
                    <script>
                        function saveTask(){
                            var data = $('textarea').val();
                            alert(data);
                            $.ajax({
                                type: "POST",
                                data : { data: data },
                                cache: false,
                                url: "process.php",
                                success: function(data){
                                    alert(data);
                                    //$("#results").html(data);
                                }
                            });
                        }
                    </script>
                    <button class="btn btn-primary" onclick="javascript:saveTask()">Сохранить</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="span12">
            <table class="table">
                <tr>
                    <th>
                        #
                    </th>
                    <th>
                        Модуль
                    </th>
                    <th>
                        Дата создания
                    </th>
                    <th>
                        Статус
                    </th>
                </tr>
                <tr>
                    <td>
                        1
                    </td>
                    <td>
                        google
                    </td>
                    <td>
                        23.03.2014
                    </td>
                    <td>
                        <p class="text-info">выполняется</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        2
                    </td>
                    <td>
                        google
                    </td>
                    <td>
                        23.03.2014
                    </td>
                    <td>
                        <p class="text-success">сделано</p>
                    </td>
                </tr>
            </table>
        </div>
    </div>

</div>
<!-- Le javascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="./ball/js/jquery.js"></script>
<script src="./ball/js/bootstrap.js"></script>

</body>
</html>
