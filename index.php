<?php
/**
 * Created by PhpStorm.
 * User: johangriesel
 * Date: 13052016
 * Time: 08:48
 * @package    ${NAMESPACE}
 * @subpackage ${NAME}
 * @author     johangriesel <info@stratusolve.com>
 */
?>
<!DOCTYPE html>
<html>
<head>
    <title>Basic Task Manager</title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
</head>
<body>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>
            <div class="modal-body">
                <form action="update_task.php" method="post" id='taskModalForm'>
                    <div class="row">
                        <div class="form-group col-md-12" style="margin-bottom: 5px;;">
                            <input id="InputTaskName" name="InputTaskName" type="text" placeholder="Task Name" class="form-control" required/>
                        </div>
                        <div class="form-group col-md-12">
                            <textarea id="InputTaskDescription" name="InputTaskDescription" placeholder="Description" class="form-control" /></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button id="deleteTask" type="button" class="btn btn-danger">Delete Task</button>
                <button id="saveTask" type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>


<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">

        </div>
        <div class="col-md-6">
            <h2 class="page-header">Task List</h2>
            <!-- Button trigger modal -->
            <button id="newTask" type="button" class="btn btn-primary btn-lg" style="width:100%;margin-bottom: 5px;" data-toggle="modal" data-target="#myModal">
                Add Task
            </button>

            <div id="TaskList" class="list-group">
                <!-- Assignment: These are simply dummy tasks to show how it should look and work. You need to dynamically update this list with actual tasks -->
            </div>
        </div>
        <div class="col-md-3">

        </div>
    </div>
</div>
</body>
<script type="text/javascript" src="assets/js/jquery-1.12.3.min.js"></script>
<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="assets/js/jquery.validate.min.js"></script>
<script type="text/javascript">

$(document).ready(function(){

    var currentTaskId = -1;
    $('#myModal').on('show.bs.modal', function (event) {
        var triggerElement = $(event.relatedTarget); // Element that triggered the modal
        var modal = $(this);
        if (triggerElement.attr("id") == 'newTask') {
            modal.find('.modal-title').text('New Task');

            $('#InputTaskName').val('');
            $('#InputTaskDescription').val('');

            $('#deleteTask').hide();
            currentTaskId = -1;
        } else {
            modal.find('.modal-title').text('Task details');

            $('#InputTaskName').val(triggerElement.children('h4').text());
            $('#InputTaskDescription').val(triggerElement.children('p').text());

            $('#deleteTask').show();
            currentTaskId = triggerElement.attr("id");
            console.log('Task ID: '+triggerElement.attr("id"));
        }
    });


    $('#saveTask').click(function() {

        var data =  {
            'action': 'save',  
            'currentTaskId': currentTaskId, 
            'taskName': $('#InputTaskName').val(), 
            'taskDescription': $('#InputTaskDescription').val() 
        };

        var form = $("#taskModalForm");

        if (form.valid()) 
        {
            $.post("update_task.php", data, function( data ) {});
            alert('Save... Id:'+currentTaskId);
            $('#myModal').modal('hide');
            updateTaskList();
        }

    });


    $('#deleteTask').click(function() {
        //Assignment: Implement this functionality
        var data =  {
            'action': 'delete',
            'currentTaskId': currentTaskId, 
        };

        $.post("update_task.php", data, function( data ) {});

        alert('Delete... Id:'+currentTaskId);
        $('#myModal').modal('hide');
        updateTaskList();
    });

    function updateTaskList() {
        
        $.post("list_tasks.php", function( data ) {
            $( "#TaskList" ).html( data );
        });
    }
    updateTaskList();

    $('#taskModalForm').validate({
        rules: {
            InputTaskName: {
                minlength: 3,
                maxlength: 50,
                required: true
            }
        },
        highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error');
        },
        errorElement: 'span',
        errorClass: 'help-block',
        errorPlacement: function(error, element) {
            if(element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }
    });


    });
</script>
</html>