<?php
$usernamenotification = Session::getUser()->getUsername();
$notifications = getNotifications($usernamenotification);
?>
<body>
    <div class="container py-4">
        <div class="p-5 mb-4 bg-body-tertiary rounded-3">
            <div class="container-fluid py-5">
                <h1 class="display-5 fw-bold">Hi, <?php echo $usernamenotification; ?></h1>
                <p class="col-md-8 fs-4">Here are your bill requests from your friends:</p>
            </div>
        </div>
        <div class="row">
            <?php foreach ($notifications as $notification): ?>
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            <?= htmlspecialchars($notification["bill_title"]) ?>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars(
                                $notification["bill_title"]
                            ) ?></h5>
                            <p class="card-text"><?= htmlspecialchars(
                                $notification["bill_cost"]
                            ) ?></p>
                            <p class="card-text"><?= htmlspecialchars(
                                $notification["note"]
                            ) ?></p>
                            <form method="post" action="payotherbills">
                                <input type="hidden" name="bill_id" value="<?= htmlspecialchars(
                                    $notification["id"]
                                ) ?>">
                                <input type="hidden" name="bill_cost" value="<?= htmlspecialchars(
                                    $notification["bill_cost"]
                                ) ?>">
                                <input type="hidden" name="created_at" value="<?= htmlspecialchars(
                                    $notification["created_at"]
                                ) ?>">
                                <button type="submit" class="btn btn-primary">Pay bill</button>
                            </form>
                        </div>
                        <div class="card-footer text-body-secondary">
                            <?= htmlspecialchars($notification["created_at"]) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
