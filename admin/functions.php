<?php
include('simple_html_dom.php');

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

function scrape_data($url, $site)
{
  $html = file_get_html($url);

  switch ($site) {
    case 'kompas':
      $titleDiv = $html->find('div.col-bs10-10', 0);
      if ($titleDiv) {
        $titleElement = $titleDiv->find('h1.read__title', 0);
        $title = $titleElement->plaintext;
      }

      $authorDiv = $html->find('div.credit-title-name', 0);
      if ($authorDiv) {
        $authorElement = $authorDiv->find('h6', 0);
        $author = $authorElement->plaintext;
      }

      $bodyDiv = $html->find('div.read__content', 0);
      if ($bodyDiv) {
        $paragraphs = $bodyDiv->find('p');
        $allTexts = [];
        foreach ($paragraphs as $p) {
          if (!$p->class) {
            $allTexts[] = $p->plaintext;
          }
        }
        $body = implode("\n", $allTexts);
      }
      break;

    case 'one':
      $titleDiv = $html->find('div.col-lg-8', 0);
      if ($titleDiv) {
        $titleElement = $titleDiv->find('h1.post-title', 0);
        $title = $titleElement->plaintext;
      }

      $authorDiv = $html->find('div.col-lg-8', 0);
      if ($authorDiv) {
        $authorElement = $authorDiv->find('a.author', 0);
        $author = $authorElement->plaintext;
      }

      $bodyDiv = $html->find('div.post-content', 0);
      if ($bodyDiv) {
        $paragraphs = $bodyDiv->find('p');
        $allTexts = [];
        foreach ($paragraphs as $p) {
          if (!$p->class) {
            $allTexts[] = $p->plaintext;
          }
        }
        $body = implode("\n", $allTexts);
      }
      break;

    default:
      return ['title' => 'Unknown site', 'author' => 'Unknown', 'body' => ''];
  }

  return [
    'title' => $title,
    'author' => $author,
    'body' => $body
  ];
}

// Posts
function add_posts($data)
{
  $conn = koneksi();

  $title = mysqli_real_escape_string($conn, htmlspecialchars($data['title']));
  $body = mysqli_real_escape_string($conn, htmlspecialchars($data['body']));
  $author = mysqli_real_escape_string($conn, htmlspecialchars($data['author']));

  $query = "INSERT INTO posts
              VALUES
              ('', '$title', '', '', '', '$body', '', '$author')";

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
function delete_category($id)
{
  $conn = koneksi();

  mysqli_query($conn, "DELETE FROM category WHERE id = $id");
  return mysqli_affected_rows($conn);
}

// Author
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

  $query_tambah = "INSERT INTO user VALUES('', '$username', '$password', '')";
  mysqli_query($conn, $query_tambah);

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
