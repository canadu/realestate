<?php $int = 0; ?>
<main>
    <div class="container">
        <?php for ($i = 0; $i <= 2; $i++) : ?>
            <div class="row my-4">
                <?php for ($j = 0; $j <= 2; $j++) : ?>
                    <div class="col-sm-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">物件</h5>
                                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                <a href="detail.php?id=<?= $int ?>" class=" btn btn-primary">Go somewhere</a>
                            </div>
                        </div>
                    </div>
                    <?php $int++ ?>
                <?php endfor; ?>
            </div>
        <?php endfor; ?>
    </div>
</main>