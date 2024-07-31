<?php
// Kelompok 2 - 2DAYNEWS
// Final Project

function koneksi()
{
    $conn = mysqli_connect("localhost", "root", "");
    mysqli_select_db($conn, "berita");

    return $conn;
}

function query($sql)
{
    $conn = koneksi();
    $result = mysqli_query($conn, "$sql");
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function upload()
{
    $nama_file = $_FILES['gambar']['name'];
    $tipe_file = $_FILES['gambar']['type'];
    $ukuran_file = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmp_file = $_FILES['gambar']['tmp_name'];

    if ($error == 4) {
        return 'nophoto.jpg';
    }

    $daftar_gambar = ['jpg', 'jpeg', 'png'];
    $ekstensi_file = explode('.', $nama_file);
    $ekstensi_file = strtolower(end($ekstensi_file));
    if (!in_array($ekstensi_file, $daftar_gambar)) {
        echo "<script>
            alert('Yang anda pilih bukan gambar!');
          </script>";
        return false;
    }

    if ($tipe_file != 'image/jpeg' && $tipe_file != 'image/png') {
        echo "<script>
                alert('Yang anda pilih bukan gambar!');
              </script>";
        return false;
    }

    if ($ukuran_file > 5000000) {
        echo "<script>
                alert('Ukuran terlalu besar!');
              </script>";
        return false;
    }

    $nama_file_baru = uniqid();
    $nama_file_baru .= '.';
    $nama_file_baru .= $ekstensi_file;
    move_uploaded_file($tmp_file, '../../img/' . $nama_file_baru);

    return $nama_file_baru;
}

// Posts
function add_posts($data)
{
    $conn = koneksi();

    $judul = htmlspecialchars($data['judul']);
    $body = htmlspecialchars($data['body']);
    $publish = htmlspecialchars($data['publish']);
    $category_id = htmlspecialchars($data['category_id']);
    $author_id = htmlspecialchars($data['author_id']);
    // $img = htmlspecialchars($data['img']);

    $img = upload();
    if (!$img) {
        return false;
    }

    $query = "INSERT INTO posts
              VALUES
            ('', '$judul', '$img', '$body', '$publish', '$category_id', '$author_id')";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function update_posts($data)
{
    $conn = koneksi();
    $id = ($data['id']);
    $judul = htmlspecialchars($data['judul']);
    $body = htmlspecialchars($data['body']);
    $publish = htmlspecialchars($data['publish']);
    $category_id = htmlspecialchars($data['category_id']);
    $author_id = htmlspecialchars($data['author_id']);
    $gambar_lama = htmlspecialchars($data['gambar_lama']);

    $img = upload();
    if (!$img) {
        return false;
    }

    if ($img == 'nophoto.jpg') {
        $img = $gambar_lama;
    }

    $query = "UPDATE posts SET
                judul = '$judul',
                body = '$body',
                publish = '$publish',
                category_id = '$category_id',
                author_id = '$author_id',
                img = '$img'
                WHERE id = '$id'
                ";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function delete_posts($id)
{
    $conn = koneksi();

    mysqli_query($conn, "DELETE FROM posts WHERE id = $id");
    return mysqli_affected_rows($conn);
}

// Category
function add_category($data)
{
    $conn = koneksi();

    $nama_category = htmlspecialchars($data['nama_category']);

    $query = "INSERT INTO category
              VALUES
            ('', '$nama_category')";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function update_category($data)
{
    $conn = koneksi();

    $id = ($data['id']);
    $nama_category = htmlspecialchars($data['nama_category']);

    $query = "UPDATE category SET
                nama_category = '$nama_category'
                WHERE id = '$id'
                ";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function delete_category($id)
{
    $conn = koneksi();

    mysqli_query($conn, "DELETE FROM category WHERE id = $id");
    return mysqli_affected_rows($conn);
}

// Author
function add_author($data)
{
    $conn = koneksi();

    $nama_author = htmlspecialchars($data['nama_author']);

    $query = "INSERT INTO author
              VALUES
            ('', '$nama_author')";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function update_author($data)
{
    $conn = koneksi();

    $id = ($data['id']);
    $nama_author = htmlspecialchars($data['nama_author']);

    $query = "UPDATE author SET
                nama_author = '$nama_author'
                WHERE id = '$id'
                ";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function delete_author($id)
{
    $conn = koneksi();

    mysqli_query($conn, "DELETE FROM author WHERE id = $id");
    return mysqli_affected_rows($conn);
}

// Comment
function add_comment($data)
{
    $conn = koneksi();

    $parent_id = htmlspecialchars($data['parent_id']);
    $comment = htmlspecialchars($data['comment']);
    $tanggal = htmlspecialchars($data['tanggal']);
    $user_id = htmlspecialchars($data['user_id']);
    $post_id = htmlspecialchars($data['post_id']);


    $query = "INSERT INTO comment
              VALUES
            ('', '$parent_id', '$comment','$tanggal','$user_id','$post_id')";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function delete_comment($id)
{
    $conn = koneksi();

    mysqli_query($conn, "DELETE FROM comment WHERE id = $id");
    return mysqli_affected_rows($conn);
}

// Sign Up
function signup($data)
{
    $conn = koneksi();
    $username = strtolower(stripcslashes($data["username"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);

    $result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");
    if (mysqli_fetch_assoc($result)) {
        echo "<script>
                alert('Username sudah digunakan');
              </script>";
        return false;
    }

    $password = password_hash($password, PASSWORD_DEFAULT);

    $query_tambah = "INSERT INTO user VALUES('', '$username', '$password', 'user')";
    mysqli_query($conn, $query_tambah);

    return mysqli_affected_rows($conn);
}

// Forgot Password
function forgot($data)
{
    $conn = koneksi();
    $username = strtolower(stripcslashes($data["username"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);


    $password = password_hash($password, PASSWORD_DEFAULT);

    $query_forgot = "UPDATE user SET
                     password = '$password'
                     WHERE username = '$username'";
    mysqli_query($conn, $query_forgot);

    return mysqli_affected_rows($conn);
}

// Searching
function cari($keyword)
{
    $query = "SELECT posts.id, judul, img, view, body, publish, nama_category, nama_author FROM posts
                JOIN category ON posts.category_id = category.id
                JOIN author ON posts.author_id = author.id
                WHERE
                judul LIKE '%$keyword%' OR
                publish LIKE '%$keyword%' OR
                nama_category LIKE '$keyword' OR
                nama_author LIKE '%$keyword%'
                ";
    return query($query);
}

function cariCategory($keyword, $nama_category)
{
    $query = "SELECT posts.id, judul, img, view, body, publish, nama_category, nama_author FROM posts
                JOIN category ON posts.category_id = category.id
                JOIN author ON posts.author_id = author.id
                WHERE
                (judul LIKE '%$keyword%' OR
                publish LIKE '%$keyword%' OR
                nama_author LIKE '%$keyword%') AND
                nama_category = '$nama_category'
                ";
    return query($query);
}

function tambahViews($id)
{
    $conn = koneksi();
    $posts = query("SELECT view FROM posts WHERE posts.id = $id")[0];
    $viewer = $viewer = $posts['view'];
    $viewer++;

    $query = "UPDATE posts SET view = $viewer WHERE id = $id";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}