<?php


$path_dir = __DIR__ . '/../lib';

include $path_dir . '/database.php';

// select hoc sinh cua phu huynh
function studentOfParent($connection, $maph)
{
    $sql = "SELECT ph_hs.MaHS, hocsinh.TenHS, hocsinh.GioiTinh, hocsinh.NgaySinh, hocsinh.Tuoi, hocsinh.DiaChi, hocsinh.SDT, hocsinh.Email  FROM ph_hs INNER JOIN hocsinh WHERE ph_hs.MaHS =  hocsinh.MaHS AND ph_hs.MaPH = ?";
    try {
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement =  $connection->prepare($sql);
        $statement->execute([$maph]);

        $list  = $statement->fetchAll(PDO::FETCH_ASSOC);

        $connection = null;
        return $list;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
// // select danh sach lop 
function listDD($connection, $tt)
{
    $sql = "SELECT hs_lop.MaHS , hs_lop.MaLop , TenLop , LuaTuoi, ThoiGian,SLHS, SLHSToiDa,  SoBuoiDaToChuc, lop.HocPhi,SoBuoi,SoBuoiDaToChuc, SoBuoiNghi, GiamHocPhi FROM lop INNER JOIN hs_lop WHERE lop.MaLop =  hs_lop.MaLop and TrangThai = ?";
    try {
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement =  $connection->prepare($sql);
        $statement->execute([$tt]);

        $list  = $statement->fetchAll(PDO::FETCH_ASSOC);

        $connection = null;
        return $list;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}


function listDD_HD($connection)
{
    $a ="Đang mở";
    $b= "Chưa mở";
    $sql = 'SELECT hs_lop.MaHS , hs_lop.MaLop , TenLop , LuaTuoi, ThoiGian,SLHS, SLHSToiDa,  SoBuoiDaToChuc, lop.HocPhi,SoBuoi,SoBuoiDaToChuc, SoBuoiNghi, GiamHocPhi FROM lop INNER JOIN hs_lop WHERE lop.MaLop =  hs_lop.MaLop AND (TrangThai = ? or TrangThai = ?)';
    try {
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement =  $connection->prepare($sql);
     
        $statement->bindParam(1, $a);
        $statement->bindParam(2, $b);
        $statement->execute();

        $list  = $statement->fetchAll(PDO::FETCH_ASSOC);

        $connection = null;
        return $list;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}


function listNgayNghi($connection)
{
    $sql = 'SELECT MaLop , MaHS , ThoiGian   FROM diemdanh WHERE dd = "0"';
    try {
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement =  $connection->prepare($sql);
        $statement->execute();

        $list  = $statement->fetchAll(PDO::FETCH_ASSOC);

        $connection = null;
        return $list;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

//search HD
function searchHDHocPhi($connection, $key, $maph)
{
    $sql = "SELECT lop.HocPhi , hdhocphi.MaHS, MaHD, TenHD, hdhocphi.MaLop,  hdhocphi.ThoiGian, SoTien, GiamHocPhi, SoTienGiam, SoTienPhaiDong, SoTienDaDong, NoPhiConLai, hdhocphi.TrangThai, hocsinh.TenHS, hocsinh.GioiTinh, hocsinh.NgaySinh, hocsinh.Tuoi, hocsinh.DiaChi, hocsinh.SDT, hocsinh.Email FROM hdhocphi INNER JOIN hocsinh INNER JOIN ph_hs INNER JOIN lop WHERE hdhocphi.MaHS = hocsinh.MaHS AND hdhocphi.MaHS = ph_hs.MaHS and hdhocphi.MaLop= lop.MaLop AND ph_hs.MaPH = ? AND (MaHD LIKE ? OR TenHD LIKE ? OR hdhocphi.ThoiGian LIKE ? OR hdhocphi.TrangThai LIKE ? OR hocsinh.TenHS LIKE ? OR hdhocphi.MaLop LIKE ?) order by MaHD desc";
    try {
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement = $connection->prepare($sql);
        $statement->bindParam(1, $maph);
        $keyParam = "%$key%";
        $statement->bindParam(2, $keyParam);
        $statement->bindParam(3, $keyParam);
        $statement->bindParam(4, $keyParam);
        $statement->bindParam(5, $keyParam);
        $statement->bindParam(6, $keyParam);
        $statement->bindParam(7, $keyParam);
        $statement->execute();

        $list = $statement->fetchAll(PDO::FETCH_ASSOC);

        $connection = null;
        return $list;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

//select lsthp
function listLSTHP($connection)
{
    $sql = "select * from lsthp";
    try {
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement = $connection->prepare($sql);
        $statement->execute();

        $list = $statement->fetchAll(PDO::FETCH_ASSOC);

        $connection = null;
        return $list;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

// select ma hs 
function listMaHS($connection)
{
    $sql = "SELECT MaHS , TenHS FROM hocsinh;";
    try {
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement = $connection->prepare($sql);
        $statement->execute();

        $list = $statement->fetchAll(PDO::FETCH_ASSOC);

        $connection = null;
        return $list;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}




// insert yeucaulienket
function insertLienKet($mahs, $maph,$nyc, $connection)
{
    $sql = "insert into yeucaulienket(MaHS,MaPH,nyc) values(?,?,?)";
    try {
        $statement = $connection->prepare($sql);

        $statement->bindParam(1, $mahs);
        $statement->bindParam(2, $maph);
   
        $statement->bindParam(3, $nyc);
        $statement->execute();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

// // select ds lienket phuhuynh hoc sinh 
function selectdslk($connection, $magv)
{

    $sql = 'SELECT yeucaulienket.MaHS,yeucaulienket.MaPH, TenHS,TenPH  FROM yeucaulienket , hocsinh , phuhuynh WHERE yeucaulienket.MaHS = hocsinh.MaHS and yeucaulienket.MaPH =  phuhuynh.MaPH and  nyc = "hs" and  yeucaulienket.MaPH = ? ';

    try {
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement =  $connection->prepare($sql);
        $statement->bindParam(1, $magv);
        $statement->execute();

        $list = $statement->fetchAll(PDO::FETCH_ASSOC);

        $connection = null;
        return $list;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

// // delêt ds lienket phuhuynh hoc sinh 
function deletedslk($connection, $mahs , $maph)
{

    $sql = 'DELETE FROM yeucaulienket WHERE MaHS = ? and MaPH =?';

    try {
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement =  $connection->prepare($sql);
        $statement->bindParam(1, $mahs);
        $statement->bindParam(2, $maph);
        $statement->execute();

        $list = $statement->fetchAll(PDO::FETCH_ASSOC);

        $connection = null;
        return $list;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

// insert ph-hs
function insertPHHS($Mahs, $Maph, $connection)
{
    $sql = "insert into ph_hs values(?,?)";
    try {
        $statement = $connection->prepare($sql);
        $statement->bindParam(1, $Mahs);
        $statement->bindParam(2, $Maph);
        $statement->execute();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}



function selectParent($connection,$ma){
    $sql = "select * from phuhuynh where MaPH = ?";
    try{
        $connection -> setAttribute(PDO:: ATTR_ERRMODE, PDO:: ERRMODE_EXCEPTION);
        $statement =  $connection->prepare($sql);
        $statement-> execute([$ma]);

        $listClass  = $statement-> fetchAll(PDO:: FETCH_ASSOC);

        $connection = null;
        return $listClass;
    } catch (PDOException $e){
        echo $e->getMessage();
    }
}










function listSchedules($connection)
{
    $sql = "SELECT lop_lichhoc.MaLich ,lop_lichhoc.MaLop ,lichhoc.Ngay , lichhoc.TGBatDau, lichhoc.TGKetThuc FROM lop_lichhoc INNER JOIN lichhoc WHERE lop_lichhoc.MaLich = lichhoc.MaLich;";
    try {
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement =  $connection->prepare($sql);

        $statement->execute();

        $list  = $statement->fetchAll(PDO::FETCH_ASSOC);

        $connection = null;
        return $list;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}





// // select tenPh
function selectTenPH($connection, $magv)
{

    $sql = "SELECT  TenPH FROM phuhuynh WHERE MaPH = ?";

    try {
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement =  $connection->prepare($sql);
        $statement->bindParam(1, $magv);
        $statement->execute();

        $list = $statement->fetchAll(PDO::FETCH_ASSOC);

        $connection = null;
        return $list;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}