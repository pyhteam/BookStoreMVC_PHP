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
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Book 1</td>
                                    <td>120.000</td>
                                    <td>12/12/2022</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>