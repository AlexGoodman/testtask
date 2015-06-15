<?php
/**
 * Created by PhpStorm.
 * User: Alexandr
 * Date: 23.05.2015
 * Time: 21:09
 */
?>

<h1>Phone Numbers</h1>

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-new-phone-number">Add Phone Number</button>

<div class="modal fade" id="modal-new-phone-number">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close close-modal-form" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">New Phone Number</h4>
            </div>

            <form method="post" action="#" id="form-new-phone-number">

            <div class="modal-body">
                <div class="row">

                    <div class="col-lg-12">
                        <div class="form-msg" id="msg-info" style="margin: 10px;"></div>
                    </div>

                    <div class="col-lg-12">
                        <div class="input-group">
                            <span class="input-group-addon" style="width: 150px;">Phone Number</span>
                            <input type="text" class="form-control" name="phone" id="input-phone-number">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="button" id="button-send-vcode" style="width: 100px;">Send Code</button>
                            </span>
                        </div>
                    </div>
                    <div class="col-lg-12" style="margin-top: 20px;">
                        <div class="input-group" style="width: 100%;">
                            <span class="input-group-addon" style="width: 150px;">Verification Code</span>
                            <input type="text" class="form-control" name="vcode" id="input-vcode">
                            <span class="input-group-btn">
                                <button class="btn btn-success" type="button" id="button-verify-phone" style="width: 100px;">Verify Phone</button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default close-modal-form" data-dismiss="modal">Close</button>
            </div>

            </form>

        </div>
    </div>
</div>