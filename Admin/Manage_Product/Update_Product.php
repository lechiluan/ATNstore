    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script type="text/javascript" src="scripts/ckeditor/ckeditor.js"></script>
    <?php
	include_once("Connection.php");
	function bind_Category_List($conn,$selectedValue){
		$sqlstring="SELECT catid, catname FROM category";
		$result = pg_query($conn, $sqlstring);
		echo "<select name='CategoryList' class='form-control'>
			<option value='0'>Chose category</option>";
			while ($row = pg_fetch_array($result, NULL, PGSQL_ASSOC)){
				if($row['catid'] == $selectedValue)
				{
					echo "<option value='".$row['catid']."' selected>".$row['catname']."</option>";
				}
				else{
					echo "<option value='".$row['catid']."'>".$row['catname']."</option>";
				}
			}
		echo "</select>";
	}

	
	function bind_supplier_List($conn,$selectedValue){
		$sqlstring="SELECT supid, supname FROM suppliers";
		$result = pg_query($conn, $sqlstring);
		echo "<select name='SupplierList' class='form-control'>
			<option value='0'>Chose supplier</option>";
			while ($row = pg_fetch_array($result, NULL, PGSQL_ASSOC)){
				if($row['supid'] == $selectedValue)
				{
					echo "<option value='".$row['supid']."' selected>".$row['supname']."</option>";
				}
				else{
					echo "<option value='".$row['supid']."'>".$row['supname']."</option>";
				}
			}
		echo "</select>";
	}

	function bind_branch_List($conn,$selectedValue){
		$sqlstring="SELECT branchid, branchname FROM branch";
		$result = pg_query($conn, $sqlstring);
		echo "<select name='BranchList' class='form-control'>
			<option value='0'>Chose branch</option>";
			while ($row = pg_fetch_array($result, NULL, PGSQL_ASSOC)){
				if($row['branchid'] == $selectedValue)
				{
					echo "<option value='".$row['branchid']."' selected>".$row['branchname']."</option>";
				}
				else{
					echo "<option value='".$row['branchid']."'>".$row['branchname']."</option>";
				}
			}
		echo "</select>";
	}


	if(isset($_GET["id"]))
	{
		$id= $_GET["id"];
		$sqlstring = "SELECT proid, proname, price, oldprice, smalldesc, detaildesc, prodate, proqty, proimage, catid, supid, branchid
		FROM product WHERE proid = '$id' ";

		$result = pg_query($conn, $sqlstring);
		$row = pg_fetch_array($result, NULL, PGSQL_ASSOC);
		
		$proname =$row["proname"];
		$short = $row['smalldesc'];
		$detail=$row['detaildesc'];
		$price=$row['price'];
		$oldprice=$row['oldprice'];
		$qty=$row['proqty'];
		$pic =$row['proimage'];
		$category = $row['catid'];
		$supplier = $row['supid'];
		$branch = $row['branchid'];

?>
    <div class="container">
        <h2>Updating Product</h2>

        <form id="frmProduct" name="frmProduct" method="post" enctype="multipart/form-data" action=""
            class="form-horizontal" role="form">
            <div class="form-group">
                <label for="txtTen" class="col-sm-2 control-label">Product ID(*):</label>
                <div class="col-sm-10">
                    <input type="text" name="txtID" id="txtID" class="form-control" placeholder="Product ID" readonly
                        value='<?php echo $id; ?>' />
                </div>
            </div>

            <div class="form-group">
                <label for="txtTen" class="col-sm-2 control-label">Product Name(*):</label>
                <div class="col-sm-10">
                    <input type="text" name="txtName" id="txtName" class="form-control" placeholder="Product Name"
                        value='<?php echo $proname;?>' />
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-sm-2 control-label">Product category(*):</label>
                <div class="col-sm-10">
                    <?php bind_Category_List($conn,$category); ?>
                </div>
            </div>

			<div class="form-group">
                <label for="" class="col-sm-2 control-label">Product supplier(*): </label>
                <div class="col-sm-10">
                    <?php bind_supplier_List($conn,$supplier); ?>
                </div>
            </div>
            
            <div class="form-group">
                <label for="" class="col-sm-2 control-label">Product  branch(*): </label>
                <div class="col-sm-10">
                    <?php bind_branch_List($conn,$branch); ?>
                </div>
            </div>

            <div class="form-group">
                <label for="lblGia" class="col-sm-2 control-label">Price(*): </label>
                <div class="col-sm-10">
                    <input type="text" name="txtPrice" id="txtPrice" class="form-control" placeholder="Price"
                        value='<?php echo $price; ?>' />
                </div>
            </div>

            <div class="form-group">
                <label for="lblGia" class="col-sm-2 control-label">Old Price(*): </label>
                <div class="col-sm-10">
                    <input type="text" name="txtoldPrice" id="txtoldPrice" class="form-control" placeholder="oldPrice"
                        value='<?php echo $oldprice; ?>' />
                </div>
            </div>

            <div class="form-group">
                <label for="lblShort" class="col-sm-2 control-label">Short description(*): </label>
                <div class="col-sm-10">
                    <input type="text" name="txtShort" id="txtShort" class="form-control"
                        placeholder="Short description" value='<?php echo $short;?>' />
                </div>
            </div>

            <div class="form-group">
                <label for="lblDetail" class="col-sm-2 control-label">Detail description(*): </label>
                <div class="col-sm-10">
                    <textarea name="txtDetail" rows="4" class="ckeditor"><?php echo $detail;?></textarea>
                    <script language="javascript">
                    CKEDITOR.replace('txtDetail', {
                        skin: 'kama',
                        extraPlugins: 'uicolor',
                        uiColor: '#eeeeee',
                        toolbar: [
                            ['Source', 'DocProps', '-', 'Save', 'NewPage', 'Preview', '-', 'Templates'],
                            ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteWord', '-', 'Print', 'SpellCheck'],
                            ['Undo', 'Redo', '-', 'Find', 'Replace', '-', 'SelectAll', 'RemoveFormat'],
                            ['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button',
                                'ImageButton', 'HiddenField'
                            ],
                            ['Bold', 'Italic', 'Underline', 'StrikeThrough', '-', 'Subscript',
                                'Superscript'],
                            ['OrderedList', 'UnorderedList', '-', 'Outdent', 'Indent', 'Blockquote'],
                            ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyFull'],
                            ['Link', 'Unlink', 'Anchor', 'NumberedList', 'BulletedList', '-', 'Outdent',
                                'Indent'
                            ],
                            ['Image', 'Flash', 'Table', 'Rule', 'Smiley', 'SpecialChar'],
                            ['Style', 'FontFormat', 'FontName', 'FontSize'],
                            ['TextColor', 'BGColor'],
                            ['UIColor']
                        ]
                    });
                    </script>

                </div>
            </div>

            <div class="form-group">
                <label for="lblSoLuong" class="col-sm-2 control-label">Quantity(*): </label>
                <div class="col-sm-10">
                    <input type="number" name="txtQty" id="txtQty" class="form-control" placeholder="Quantity"
                        value="<?php echo $qty;?>" />
                </div>
            </div>

            <div class="form-group">
                <label for="sphinhanh" class="col-sm-2 control-label">Image(*): </label>
                <div class="col-sm-10">
                    <img src='product-imgs/<?php echo $pic; ?>' border='0' width="50" height="50" />
                    <input type="file" name="txtImage" id="txtImage" class="form-control" value="" />
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <input type="submit" class="btn btn-primary" name="btnUpdate" id="btnUpdate" value="Update" />
                    <input type="button" class="btn btn-primary" name="btnIgnore" id="btnIgnore" value="Ignore"
                        onclick="window.location='?page=product_management'" />
                </div>
            </div>
        </form>
    </div>
    <?php
	}	
	else 
	{
		echo '<meta http-equiv="Refresh" content="0; URL=?page=product_management"/>';
	}
