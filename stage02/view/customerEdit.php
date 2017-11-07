
    <div>
        <nav class="navbar navbar-default navigation-clean">
            <div class="container">
                <div class="navbar-header"><a class="navbar-brand navbar-link" href="#">WE-CRM </a>
                    <button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
                </div>
                <div class="collapse navbar-collapse" id="navcol-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li role="presentation"><a href="customers.php">My Customers</a></li>
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
            <h2 class="text-center">A <strong>customer</strong>. </h2></div>
        <form action="customers.php" method="post">
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon"><span>ID </span></div>
                    <input class="form-control" type="text" name="id" readonly="">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon"><span>Name </span></div>
                    <input class="form-control" type="text" name="name">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon"><span>Email </span></div>
                    <input class="form-control" type="email" name="email">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon"><span>Mobile </span></div>
                    <input class="form-control" type="text" name="mobile">
                </div>
            </div>
            <div class="btn-group" role="group">
                <button class="btn btn-default" type="submit"> <i class="fa fa-save"></i></button>
            </div>
        </form>
    </div>
