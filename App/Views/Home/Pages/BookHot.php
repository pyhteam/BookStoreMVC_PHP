<?php

use App\Services\Common\Helper; ?>
<h2 class="title">TOP Bán Chạy Nhất</h2>
<div class="row">
    <?php foreach ($bookBestSeller as $item): ?>
    <div class="col-4">
        <a href="/home/detail/<?= $item->Slug ?>/<?= $item->Id ?>">
            <img src="<?php echo $item->Image ?>" alt="<?= $item->Slug ?>">
        <a href="/home/detail/<?= $item->Slug ?>/<?= $item->Id ?>">
            <h4><?= $item->Title ?></h4>
        </a>
        <div class="rating">
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star-o"></i>
        </div>
        <p><?= Helper::formatCurrencyVND($item->Price) ?></p>
    </div>
    <?php endforeach; ?>
</div>