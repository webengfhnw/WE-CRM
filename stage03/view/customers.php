<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 13.09.2017
 * Time: 16:59
 */
?>
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
                    <div class="btn-group" role="group">
                        <a class="btn btn-default" role="button" href="customer/edit"> <i class="fa fa-edit"></i></a>
                        <button class="btn btn-default" type="button" data-target="#confirm-modal" data-toggle="modal" data-href="customer/delete?id=1"> <i class="glyphicon glyphicon-trash"></i></button>
                    </div>
                </td>
            </tr>
            <tr>
                <td>2 </td>
                <td>James Mauer</td>
                <td>james@mauer.net </td>
                <td>+41788008080 </td>
                <td>
                    <div class="btn-group" role="group">
                        <a class="btn btn-default" role="button" href="customer/edit"> <i class="fa fa-edit"></i></a>
                        <button class="btn btn-default" type="button" data-target="#confirm-modal" data-toggle="modal" data-href="customer/delete?id=2"> <i class="glyphicon glyphicon-trash"></i></button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="btn-group" role="group">
        <a class="btn btn-default" role="button" href="customer/create"> <i class="fa fa-plus-square-o"></i></a>
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