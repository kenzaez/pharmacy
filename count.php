<div class="row">
    <div class="col-sm-6 col-md-6 col-lg-3 mt-3">
        <div class="card">
            <div class="content">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="icon-big text-center">
                            <i class="teal fas fa-shopping-cart"></i>
                        </div>
                    </div>
                    <?php 
                                                
                                              $sql = "SELECT COUNT(*) 
FROM sales 
WHERE saleDate >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)";
                                              $stmt = $conn->prepare($sql);
                                                $stmt->execute();
                                                $stmt->bind_result($order_count);
                                                $stmt->fetch();
                                                $stmt->close();

                                                ?>
                    <div class="col-sm-8">
                        <div class="detail">
                            <p class="detail-subtitle">New Sales</p>
                            <span class="number"><?php echo $order_count; ?></span>
                        </div>
                    </div>
                </div>
                <div class="footer">
                    <hr />
                    <div class="stats">
                        <i class="fas fa-calendar"></i> For this Month
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-3 mt-3">
        <div class="card">
            <div class="content">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="icon-big text-center">
                            <i class="olive fas fa-money-bill-alt"></i>
                        </div>
                    </div>
                    <?php 
                                                
                                              $sql = "SELECT SUM(totalPrice) FROM sales WHERE saleDate >= DATE_SUB(CURDATE(), INTERVAL 1 YEAR)";
                                              $stmt = $conn->prepare($sql);
                                              $stmt->execute();
                                              $stmt->bind_result($total_revenue);
                                                $stmt->fetch();
                                                $stmt->close();
                                         ?>
                    <div class="col-sm-8">
                        <div class="detail">
                            <p class="detail-subtitle">Revenue</p>
                            <span class="number"><?php echo round($total_revenue,2);?> MAD</span>
                        </div>
                    </div>
                </div>
                <div class="footer">
                    <hr />
                    <div class="stats">
                        <i class="fas fa-calendar"></i> For this Month
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-3 mt-3">
        <div class="card">
            <div class="content">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="icon-big text-center">
                            <i class="violet fas fa-eye"></i>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="detail">
                            <p class="detail-subtitle">Page views</p>
                            <span class="number"><?php echo  $_COOKIE['medicine']+$_COOKIE['staff'];?></span>
                        </div>
                    </div>
                </div>
                <div class="footer">
                    <hr />
                    <div class="stats">
                        <i class="fas fa-stopwatch"></i> For this Month
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-3 mt-3">
        <div class="card">
            <div class="content">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="icon-big text-center">
                            <i class="orange fas fa-user-tie"></i>
                        </div>
                    </div>
                    <?php $sql = "SELECT count(*) FROM users";
$stmt = $conn->prepare($sql);
$stmt->execute();
$stmt->bind_result($user_count);
$stmt->fetch();
$stmt->close();
?>
                    <div class="col-sm-8">
                        <div class="detail">
                            <p class="detail-subtitle">STAFF</p>
                            <span class="number"><?php echo $user_count;?></span>
                        </div>
                    </div>
                </div>
                <div class="footer">
                    <hr />
                    <div class="stats">
                        <i class="fas fa-envelope-open-text"></i> For this decade
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>