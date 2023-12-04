<?php 

    $conn = mysqli_connect("127.0.0.1","root","","ai");
    function query($query){
        global $conn;
        $query = mysqli_query($conn,$query);
        $data = [];
        while($result = mysqli_fetch_assoc($query)){
            $data[] = $result;
        }
        return $data;
    }


    function search($keyword){

        $query = "SELECT * FROM products WHERE nama LIKE '%$keyword%' ";
        $result = query($query);
        return $result;
    }

    // kasir logic nya

    // kita ambil id product nya 
    function addToCheckOut($data){
        global $conn;
        $gambar = $data['gambar'];
        $nama = $data['nama'];
        $harga = $data['harga'];

        // kita masukkan data yang tadi ke dalam database keranajng
        $query = mysqli_query($conn,"INSERT INTO checkout VALUES('','$gambar','$nama','$harga')");
        return mysqli_affected_rows($conn);
    }

    // function soldout($data){
    //     // hitung jumlah 
    // }

?>  