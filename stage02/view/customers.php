<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WE-CRM</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/footer.css">
    <link rel="stylesheet" href="assets/css/navigation.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
    <div>
        <nav class="navbar navbar-default navigation-clean">
            <div class="container">
                <div class="navbar-header"><a class="navbar-brand navbar-link" href="#">WE-CRM </a>
                    <button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
                </div>
                <div class="collapse navbar-collapse" id="navcol-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="active" role="presentation"><a href="#">My Customers</a></li>
                        <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" href="#">My Profile <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li role="presentation"><a href="agentEdit.php">Edit Profile</a></li>
                                <li role="presentation"><a href="#">Logout </a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <div class="container">
        <div class="page-header">
            <h2 class="text-center">My <strong>customers</strong>.</h2></div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID </th>
                        <th>Name </th>
                        <th>Email </th>
                        <th>Mobile </th>
                        <th>Action </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1 </td>
                        <td>Jonny Miller</td>
                        <td>jonny@miller.net </td>
                        <td>+41797007070 </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a class="btn btn-default" role="button" href="customerEdit.php"> <i class="fa fa-edit"></i></a>
                                <button class="btn btn-default" type="button" data-target="#confirm-modal" data-toggle="modal" data-href="customers.html"> <i class="glyphicon glyphicon-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>2 </td>
                        <td>James Mauer</td>
                        <td>james@mauer.net </td>
                        <td>+41788008080 </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a class="btn btn-default" role="button" href="customerEdit.php"> <i class="fa fa-edit"></i></a>
                                <button class="btn btn-default" type="button" data-target="#confirm-modal" data-toggle="modal" data-href="customers.html"> <i class="glyphicon glyphicon-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="btn-group" role="group">
            <a class="btn btn-default" role="button" href="customerEdit.php"> <i class="fa fa-plus-square-o"></i></a>
            <button class="btn btn-default" type="button"> <i class="fa fa-file-pdf-o"></i></button>
            <button class="btn btn-default" type="button"> <i class="fa fa-envelope-o"></i></button>
        </div>
        <div class="modal fade" role="dialog" tabindex="-1" id="confirm-modal">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title">Deletion of a <strong>customer</strong>.</h4></div>
                    <div class="modal-body">
                        <p>Do you want to delete a customer?</p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-default" type="button" data-dismiss="modal">Cancel </button><a class="btn btn-primary" role="button" href="#">Delete </a></div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-basic">
        <footer>
            <p class="copyright">WE © 2017</p>
        </footer>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>

</html>