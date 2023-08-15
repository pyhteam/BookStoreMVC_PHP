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
<div class="row">
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
                                <th>ID</th>
                                <th>Image</th>
                                <th>Tên sách</th>
                                <th>Tác giả</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="dataTable">

                            <!-- Total Price -->
                        </tbody>
                        <tr>
                            <td colspan="4" style="text-align: right;">Tổng tiền</td>
                            <td colspan="3" id="totalPrice" style="text-align: right; font-weight: bold; color: red;">

                            </td>
                        </tr>
                    </table>
                    <div class="form-control">
                        <input type="number" hidden name="totalPrice1" id="totalPrice1" value="0">
                        <input type="text" name="name" id="name" value="<?= Session::get('user')->Username ?>" placeholder="Nhập tên người nhận hàng" style="width: 100%; margin: 10px;padding: 8px;">
                        <input type="text" name="address" id="address" placeholder="Nhập địa chỉ nhận hàng" style="width: 100%;margin: 10px;padding: 8px;">
                        <input type="text" name="phone" id="phone" placeholder="Nhập số điện thoại" style="width: 100%;margin: 10px;padding: 8px;">
                        <button onclick="order()" type="button" class="btn">Thanh toán</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {

        loadData();

    })

    function loadData() {
        // carts 
        var carts = JSON.parse(localStorage.getItem('carts'));
        if (carts == null) {
            carts = [];
        }
        let html = '';
        let index = 1;
        let totalPrice = 0;
        for (const item of carts) {
            html += `<tr>
                        <td>${index}</td>
                        <td><img src="${item.Book.Image}" alt="" width="100px"></td>
                        <td>${item.Book.Title}</td>
                        <td>${item.Book.Author}</td>
                        <td>${formatCurrencyVND(Number(item.Book.Price))}</td>
                        <td><input type="number" value="${item.Quantity}" min="1" max="10" onchange="updateCart('${item.BookId}', ${item.Quantity})"></td>
                        <td><a href="javascript:void(0)" onclick="removeCart('${item.BookId}')">Xóa</a></td>
                    </tr>`;
            index++;
            totalPrice += Number(item.Book.Price * item.Quantity);
        }
        $('#dataTable').html(html);
        $('#totalPrice').html(formatCurrencyVND(totalPrice));
        $('#totalPrice1').val(totalPrice);
    }

    function removeCart(id) {
        var carts = JSON.parse(localStorage.getItem('carts'));
        var index = carts.findIndex(x => x.BookId == id);
        carts.splice(index, 1);
        localStorage.setItem('carts', JSON.stringify(carts));
        Swal.fire({
            icon: 'success',
            title: 'Xóa thành công',
            showConfirmButton: false,
            timer: 1500
        })
        setTimeout(function() {
            location.reload();
        }, 1500);
    }

    function updateCart(id, quantity) {

        var carts = JSON.parse(localStorage.getItem('carts'));
        var index = carts.findIndex(x => x.BookId == id);
        carts = carts.map(x => {
            if (x.BookId == id) {
                x.Quantity = quantity;
            }
            return {
                ...x
            };
        })
        localStorage.setItem('carts', JSON.stringify(carts));

        Swal.fire({
            icon: 'success',
            title: 'Cập nhật thành công',
            showConfirmButton: false,
            timer: 1500
        })
        setTimeout(function() {
            window.location.href = "/home/check-out";
        }, 1500);
    }

    function formatCurrencyVND(number) {
        if (typeof number !== "number" || isNaN(number)) {
            throw new Error("Invalid input. Please provide a valid number.");
        }
        const formattedAmount = new Intl.NumberFormat("vi-VN", {
            style: "currency",
            currency: "VND"
        }).format(number);
        return formattedAmount;
    }

    // order 
    function order() {
        var carts = JSON.parse(localStorage.getItem('carts'));
        if (carts == null) {
            carts = [];
        }
        if (carts.length == 0) {
            Swal.fire({
                icon: 'error',
                title: 'Giỏ hàng trống',
                showConfirmButton: false,
                timer: 1500
            })
            return;
        }
        //valid
        var name = $('#name').val();
        var address = $('#address').val();
        var phone = $('#phone').val();
        if (name == '' || address == '' || phone == '') {
            Swal.fire({
                icon: 'error',
                title: 'Vui lòng nhập đầy đủ thông tin',
                showConfirmButton: false,
            })
            return;
        }
        let order = {
            ShipName: name,
            ShipAddress: address,
            ShipPhone: phone,
            TotalPrice: $('#totalPrice1').val(),

            UserId: '<?= Session::get('user')->Id ?>',
            OrderDetails: [...carts]
        }
        console.log(order);
        $.ajax({
            url: "/order",
            method: "POST",
            data: order,
            success: function(res) {
                console.log(res);
                if (res.success == true) {
                    Swal.fire(
                        'Success!',
                        res.message,
                        'success'
                    )
                    localStorage.removeItem('carts');
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                    return;
                }
            },
            error: function(err) {
                console.log(err);
                Swal.fire(
                    'Error!',
                    'Something went wrong!',
                    'error'
                )
            }
        })
    }
</script>