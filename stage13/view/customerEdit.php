<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 13.09.2017
 * Time: 17:06
 */
use view\View;
?>
<div class="container">
    <div class="page-header">
        <h2 class="text-center">A <strong>customer</strong>. </h2></div>
    <form action="update" method="post">
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-addon"><span>ID </span></div>
                <input class="form-control" type="text" name="id" readonly="" value="<?php echo isset($this->customer) ? $this->customer->getId() : ''; ?>">
            </div>
        </div>
        <div class="form-group <?php echo isset($this->customerValidator) && $this->customerValidator->isNameError() ? "has-error" : ""; ?>">
            <div class="input-group">
                <div class="input-group-addon"><span>Name </span></div>
                <input class="form-control" type="text" name="name" value="<?php echo isset($this->customer) ? View::noHTML($this->customer->getName()) : ''; ?>">
            </div>
            <p class="help-block"><?php echo isset($this->customerValidator) && $this->customerValidator->isNameError() ? $this->customerValidator->getNameError() : ""; ?></p>
        </div>
        <div class="form-group <?php echo isset($this->customerValidator) && $this->customerValidator->isEmailError() ? "has-error" : ""; ?>">
            <div class="input-group">
                <div class="input-group-addon"><span>Email </span></div>
                <input class="form-control" type="email" name="email" value="<?php echo isset($this->customer) ? View::noHTML($this->customer->getEmail()) : ''; ?>">
            </div>
            <p class="help-block"><?php echo isset($this->customerValidator) && $this->customerValidator->isEmailError() ? $this->customerValidator->getEmailError() : ""; ?></p>
        </div>
        <div class="form-group <?php echo isset($this->customerValidator) && $this->customerValidator->isMobileError() ? "has-error" : ""; ?>">
            <div class="input-group">
                <div class="input-group-addon"><span>Mobile </span></div>
                <input class="form-control" type="text" name="mobile" value="<?php echo isset($this->customer) ? View::noHTML($this->customer->getMobile()) : ''; ?>">
            </div>
            <p class="help-block"><?php echo isset($this->customerValidator) && $this->customerValidator->isMobileError() ? $this->customerValidator->getMobileError() : ""; ?></p>
        </div>
        <div class="btn-group" role="group">
            <button class="btn btn-default" type="submit"> <i class="fa fa-save"></i></button>
        </div>
    </form>
</div>
