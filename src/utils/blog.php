<?php
namespace Utils;

function getBlogDesc($mdContent) {
  list($desc, $blog) = explode("\n\n", $mdContent, 2);

  $xml = new \SimpleXMLElement($desc);

  return array(
    "title" => (string)$xml->attributes()->title,
    "date" => new \DateTime((string)$xml->attributes()->publishedDate),
    "url" => (string)$xml->attributes()->url,
    "tags" => (string)$xml->attributes()->tags,
    "type" => (string)$xml->attributes()->type,
    "blurb" => (string)$xml
  );
}

?>
