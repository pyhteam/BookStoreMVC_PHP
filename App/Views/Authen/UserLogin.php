<?php

use App\Services\Common\Session;
?>
<style>
    /* Basic Reset */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* Styling for Full Width Row */
    .row {
        display: flex;
        flex-wrap: wrap;
        /* Adjust this value as needed */
        align-items: flex-start;
        justify-content: flex-start !important;
    }

    /* Styling for Columns */
    .col-4 {
        flex: 0 0 calc(30% - 30px);
        padding: 15px;
    }

    .col-8 {
        flex: 0 0 calc(60% - 30px);
        /* Adjust this value as needed */
        padding: 15px;
    }

    /* Styling for Card */
    .card {
        border: 1px solid #ccc;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 15px;
    }

    .card-title {
        margin-bottom: 15px;
    }

    .card-title h3 {
        font-size: 20px;
        margin: 0;
    }

    .card-body ul {
        list-style: none;
        padding: 0;
    }

    .card-body ul li {
        margin-bottom: 8px;
    }

    .card-body ul li span {
        font-weight: bold;
    }

    .card-body ul li a {
        color: #007bff;
        text-decoration: none;
    }

    /* Styling for Table */
    .table-responsive {
        overflow-x: auto;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        border: 1px solid #ccc;
    }

    .table th,
    .table td {
        padding: 10px;
        text-align: left;
        border: 1px solid #ccc;
    }

    /* Styling for Table Head */
    .table thead {
        background-color: #f0f0f0;
    }

    /* Styling for Table Body */
    .table tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }
</style>
<!-- ---------- account page------------- -->

<?php if (!Session::has('token')) : ?>
    <div class="row">
        <div class="col-2">
            <img src="/assets-client/images/header-pic.png" alt="Header-Pic" width="50%" />
        </div>
        <div class="col-2">
            <div class="form-container">
                <div class="form-btn">
                    <span onclick="signIn()"> Sign In </span>
                    <span onclick="signUp()"> Sign Up </span>
                    <hr id="indicator" />

                    <form id="signInForm" name="myform">
                        <input type="text" placeholder="Username" id="Username" />
                        <span id="uname"></span>
                        <input type="password" placeholder="Password" id="Password" />
                        <button type="button" class="btn">Sign In</button>
                        <a href="">Forgot password</a>
                    </form>

                    <form id="signUpForm">
                        <input type="text" placeholder="Username" id="Username" />
                        <input type="email" placeholder="Email" id="Email" />
                        <input type="password" placeholder="Password" id="Password" />
                        <input type="password" placeholder="Confirm Password" id="ConfirmPassword" />
                        <button type="button" class="btn">Sign Up</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php else : ?>
    <div class="row">
        <div class="col-4">
            <div class="card">
                <div class="card-title">
                    <h3>Thông tin tài khoản</h3>
                </div>
                <div class="card-body">
                    <ul>
                        <li>
                            <label>Tài khoản</label>
                            <span><?= Session::get('user')->Username . ' - ' . Session::get('user')->FullName ?> </span>
                        </li>
                        <li>
                            <label>Email</label>
                            <span><?= Session::get('user')->Email ?></span>
                        </li>
                        <li>
                            <label>Phone</label>
                            <span><?= Session::get('user')->Phone ?></span>
                        </li>
                        <li><a href="/admin/logout">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="card">
                <div class="card-title">
                    <h3>Danh sách đơn hàng</h3>
                </div>
                <div class="card-body">
                    <div class="table-reponsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Mã đơn hàng</th>
                                    <th>Tổng Tiền</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày Order</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $index = 1;
                                foreach ($orders as $item) : ?>
                                    <tr>
                                        <td><?= $index ?></td>
                                        <td><?= $item->Id ?></td>
                                        <td><?= $item->TotalPrice ?></td>
                                        <td><?php
                                            switch ($item->Status) {
                                                case 'Pending':
                                                    echo '<span class="badge badge-warning">Đang chờ</span>';
                                                    break;
                                                case 'Approved':
                                                    echo '<span class="badge badge-success">Đã duyệt</span>';
                                                    break;
                                                case 'Cancelled':
                                                    echo '<span class="badge badge-danger">Đã hủy</span>';
                                                    break;
                                                default:
                                                    echo '<span class="badge badge-dark">Unknown</span>';
                                                    break;
                                            }
                                            ?></td>

                                        <td><?= $item->CreatedAt; ?></td>
                                        <td>
                                            <button class="btn btn-success btn-sm" onclick="cancel('<?= $item->Id ?>')" type="button">Hủy đơn</button>
                                        </td>
                                    </tr>
                                <?php $index++;
                                endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-12">
                        <?= $pagination->createLinks(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php endif; ?>




<script>
    var signInForm = document.getElementById("signInForm");
    var signUpForm = document.getElementById("signUpForm");
    var indicator = document.getElementById("indicator");

    function signIn() {
        signUpForm.style.transform = "translateX(300px)";
        signInForm.style.transform = "translateX(300px)";
        indicator.style.transform = "translateX(0px)";
    }

    function signUp() {
        signUpForm.style.transform = "translateX(0px)";
        signInForm.style.transform = "translateX(0px)";
        indicator.style.transform = "translateX(100px)";
    }
</script>