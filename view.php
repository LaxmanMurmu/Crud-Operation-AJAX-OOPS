<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
</head>

<body>

<div class="row1 container mt-4">
    <h3 class="text-center text-danger">CRUD Application using PHP-OOPS, MySQL, AJAX, DataTable, bootstrap5.3</h3>
</div>

<div class="row2 container mt-5" style="display: flex; justify-content: space-between;">
    <div><h4>All Users in the Data Base</h4></div>
    <div>
         <!-- Register Button -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#insertModal">
        Add User
    </button>
    </div>
</div>
   

    <!-- ========================================Table=============================================== -->
    <div class="container border pt-3 mt-3">
    <table id="userTable" class="display">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Update</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody id="tableBody">
            <!-- Table rows will be dynamically added here*********************************** -->
        </tbody>
    </table>
    </div>

    <!--================================================= Modal============================================ -->
    <div class="modal fade" id="insertModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Register User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-success d-none" id="alert" role="alert">
                        Registered Successfully
                    </div>
                    <!-- Form -->
                    <form id="input_form">
                        <div class="mb-3">
                            <input placeholder="Name" name="name" type="text" class="form-control" id="name"
                                aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <input placeholder="E-mail" name="email" type="email" class="form-control" id="email"
                                aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <input placeholder="Phone" name="phone" type="text" class="form-control" id="phone">
                        </div>
                        <button type="submit" id="submit" value="submit" name="submit"
                            class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--========================================================= 2 UPDATE Modal================================================= -->
    <!-- Update Modal -->
    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Update User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="update_form">
                        <div class="mb-3">
                            <input placeholder="Name" name="name" type="text" class="form-control" id="update_name"
                                required>
                        </div>
                        <div class="mb-3">
                            <input placeholder="E-mail" name="email" type="email" class="form-control" id="update_email"
                                required>
                        </div>
                        <div class="mb-3">
                            <input placeholder="Phone" name="phone" type="text" class="form-control" id="update_phone"
                                required>
                        </div>
                        <input type="hidden" id="update_id" name="id">
                        <button type="submit" id="update" name="update" class="btn btn-primary">Update</button>

                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- *********************************************************SCRIPT*************************************************************** -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
    </script>


    <script>
    $(document).ready(function() {
        // Load the table data on page load
        loadTableData();

        // *************************************************Display*********************************************
        function loadTableData() {
            $.ajax({
                type: "GET",
                url: "controller.php",
                success: function(response) {
                    console.log(response); // Display the response in the browser console

                    // Clear the table body
                    $('#tableBody').empty();

                    // Loop through the data and append rows to the table
                    var i = 0;
                    while (i < response.length) {
                        var row = `<tr>
                                        <td>${response[i].id}</td>
                                        <td>${response[i].name}</td>
                                        <td>${response[i].email}</td>
                                        <td>${response[i].phone}</td>
                                        <td><a id="${response[i].id}" data-bs-toggle="modal" data-bs-target="#updateModal" class="btn btn-success update-btn" href="#">Update</a></td>
                                        <td><a id="${response[i].id}" class="btn btn-danger delete delete-btn" data-name="delete" href="#">Delete</a></td>
                                      </tr>`;
                        // Append the row to the table body
                        $('#tableBody').append(row);
                        i++;
                    }


                    // Attach click event handler to the update buttons
                    $(".update-btn").click(function() {
                        var userId = $(this).attr('id');
                        var user = response.find(u => u.id == userId);
                        if (user) {
                            $("#update_name").val(user.name);
                            $("#update_email").val(user.email);
                            $("#update_phone").val(user.phone);
                            $("#update_id").val(userId);
                        }
                    });

                    // Initialize the DataTable after loading the data
                    $('#userTable').DataTable();

                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText); // Display any error message in the browser console
                }
            });
        }



        // Function to clear the form fields
        function clearFormFields() {
            $('#name').val('');
            $('#email').val('');
            $('#phone').val('');
        }

        // *************************************************Insert form data*********************************************
        $("#input_form").submit(function(event) {
            event.preventDefault(); // Prevent form submission

            $.ajax({
                type: "POST",
                url: "controller.php?type=insert",
                data: $(this).serialize(),
                success: function(response) {
                    console.log(response); // Display the response in the browser console
                    loadTableData(); // Reload the table data
                    clearFormFields(); // Clear the form fields
                    $('#alert').removeClass('d-none'); // Show the alert message
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText); // Display any error message in the browser console
                }
            });
        });

        // *************************************************Update form current data display*********************************************
        $(".update-btn").click(function() {
            var userId = $(this).attr('id');
            var user = response.find(u => u.id == userId);
            if (user) {
                $("#update_name").val(user.name);
                $("#update_email").val(user.email);
                $("#update_phone").val(user.phone);
                $("#update_id").val(userId);
            }
        });

        // *************************************************Update query*********************************************
        $("#update_form").submit(function(event) {
            event.preventDefault(); // Prevent form submission

            var userId = $("#update_id").val();
            var updatedUser = {
                name: $("#update_name").val(),
                email: $("#update_email").val(),
                phone: $("#update_phone").val()
            };

            $.ajax({
                type: "POST",
                url: "controller.php?type=update",
                data: {
                    id: userId,
                    ...updatedUser
                },
                success: function(response) {
                    console.log(response);
                    loadTableData();
                    $("#updateModal").modal("hide");
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        });

        // *************************************************Delete query*********************************************
        $(document).on('click', '.delete-btn', function() {
            var userId = $(this).attr('id');

            // Confirm the deletion
            if (confirm("Are you sure you want to delete this user?")) {
                $.ajax({
                    type: "POST",
                    url: "controller.php?type=delete",
                    data: {
                        id: userId
                    },
                    success: function(response) {
                        console.log(response);
                        loadTableData(); // Reload the table data
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            }
        });

    });
    </script>
</body>

</html>