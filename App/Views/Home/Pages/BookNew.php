<?php

use App\Services\Common\Helper;
?>
<h2 class="title">Sách Mới</h2>
<div class="row">
    <?php
    foreach ($booksLatest as $book) : ?>
    <div class="col-4">
        <a href="/home/detail/<?= $book->Slug ?>/<?= $book->Id ?>">
            <img src="<?php echo $book->Image ?>" alt="<?= $book->Slug ?>">
            <a href="/home/detail/<?= $book->Slug ?>/<?= $book->Id ?>">
                <h4><?= $book->Title ?></h4>
            </a>
            <span>
                <?= $book->CategoryName;?>
            </span>
            <div class="rating">
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star-o"></i>
            </div>
            <p><?= Helper::formatCurrencyVND($book->Price) ?></p>
    </div>
    <?php endforeach; ?>
</div>