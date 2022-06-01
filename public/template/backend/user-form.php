<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once 'html/head.php'; ?>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <?php require_once 'html/navbar.php'; ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php require_once 'html/sidebar.php'; ?>


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <?php require_once 'html/page-header.php'; ?>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h5><i class="icon fas fa-exclamation-triangle"></i> Lỗi!</h5>
                                <ul class="list-unstyled mb-0">
                                    <li class="text-white"><b>Username:</b> Phải từ 3 đến 50 ký tự</li>
                                    <li class="text-white"><b>Email:</b> Email không hợp lệ!</li>
                                    <li class="text-white"><b>Group:</b> Vui lòng chọn giá trị!</li>
                                    <li class="text-white"><b>Password:</b> Giá trị này không được rỗng!</li>
                                </ul>
                            </div>
                            <form action="">
                                <div class="card card-outline card-info">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Username <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="username">
                                        </div>
                                        <div class="form-group">
                                            <label>Password <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="password">
                                        </div>
                                        <div class="form-group">
                                            <label>Email <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" name="email">
                                        </div>
                                        <div class="form-group">
                                            <label>FullName</label>
                                            <input type="text" class="form-control" name="fullName">
                                        </div>
                                        <div class="form-group">
                                            <label>Status <span class="text-danger">*</span></label>
                                            <select class="custom-select">
                                                <option selected> - Select Status - </option>
                                                <option>Active</option>
                                                <option>Inactive</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Group <span class="text-danger">*</span></label>
                                            <select class="custom-select">
                                                <option selected> - Select Group - </option>
                                                <option>Admin</option>
                                                <option>Manager</option>
                                                <option>Member</option>
                                                <option>Register</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-success">Save</button>
                                        <a href="group-list.php" class="btn btn-danger">Cancel</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        <?php require_once 'html/footer.php'; ?>
    </div>
    <!-- ./wrapper -->

    <?php require_once 'html/script.php'; ?>
</body>

</html>