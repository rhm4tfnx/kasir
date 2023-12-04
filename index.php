<!-- 
    KASIR 
    pertama itu kasir akan menampilkan rekomendasi barang yang sedang diskon
    user dapat memasukkan input barang yang akan di beli 
    terus kasir nya akan menghitung jumlah total belanja dan menampilkan analisis hasil penjualan dan barang yang terlaris
    menampilkan barang yang sedang sedikit stock nya dan mengingatkan untukk di restock 
-->
<?php 
    require "functions.php";
    $datas = query("SELECT * FROM products");


    // search section 
    if(isset($_POST["cari"])){
        $searchResult = search($_POST["search"]);
    }

    // bagian checkout nya
    if(isset($_POST['checkout'])){
        if(!addToCheckOut($_POST) > 0){
            echo "<script>
                alert('HMM SOMETHING WRONG !');
            </script>";
        }
    }

    // ketika pesan di klik 

    // tangkap datanya
    // database kita hapus semua datanya 

    // 


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Final Kecerdasan Buatan</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="header">
        <a href=""><i class="fa-solid fa-shop"></i>Cashier</a>

        <div class="navbar">
            <a href="#home">home</a>
            <a href="#products">products</a>
            <a href="#kasir">kasir</a>
        </div>

        <div class="icons">
            <div class="fas fa-user"></div>
            <div class="fas fa-cart-shopping"></div>
        </div>
    </div>
    <section class="products" id="products">
        <h1 class="heading"><span>dicounts</span> Products </h1>
        <div class="box-container">
            <?php foreach($datas as $data) : ?>
                <?php if($data['discount'] > 0) : ?>
                <div class="box">
                    <img src="img/<?= $data['gambar']; ?>" alt="" height="200" width="200">
                    <h4><?= $data['nama']; ?></h4>
                    <div class="action">
                        <p class="discount"><?= $data['discount']; ?>% <span>OFF</span></p>
                        <p class="qty"><?= $data['jumlah']; ?> <span>pcs</span></p>
                    </div>
                    <div class="content">
                        <p class="price">Rp.<?= $data['harga']; ?></p>
                        <p class="soldout"><?= $data['terjual']; ?> <span>terjual</span></p>
                    </div>
                    <form action="" method="post">
                        <button type="submit" class="btn" name="checkout">checkout</button>
                        <input type="hidden" name="nama" value="<?= $data['nama']; ?>">
                        <input type="hidden" name="gambar" value="<?= $data['gambar']; ?>">
                        <input type="hidden" name="harga" value="<?= $data['harga'];?>">
                    </form>
                    <?php if($data['jumlah'] < 10) : ?>
                    <div class="restock">
                        <p>restock asap</p>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </section>
    <section class="search" id="search">
        <h1 class="heading">cari barang</h1>
        <div class="container">
            <form action="" method="post">
                <input type="search" name="search" placeholder="cari barang" id="search" required>
                <button type="submit" class="btn" name="cari">Cari Data</button>
            </form>
            <h1>RESULT</h1>
            <div class="box-container">
            <?php if(isset($_POST["cari"])) : ?>
                <?php foreach($searchResult as $rest): ?>
                    <div class="box">
                        <img src="img/<?= $rest['gambar']; ?>" alt="" height="200" width="200">
                        <h4><?= $rest['nama']; ?></h4>
                        <div class="action">
                            <p class="discount"><?= $rest['discount']; ?>% <span>OFF</span></p>
                            <p class="qty"><?= $rest['jumlah']; ?> <span>pcs</span></p>
                        </div>
                        <div class="content">
                            <p class="price">Rp.<?= $rest['harga']; ?></p>
                            <p class="soldout"><?= $rest['terjual']; ?> <span>terjual</span></p>
                        </div>
                        <form action="" method="post">
                            <button type="submit" class="btn" name="checkout">checkout</button>
                            <input type="hidden" name="gambar" value="<?= $rest['gambar'];?>">
                            <input type="hidden" name="harga" value="<?= $rest['harga'];?>">
                        </form>
                        <?php if($rest['jumlah'] < 10) : ?>
                        <div class="restock">
                            <p>restock asap</p>
                        </div>
                        <?php endif; ?>
                    </div>  
                <?php endforeach; ?>
            <?php endif; ?>
            </div>
        </div>
    </section>
    <section class="kasir" id="kasir">
        <h1 class="heading">kasir</h1>
        <div class="box-container">
            <table>
                <tr>
                    <th>nama</th>
                    <th>gambar</th>
                    <th>jumlah</th>
                    <th>harga</th>
                    <th>hapus</th>
                </tr>
                <!-- start while here  -->
                <?php 
                    // disini lakukan query dari database checkout
                    $checkouts = query("SELECT * FROM checkout");
                    // var_dump($checkout);
                ?>
                <?php $total = 0; ?>
                <?php foreach($checkouts as $checkout): ?>
                <tr>
                    <td><?= $checkout['nama'];?></td>
                    <td><img src="img/<?= $checkout['gambar'];?>" alt="" height="50" width="50"></td>
                    <td>1</td>
                    <td>Rp<?= $checkout['harga'];?></td>
                    <td><a href="deleteCo.php?id=<?= $checkout['id'];?>" class="fa-solid fa-trash"></a></td>
                </tr>
                <?php $total += $checkout['harga']; ?>

                <!-- hidden form yang akan di masukkan ke dalam database soldout  -->
                <form action="" method="post">
                    <input type="hidden" name="jumlah" >
                </form>

                <?php endforeach; ?>
                <!-- end of foreach  -->
                <tr>
                    <td></td>
                    <td></td>
                    <td class="total">Total Pembayaran: Rp.<?= $total; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <form action="" method="post">
                        <td><button type="submit" class="btn" name="pesan">bayar sekarang</button></td>
                    </form>
                </tr>
            </table>
        </div>
    </section>
    <section class="data">
        <h1 class="heading">Data Penjualan</h1>
        <div class="box-container">
            <table>
                <tr>
                    <th>Product Terjual</th>
                    <th>Jumlah Total Penghasilan</th>
                </tr>
                <?php
                if(isset($_POST['pesan'])){

                    // mengambil data terakhir dari database
                    $lastIndex = query("SELECT * FROM soldout");
                    $dataDatabase = intval(end($lastIndex)['terjual']);
                    $dataCheckout = intval(query("SELECT COUNT(*) FROM checkout")[0]["COUNT(*)"]);  // data checkout 2;
                    
                    
                    $dataPenghasilanDatabase = intval(end($lastIndex)['totalPenghasilan']);

                    //total terjual
                    $totalTerjual = strval($dataCheckout + $dataDatabase);
                    $totalPenghasilan = strval($dataPenghasilanDatabase + $total);
                    

                    mysqli_query($conn,"INSERT INTO soldout VALUES('','$totalTerjual','$totalPenghasilan')");
                    if(mysqli_affected_rows($conn) == 0){
                        echo "<script>
                            alert('HMM SOMETHING WRONG !');
                        </script>";
                    }
                    
                    
                    // 
                    // kita hapus semua database checkout nya 
                    
                    mysqli_query($conn,"DELETE FROM checkout");
                    if(mysqli_affected_rows($conn) == 0){
                        echo "<script>B
                            alert('HMM SOMETHING WRONG !');
                        </script>";
                    }else{
                        echo "<script>
                            alert('Pembayaran Sukses');
                            document.location.href = 'index.php';
                        </script>";

                    }

                }
                ?>
                <tr>
                    <?php 
                        $lastIndexSoldOut = query("SELECT * FROM soldout");
                        $restTotalPenghasil = end($lastIndexSoldOut)['totalPenghasilan'];
                        $restTotalTerjual = end($lastIndexSoldOut)['terjual'];
                    ?>
                    <td><?= $restTotalTerjual; ?></td>
                    <td><?= $restTotalPenghasil; ?></td>    
                </tr>
                <?php 
                

                ?>
            </table>
        </div>
    </section>
</body>
</html>