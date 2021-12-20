<?php

// menghubungkan dengan connection.inc.php

include_once('connection.inc.php');
$connection_string = "host={$host} port={$port} dbname={$dbname} user={$user} password={$password} ";
$dbconn = pg_connect($connection_string) or die('Could not reach database.');

class Db_Class
{
    // Deklarasi nama table

    private $table_name = 'hotel';

    // Fungsi untuk create point sarana hotel
    function createPoint()
    {

        $lat = $_POST['lat'];
        $lng = $_POST['lng'];
        $id = $_POST['id'];
        $nama = $_POST['nama'];
        $jenis = $_POST['jenis'];
        $alamat = $_POST['alamat'];

        $sql = "insert into hotel (id, nama, jenis, alamat, lat, lng, geom) VALUES ('$id', '$nama', '$jenis', '$alamat', '$lat', '$lng', ST_GeomFromText('POINT($lng $lat)', 4326))";
        return pg_affected_rows(pg_query($sql));
    }

    // Fungsi untuk menampilkan seluruh isi table
    function getPoint()
    {
        $sql = "select *from public." . $this->table_name;
        return pg_query($sql);
    }

    // Fungsi untuk menampilkan data point berdasarkan id

    function getPointById()
    {

        $sql = "select *from public." . $this->table_name . "  where id='" . $this->cleanData($_POST['id']) . "'";
        return pg_query($sql);
    }

    // Fungsi untuk menghapus point sarana hotel
    function deletepoint()
    {

        $sql = "delete from public." . $this->table_name . "  where id='" . $this->cleanData($_POST['id']) . "'";
        return pg_query($sql);
    }

    // Fungsi untuk update data point sarana hotel
    function updatePoint($data = array())
    {

        $lat = $_POST['lat'];
        $lng = $_POST['lng'];

        $sql = "update hotel set id='" . $this->cleanData($_POST['id']) . "',nama='" . $this->cleanData($_POST['nama']) . "', jenis='" . $this->cleanData($_POST['jenis']) . "', lat='" . $this->cleanData($_POST['lat']) . "', lng='" . $this->cleanData($_POST['lng']) . "' ,geom= ST_GeomFromText('POINT($lng $lat)', 4326)  where id = '" . $this->cleanData($_POST['id']) . "' ";
        return pg_affected_rows(pg_query($sql));
    }
    function cleanData($val)
    {
        return pg_escape_string($val);
    }
}
