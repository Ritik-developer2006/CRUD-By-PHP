<?php
require("connect.php");

$sql = "SELECT * FROM users";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $data = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $data = [];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrap DataTable Example</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
</head>

<body class="bg-dark">
    <div class='d-flex justify-content-center align-items-center' style="height:100vh;">
        <div class="card">
            <div class="card-header">
                <div class='d-flex justify-content-between'>
                    <div>
                        <?php if(isset($_GET['error'])){
                            echo "<div class='text-danger fs-5 pt-1 fw-bold'>".$_GET['error']."</div>";
                        }
                        if(isset($_GET['message'])){
                            echo "<div class='text-success fw-bold'>".$_GET['message']."</div>";
                        } ?>
                    </div>
                    <div>
                        <button type="button" class="btn btn-outline-success" data-bs-toggle='modal' data-bs-target='#staticBackdrop3'>Create User</button>
                    </div>
                </div>
            </div>
            <div class="card-body overflow-auto" style="height:auto;">
                <table id="example" class="table table-striped nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>User Id</th>
                            <th>Name</th>
                            <th>Email Id</th>
                            <th>Number</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Photo</th>
                            <th>Created At</th>
                            <th>Operations</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($data as $v) {
                            echo "<tr class='align-middle'>
                                    <input type='hidden' value='".base64_encode(json_encode($v))."'>
                                    <td>" . $v['uid'] . "</td>
                                    <td>" . $v['name'] . "</td>
                                    <td>" . $v['email'] . "</td>
                                    <td>" . $v['number'] . "</td>
                                    <td>" . ($v['role'] == 1 ? 'Admin' : 'User') . "</td>
                                    <td>" . ($v['status'] == 2 ? '<button class="btn btn-sm btn-danger">Blocked</button>' : '<button class="btn btn-sm btn-success w-100">Active</button>') . "</td>
                                    <td><img width='100px' height='80px' src='images/".$v['photo']."' alt=''></td>
                                    <td>" . $v['created_at'] . "</td>
                                    <td class='text-center'>
                                    <i class='fa-solid text-danger fa-trash-can me-2 delete_user cursor-pointer' data-bs-toggle='modal' data-bs-target='#staticBackdrop'></i>
                                    <i class='fa-solid text-warning fa-pen update_user cursor-pointer' data-bs-toggle='modal' data-bs-target='#staticBackdrop2'></i></td>
                                </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal for delete user -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5" id="staticBackdropLabel">Delete "<span id="select_user"></span>" Profile :-</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="delete_user.php">
                        <input type="hidden" name="user_id" class="user_id">
                        <input type="hidden" name="prev_photo" class="prev_photo">
                        Are You sure To Delete This User.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Update User -->
    <div class="modal fade" id="staticBackdrop2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5" id="staticBackdropLabel">Update "<span class="select_user"></span>" Profile :-</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-3 needs-validation" action="update_user.php" method="post" enctype="multipart/form-data" novalidate>
                        <input type="hidden" id='uid' name='uid' value="">
                        <input type="hidden" class="prev_photo" name='prev_photo' value="">
                        <div class="col-md-12">
                            <label for="validationCustom01" class="form-label fw-bold">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control name" name="name" placeholder="Enter your name." id="validationCustom01" value="" required>
                            <div class="invalid-feedback">
                                Please enter your name
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="validationCustom02" class="form-label fw-bold">Email Id <span class="text-danger">*</span></label>
                            <input type="email" class="form-control email" name="email" placeholder="Enter your email." id="validationCustom02" value="" required>
                            <div class="invalid-feedback">
                                Please enter your name
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="validationCustomUsername" class="form-label fw-bold">Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control number" name="number" id="validationCustomUsername" aria-describedby="inputGroupPrepend" value="" placeholder="Enter your number." required>
                            <div class="invalid-feedback">
                                Please enter your mobile number.
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="validationCustom04" class="form-label fw-bold">Role <span class="text-danger">*</span></label>
                            <select class="form-select role" name="role" id="validationCustom04" required>
                                <option selected disabled value="">Choose...</option>
                                <option value="1">Admin</option>
                                <option value="2">User</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select user role.
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="validationCustom05" class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                            <select class="form-select status" name="status" id="validationCustom05" required>
                                <option selected disabled value="">Choose...</option>
                                <option value="1">Active</option>
                                <option value="2">Blocked</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select user status.
                            </div>
                        </div>
                        <div class="col-md-3" id="img">
                           
                        </div>
                        <div class="col-md-9">
                            <label for="validationCustom06" class="form-label fw-bold">Change Photo <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" name="photo" id="validationCustom06">
                            <div class="invalid-feedback">
                                Please upload user photo.
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit">Update</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal for Create User -->
    <div class="modal fade" id="staticBackdrop3" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5" id="staticBackdropLabel">Create User</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-3 needs-validation" action="insert_user.php" method="POST" enctype="multipart/form-data" novalidate>
                        <div class="col-md-12">
                            <label for="validationCustom01" class="form-label fw-bold">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" placeholder="Enter your name." id="validationCustom01" value="" required>
                            <div class="invalid-feedback">
                                Please enter your name
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="validationCustom02" class="form-label fw-bold">Email Id <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" placeholder="Enter your email." id="validationCustom02" value="" required>
                            <div class="invalid-feedback">
                                Please enter your name
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="validationCustomUsername" class="form-label fw-bold">Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="number" id="validationCustomUsername" aria-describedby="inputGroupPrepend" value="" placeholder="Enter your number." required>
                            <div class="invalid-feedback">
                                Please enter your mobile number.
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="validationCustom04" class="form-label fw-bold">Role <span class="text-danger">*</span></label>
                            <select class="form-select" name="role" id="validationCustom04" required>
                                <option selected disabled value="">Choose...</option>
                                <option value="1">Admin</option>
                                <option value="2">User</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select user role.
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="validationCustom05" class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                            <select class="form-select" name="status" id="validationCustom05" required>
                                <option selected disabled value="">Choose...</option>
                                <option value="1">Active</option>
                                <option value="2">Blocked</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select user status.
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="validationCustom06" class="form-label fw-bold">Photo <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" name="photo" id="validationCustom06" required>
                            <div class="invalid-feedback">
                                Please upload user photo.
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit">Create</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="custom.js"></script>
    <!-- Bootstrap Form validation -->
    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (() => {
            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            const forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
</body>

</html>