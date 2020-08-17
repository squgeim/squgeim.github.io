<?php
namespace Utils;

include('./vendor/parsedown/Parsedown.php');

function getBlog($mdContent) {
  list($desc, $blog) = explode("\n\n\n", $mdContent, 2);

  $xml = new \SimpleXMLElement($desc);

  $Parsedown = new \Parsedown();

  return array(
    "title" => (string)$xml->attributes()->title,
    "date" => new \DateTime((string)$xml->attributes()->publishedDate),
    "url" => (string)$xml->attributes()->url,
    "tags" => (string)$xml->attributes()->tags,
    "type" => (string)$xml->attributes()->type,
    "blurb" => $Parsedown->text((string)$xml),
    "content" => $Parsedown->text($blog)
  );
}

function sortingFunc($a, $b) {
  return $a['date'] < $b['date'];
}

function getBlogsList() {
  $filesInDir = scandir('./src/content');
  $blogs = [];

  foreach ($filesInDir as $filename) {
    if (substr($filename, -3) != '.md') {
      continue;
    }

    $blog = getBlog(file_get_contents('./src/content/' . $filename));
    $blog['filename'] = substr($filename, 0, strrpos($filename, '.', -1)) . '.html';

    $blogs[] = $blog;
  }

  usort($blogs, "Utils\sortingFunc");

  return $blogs;
}

?>
