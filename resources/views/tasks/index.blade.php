<!-- Display Tasks -->



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <title>Task Management</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .gradient-custom-2 {
            background: #7e40f6;
            overflow: scroll;
            background: -webkit-linear-gradient(to right,
                    rgba(126, 64, 246, 1),
                    rgba(80, 139, 252, 1));

            background: linear-gradient(to right,
                    rgba(126, 64, 246, 1),
                    rgba(80, 139, 252, 1));
        }

        .mask-custom {
            background: rgba(24, 24, 16, 0.2);
            border-radius: 2em;
            backdrop-filter: blur(25px);
            border: 2px solid rgba(255, 255, 255, 0.05);
            background-clip: padding-box;
            box-shadow: 10px 10px 10px rgba(46, 54, 68, 0.03);
        }
    </style>
</head>

<body>
    <div class="container mt-5">
       
        <section class="vh-100 gradient-custom-2">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-md-12 col-xl-10">

                        <div class="card mask-custom">
                            <div class="card-body p-4 text-white">
                                <h1 class="text-center">Task Management</h1>

                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#addTaskModal">
                                    Add Task
                                </button>
                                <div class="text-center pt-3 pb-2">
                                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-todo-list/check1.webp"
                                        alt="Check" width="60">
                                    <h2 class="my-4 text-danger">Task List</h2>
                                </div>

                                <table class="table text-white mb-0">
                                    <thead>
                                        <tr>
                                            <th scope="col">Sr.#</th>
                                            <th scope="col">Title</th>
                                            <th scope="col">Description</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tasks as $task)
                                            <tr class="fw-normal">
                                                <td class="align-middle">
                                                    <h6 class="mb-0"><span
                                                            class="badge bg-{{ $task->ID }}">{{ $task->id }}</span>
                                                    </h6>
                                                </td>
                                                <td class="align-middle">
                                                    <h6 class="mb-0"><span
                                                            class="badge bg-{{ $task->title }}">{{ $task->title }}</span>
                                                    </h6>
                                                </td>
                                                <td class="align-middle">
                                                    <h6 class="mb-0"><span
                                                            class="badge bg-{{ $task->description }}">{{ $task->description }}</span>
                                                    </h6>
                                                </td>
                                                <td class="align-middle">
                                                    @if ($task->completed === 0)
                                                        <button class="btn btn-danger">Pending</button>
                                                    @else
                                                        <button class="btn btn-success">Completed</button>
                                                    @endif
                                                </td>
                                                <td class="align-middle">
                                                    <button class="complete-task btn btn-link"
                                                        data-task-id="{{ $task->id }}" data-mdb-toggle="tooltip"
                                                        title="Done">
                                                        <i class="fas fa-check fa-lg text-success me-3"></i>Complete
                                                    </button>

                
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>


                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="addTaskModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add New Task</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="taskForm" class="mt-4 mb-4">
                                @csrf
                                <div class="form-group">
                                    <input type="text" class="form-control" name="title" placeholder="Task Title"
                                        required>
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control" name="description" placeholder="Task Description" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Add Task</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </section>
        <script>
            $('#taskForm').on('submit', function(event) {
                event.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: '/taskStore',
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        alert(response.message);
                        $('#addTaskModal').modal('hide'); 
                        fetchTasks(); 
                    },
                    error: function(error) {
                        console.error(error);
                        alert('Error adding task! Please try again.');
                    }
                });
            });



            function fetchTasks() {
                $.ajax({
                    url: '/tasks', 
                    method: 'GET',
                    success: function(response) {
                        response.data.forEach(function(task) {
                            var taskHtml =
                                '<tr class="fw-normal">' +
                                '<td class="align-middle"><h6 class="mb-0"><span class="badge bg-' +
                                task.ID +
                                '">' +
                                task.id +
                                '</span></h6></td>' +
                                '<td class="align-middle"><h6 class="mb-0"><span class="badge bg-' +
                                task.title +
                                '">' +
                                task.title +
                                '</span></h6></td>' +
                                '<td class="align-middle"><h6 class="mb-0"><span class="badge bg-' +
                                task.description +
                                '">' +
                                task.description +
                                '</span></h6></td>' +
                                '<td class="align-middle"><a href="#!" data-mdb-toggle="tooltip" title="Done"><i class="fas fa-check fa-lg text-success me-3"></i></a>' +
                                '<a href="#!" data-mdb-toggle="tooltip" title="Remove"><i class="bi bi-trash-fill text-warning"></i></a></td>' +
                                '</tr>';

                            $('tbody').append(taskHtml); 
                        });
                    },
                    error: function(error) {
                        console.error(error);
                    },
                });
            }

            $(document).on('click', '.complete-task', function(event) {
                event.preventDefault();
                var taskId = $(this).data('task-id');

                $.ajax({
                    url: '/completeTask/' +
                    taskId, 
                    method: 'POST', 
                    data: {
                        completed: 1
                    }, 
                    success: function(response) {
                        alert('Task marked as completed!');
                        fetchTasks(); 
                    },
                    error: function(error) {
                        console.error(error);
                        alert('Error marking task as completed!');
                    }
                });
            });
        </script>
</body>

</html>