?>
    <?php	
	include_once("Connection.php");
	if(isset($_POST["btnUpdate"]))
	{
		$id=$_POST["txtID"];
		$proname=$_POST["txtName"];
		$short=$_POST['txtShort'];
		$detail=$_POST['txtDetail'];
		$price=$_POST['txtPrice'];
		$oldprice=$_POST['txtoldPrice'];
		$qty=$_POST['txtQty'];
		$pic=$_FILES['txtImage'];
		$category=$_POST['CategoryList'];
		$supplier=$_POST['SupplierList'];
        $branch = $_POST['BranchList'];
		
		$err="";

		if(trim($id)=="")
		{
			$err .="<li>Enter Product ID, please</li>";
		}
		if(trim($proname)=="")
		{
			$err .= "<li>Enter product name,please</li>";
		}
		if($category=="0")
		{
			$err .= "<li>Choose product category,please</li>";
		}
		if ($supplier == "0") {
            $err .= "<li>Choose product supplier,please</li>";
        }
        if ($branch == "0") {
            $err .= "<li>Choose product branch,please</li>";
        }
        if (!is_numeric($price)) {
            $err .= "<li>Product price must be number</li>";
        }
        if (!is_numeric($oldprice)) {
            $err .= "<li>Product price must be number</li>";
        }
		if(!is_numeric($qty))
		{
			$err .= "<li>Product quantity must be number</li>";
		}
		if($err != "")
		{
			echo "<ul>$err</ul>";
		}
		else
		{
			if($pic['name'] !="")
			{
				if($pic['type']=="image/jpg" || $pic['type']=="image/jpeg" || $pic['type']=="image/png" || $pic['type']=="image/git" )
				{
					if($pic['size']<= 614400)
					{
						$sq="SELECT * FROM product WHERE proid != '$id' and proname='$proname'";
						$result=pg_query($conn,$sq);
						if(pg_num_rows($result)==0)
						{
						copy($pic['tmp_name'], "product-imgs/".$pic['name']);
						$filePic = $pic['name'];

						$sqlstring="UPDATE product SET proname='$proname', price=$price, oldprice='$oldprice', smalldesc='$short',
						detaildesc='$detail', proqty=$qty, proimage='$filePic', catid='$category',
						prodate='".date('Y-m-d H:i:s')."', supid ='$supplier',branchid='$branch' WHERE proid='$id'";
						pg_query($conn,$sqlstring);
						echo '<meta http-equiv="refresh" content="0;URL=?page=product_management"/>';
						}
						else 
						{
							echo "<li>Duplicate productId or Name</li>";
						}
					}
					else 
					{
						echo "Size of image to big";
					}	
				}
				else 
				{
					echo "Image format is not correct";
				}
			}
			else
			{
				$sq="SELECT * FROM product where proid != '$id' and proname='$proname'";
				$result= pg_query($conn,$sq);
				if(pg_num_rows($result)==0)
				{	
					$sqlstring="UPDATE product SET proname='$proname', price=$price, oldprice='$oldprice', smalldesc='$short',
						detaildesc='$detail', proqty=$qty, catid='$category',
						prodate='".date('Y-m-d H:i:s')."', supid ='$supplier',branchid='$branch' WHERE proid='$id'";
						pg_query($conn,$sqlstring) or die("Error"); 

					pg_query($conn,$sqlstring);
					echo '<meta http-equiv="refresh" content="0;URL=?page=product_management"/>';
				}
				else 
				{	
					echo "<li>Duplicate productId or Name</li>";
				}
			}
		} 
	}
?>