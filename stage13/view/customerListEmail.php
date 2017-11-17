<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 13.09.2017
 * Time: 16:59
 */
use view\TemplateView;
?>
<!DOCTYPE html>
<html>
<body>
<table class="table">
    <thead>
    <tr>
        <th>ID </th>
        <th>Name </th>
        <th>Email </th>
        <th>Mobile </th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach($this->customers as $customer): /* @var Customer $customer */ ?>
    <tr>
        <td><?php echo $customer->getId(); ?> </td>
        <td><?php echo TemplateView::noHTML($customer->getName()); ?></td>
        <td><?php echo TemplateView::noHTML($customer->getEmail(), false); ?> </td>
        <td><?php echo TemplateView::noHTML($customer->getMobile()); ?> </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>