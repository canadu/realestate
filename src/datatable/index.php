<?php include(__DIR__ . '/connection.php') ?>
<!doctype html>
<html lang="ja">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.11.4/datatables.min.css" />
    <title>Server side Datatable CRUD</title>
    <style type="text/css">
        .btnAdd {
            text-align: right;
            width: 83%;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <h2 class="text-center">sample datatable</h2>
        <p class="datatable design text-center">sample datatable</p>
        <div class="row">
            <div class="container">
                <div class="btnAdd">
                    <a href="#!" data-id="" data-bs-toggle="modal" data-bs-target="#addUserModal" class="btn btn-success btn-sm">Add User</a>
                </div>
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <table id="datatable" class="table">
                            <thead>
                                <th>SNo.</th>
                                <th>UserName</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>City</th>
                                <th>Options</th>
                            </thead>
                        </table>
                    </div>
                    <div class="col-md-2"></div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.11.4/datatables.min.js"></script>

    <!-- datatable start -->
    <script type="text/javascript">
        $(document).ready(function() {
            $('#datatable').DataTable({
                'fnCreateRow': function(nRow, aData, iDataIndex) {
                    $(nRow).attr('id', aData[0]);
                },
                //datatableを日本語化
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.22/i18n/Japanese.json"
                },
                'serverSide': true,
                'processing': true,
                'paging': true,
                'order': [],
                'ajax': {
                    'url': 'fetch_data.php',
                    'type': 'post',
                },
                "aoColumnDefs": [{
                    "bSortable": false,
                    "aTargets": [5],
                }, ]
            });
        });
        // datatable end

        //Add User start ================================================
        $(document).on('submit', '#addUser', function(e) {
            e.preventDefault();
            var city = $('#addCityField').val();
            var username = $('#addUserField').val();
            var mobile = $('#addMobileField').val();
            var email = $('#addEmailField').val();
            if (city != '' && username != '' && mobile != '' && email != '') {
                $.ajax({
                    url: "add_user.php",
                    type: "post",
                    data: {
                        city: city,
                        username: username,
                        mobile: mobile,
                        email: email
                    },
                    success: function(data) {
                        var json = JSON.parse(data);
                        var status = json.status;
                        if (status === true) {
                            table = $('#datatable').DataTable();
                            table.draw();
                            $('#addCityField').val("");
                            $('#addUserField').val("");
                            $('#addMobileField').val("");
                            $('#addEmailField').val("");
                            $('#addUserModal').modal('hide');
                        } else {
                            alert('エラーが発生しました。');
                        }
                    }
                });
            } else {
                alert('全ての項目を記入してください。');
            }
        });
        //Add User end ================================================

        //Update User start ================================================
        $(document).on('submit', '#updateUser', function(e) {
            e.preventDefault();
            var city = $('#cityField').val();
            var username = $('#nameField').val();
            var mobile = $('#mobileField').val();
            var email = $('#emailField').val();
            var trid = $('#trid').val();
            var id = $('#id').val();
            if (city != '' && username != '' && mobile != '' && email != '') {
                $.ajax({
                    url: "update_user.php",
                    type: "post",
                    data: {
                        city: city,
                        username: username,
                        mobile: mobile,
                        email: email,
                        id: id
                    },
                    success: function(data) {
                        var json = JSON.parse(data);
                        var status = json.status;
                        if (status === true) {
                            var table = $('#datatable').DataTable();
                            //var button = '<td><a href="javascript:void();" data-id="' + id + '" class="btn btn-info btn-sm editbtn">Edit</a><a href="#!" data-id="' + id + '" class="btn btn-danger btn-sm deleteBtn">Delete</a></td>';
                            //var row = table.row("[id='" + trid + "']");
                            //row.row("[id='" + trid + "']").data([id, username, email, mobile, city, button]);
                            $('#updateModal').modal('hide');
                            table.draw();
                        } else {
                            alert('エラーが発生しました。');
                        }
                    }
                });
            } else {
                alert('Fill all the required fields');
            }
        });
        //Update User start ================================================

        //Edit Button start ================================================
        $(document).on('click', '.editbtn', function(event) {
            var table = $('#datatable').DataTable();
            var trid = $(this).closest('tr').attr('id');
            var id = $(this).data('id');
            $('#updateModal').modal('show');
            $.ajax({
                url: "get_single_data.php",
                data: {
                    id: id
                },
                type: 'post',
                success: function(data) {
                    var json = JSON.parse(data);
                    $('#nameField').val(json.username);
                    $('#emailField').val(json.email);
                    $('#mobileField').val(json.mobile);
                    $('#cityField').val(json.city);
                    $('#id').val(id);
                    $('#trid').val(trid);
                }
            })
        });
        //Edit Button end ================================================

        //Delete Button start ================================================
        $(document).on('click', '.deleteBtn', function(event) {
            var table = $('#datatable').DataTable();
            event.preventDefault();
            var id = $(this).data('id');
            if (confirm("削除しても良いですか?")) {
                $.ajax({
                    url: "delete_user.php",
                    data: {
                        id: id
                    },
                    type: "post",
                    success: function(data) {
                        var json = JSON.parse(data);
                        var status = json.status;
                        if (status == 'success') {
                            $("#" + id).closest('tr').remove();
                            table.draw();
                        } else {
                            alert('エラーが発生しました。');
                            return;
                        }
                    }
                })
            } else {
                return null;
            }
        });
        //Delete Button start ================================================
    </script>

    <!-- Modal -->
    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="updateUser">
                        <input type="hidden" name="id" id="id" value="">
                        <input type="hidden" name="trid" id="trid" value="">
                        <div class="mb-3 row">
                            <label for="nameField" class="col-md-3 form-label">Name</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="nameField" name="name">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="emailField" class="col-md-3 form-label">Email</label>
                            <div class="col-md-9">
                                <input type="email" class="form-control" id="emailField" name="email">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="mobileField" class="col-md-3 form-label">Mobile</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="mobileField" name="mobile">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="cityField" class="col-md-3 form-label">City</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="cityField" name="City">
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-success">Update User</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- add user modal start -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
                    <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                </div>
                <div class="modal-body">
                    <form id="addUser">
                        <div class="mb-3 row">
                            <label for="addUserField" class="col-md-3 form-label">UserName</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="addUserField" name="name">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="addEmailField" class="col-md-3 form-label">Email</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="addEmailField" name="email">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="addMobileField" class="col-md-3 form-label">Mobile</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="addMobileField" name="mobile">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="addCityField" class="col-md-3 form-label">City</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="addCityField" name="City">
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-success">Add User</button>
                        </div>
                        </from>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- add user modal end -->
</body>

</html>