<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>

    <!-- =========================================================First Modal======================================================= -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Register
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <!-- Modal content -->
    </div>

    <!-- Table -->
    <table class="table">
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
            <!-- Table rows will be dynamically added here -->
        </tbody>
    </table>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
    </script>
    <script>
        $(document).ready(function () {
            // Load the table data on page load
            loadTableData();

            // Function to load the table data
            function loadTableData() {
                $.ajax({
                    type: "GET",
                    url: "controller.php",
                    success: function (response) {
                        console.log(response); // Display the response in the browser console

                        // Clear the table body
                        $('#tableBody').empty();

                        // Loop through the data and append rows to the table
                        for (var i = 0; i < response.length; i++) {
                            var row = '<tr>';
                            row += '<td>' + response[i].id + '</td>';
                            row += '<td>' + response[i].name + '</td>';
                            row += '<td>' + response[i].email + '</td>';
                            row += '<td>' + response[i].phone + '</td>';
                            row += '<td><a class="btn btn-success" href="update.php?type=update&id=' + response[i].id + '">Update</a></td>';
                            row += '<td><a class="btn btn-danger" href="delete.php?type=delete&id=' + response[i].id + '">Delete</a></td>';
                            row += '</tr>';

                            // Append the row to the table body
                            $('#tableBody').append(row);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log(xhr.responseText); // Display any error message in the browser console
                    }
                });
            }

            // Submit form data
            $("#input_form").submit(function (event) {
                event.preventDefault(); // Prevent form submission

                $.ajax({
                    type: "POST",
                    url: "controller.php",
                    data: $(this).serialize(),
                    success: function (response) {
                        console.log(response); // Display the response in the browser console
                        loadTableData(); // Reload the table data
                    },
                    error: function (xhr, status, error) {
                        console.log(xhr.responseText); // Display any error message in the browser console
                    }
                });
            });
        });
    </script>
</body>

</html>
