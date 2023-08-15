<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                Danh Sách Order Detail - Mã Order #<strong style="color: red;" ><?= $order->Code ?></strong>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>BookImage</th>
                            <th>BookName</th>
                            <th>BookPrice</th>
                            <th>Quantity</th>

                            <th>CreatedAt</th>
                            <th>CreatedBy</th>
                            <th>UpdatedAt</th>
                            <th>UpdatedBy</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $index = 1;
                        foreach ($order->OrderDetails as $item) : ?>
                            <tr>
                                <td><?= $index ?></td>
                                <td><?= $item->BookImage ? '<img src="' . $item->BookImage . '" width="100px" height="100px" />' : '' ?></td>
                                <td><?= $item->BookName ?></td>
                                <td><?= $item->BookPrice ?></td>
                                <td><?= $item->Quantity ?></td>

                                <td><?= $item->CreatedAt; ?></td>
                                <td><?= $item->CreatedBy; ?></td>
                                <td><?= $item->UpdatedAt; ?></td>
                                <td><?= $item->UpdatedBy; ?></td>
                            </tr>
                        <?php $index++;
                        endforeach; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    <div class="col-sm-12">
        <?= $pagination->createLinks(); ?>
    </div>
</div>