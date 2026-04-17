<?php
namespace Utils;

include('./vendor/parsedown/Parsedown.php');
include('./vendor/spyc/Spyc.php');

function getBlog($mdContent) {
  preg_match('/^---\n(.*?)\n---\n?(.*)/s', $mdContent, $matches);
  $meta = \Spyc::YAMLLoadString($matches[1]);
  $body = trim($matches[2] ?? '');

  $Parsedown = new \Parsedown();
  $externalUrl = $meta['external_url'] ?? '';

  return array(
    "title"        => $meta['title'],
    "date"         => new \DateTime((string)$meta['date']),
    "url"          => $externalUrl,
    "tags"         => $meta['tags'] ?? [],
    "type"         => $meta['type'] ?? '',
    "isExternal"   => !empty($externalUrl),
    "externalSite" => $meta['external_site'] ?? '',
    "blurb"        => $Parsedown->text($meta['description'] ?? ''),
    "content"      => $Parsedown->text($body),
  );
}

function sortingFunc($a, $b) {
  return $b['date']->getTimestamp() <=> $a['date']->getTimestamp();
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
    $blog['href'] = $blog['isExternal'] ? $blog['url'] : '/blogs/' . $blog['filename'];

    $blogs[] = $blog;
  }

  usort($blogs, "Utils\sortingFunc");

  return $blogs;
}

?>
