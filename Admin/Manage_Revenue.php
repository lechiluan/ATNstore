<?php
    if(!isset($_SESSION['admin']) or $_SESSION['admin']==0)
    {
        echo "<script>alert('You are not administration')</script>";
        echo '<meta http-equiv="refresh" content="0;URL=index.php">';
    }
    else
    {
    ?>
<?php
                function bind_branch_List($conn)
                {
                    $sqlstring = "SELECT branchid, branchname FROM branch";
                    $result = pg_query($conn, $sqlstring);
                    echo "<select name='BranchList' class='form-control'>
                    <option value='0'>Chose Branch</option>";
                    while ($row = pg_fetch_array($result, NULL, PGSQL_ASSOC)) {
                        echo "<option value='" . $row['branchid'] . "'>" . $row['branchname'] . "</option>";
                    }
                    echo "</select>";
                }
?>
<div class="container">
    <h1>Revenue Management by month</h1>
    <form id="frmProduct" name="frmProduct" method="POST" enctype="multipart/form-data" class="form-horizontal"
        role="form">
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">Choose branch to statistic </label>
            <div class="col-sm-10">
                <?php bind_branch_List($conn); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">Choose Month: </label>
            <div class="col-sm-10">
                <select name="month" class='form-control'>
                    <option value='0'>Choose month</option>
                    <option value='1'>January</option>
                    <option value='2'>February</option>
                    <option value='3'>March</option>
                    <option value='4'>April</option>
                    <option value='5'>May</option>
                    <option value='6'>June</option>
                    <option value='7'>July</option>
                    <option value='8'>August</option>
                    <option value='9'>September</option>
                    <option value='10'>October</option>
                    <option value='11'>November</option>
                    <option value='12'>December</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary" name="btnView" id="btnView">Statistic</button>
                <input type="button" class="btn btn-primary" name="btnIgnore" id="btnIgnore" value="Ignore"
                    onclick="window.location='index.php'" />

            </div>
        </div>
    </form>
</div>

<br><br>


<form name="frm" method="post">
    <table id="tableproduct" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th><strong>No.</strong></th>
                <th><strong>Branch ID</strong></th>
                <th><strong>Branch name</strong></th>
                <th><strong>Branch Address</strong></th>
                <th><strong>Product</strong></th>
                <th><strong>Image</strong></th>
                <th><strong>Quantity</strong></th>
                <th><strong>Total Price</strong></th>
                <th><strong>Left in stock</strong></th>
                <!-- <th><strong>Description</strong></th>-->
                <!--<th><strong>Category ID</strong></th>
                <th><strong>Store</strong></th>
                <th><strong>Image</strong></th>-->

            </tr>
        </thead>

        <tbody>
            <?php
            include_once("connection.php");
            if(isset($_POST["btnView"]))
            {
                $store = $_POST['BranchList'];
                $month = $_POST['month'];
                if($store=="0"){
                    echo "<script>alert('Choose store please')</script>";
                }
                elseif($month=="0"){
                    echo "<script>alert('Choose month please')</script>";
                }
                else{

                    $No=1;
                    $result = pg_query($conn, "SELECT b.branchid, branchname, address, proname, a.proimage, qty, totalprice, proqty 
                                                from product a, branch b, orders c, orderdetail d 
                                                where a.branchid=b.branchid and a.proid = d.proid and c.orderid = d.orderid 
                                                    and date_part('month', orderdate ) = '$month' and b.branchid = '$store'");
                    if (!$result) {
                        printf("Error: %s\n", pg_errormessage($conn));
                        exit();
                    }
                    while($row = pg_fetch_array($result, NULL, PGSQL_ASSOC)) {
                        $sumTotal += $row['totalprice'];
        ?>
            <tr>
                <td><?php echo $No; ?></td>
                <td><?php echo $row['branchid']; ?></td>
                <td><?php echo $row['branchname']; ?></td>
                <td><?php echo $row['address']; ?></td>
                <td><?php echo $row['proname']; ?></td>
                <td align='center' class='cotNutChucNang'>
                    <img src='product-imgs/<?php echo $row['proimage']?>' border='0' width="50" height="50" />
                </td>
                <td><?php echo $row['qty']; ?></td>
                <td>$ <?php echo number_format($row['totalprice']); ?></td>
                <td><?php echo $row['proqty']; ?></td>
            </tr>

            <?php
            $No++;
            }
        }
    }
        ?>
            <tr>
                <td colspan="7" align="right">
                    <h3>TOTAL REVENUE</h3>
                </td>
                <td>
                    <h3 class="price"><b>$<?php echo Number_format($sumTotal); ?></b></h3>
                </td>
                <td></td>
            </tr>
        </tbody>
    </table>
</form>
</body>
<?php
    }
    ?>