<?php
/**
 * Compact PHP code.
 *
 * Strip comments, combine entire library into one file.
 */

if ($argc < 3) {
  print "Strip unecessary data from PHP source files.\n\n\tUsage: php compactor.php DESTINATION.php SOURCE.php";
  exit;
}


$source = $argv[2];
$target = $argv[1];
print "Compacting " . htmlspecialchars($source, ENT_QUOTES, 'UTF-8') . " into " . htmlspecialchars($target, ENT_QUOTES, 'UTF-8') . ".\n";

include $source;

$files = get_included_files();
print_r($files);

$out = fopen($target, 'w');
if (is_resource($out)) {
    // Проверка что дескриптор безопасный и файл открыт во временной/разрешённой директории
    $meta = stream_get_meta_data($out);
    $allowedDirs = ['/var/www/app/tmp', '/var/www/app/generated']; // примеры разрешённых директорий

    foreach ($allowedDirs as $dir) {
        if (strpos(realpath($meta['uri']), realpath($dir)) === 0) {
            fwrite($out, '<?php' . PHP_EOL);
            break;
        }
    }
}
if (is_resource($out)) {
    $meta = stream_get_meta_data($out);
    $allowedDirs = ['/var/www/app/tmp', '/var/www/app/generated']; // допустимые директории

    foreach ($allowedDirs as $dir) {
        if (strpos(realpath($meta['uri']), realpath($dir)) === 0) {
            fwrite($out, '// QueryPath. Copyright (c) 2009, Matt Butcher.' . PHP_EOL);
            break;
        }
    }
}
if (is_resource($out)) {
    $meta = stream_get_meta_data($out);
    $allowedDirs = ['/var/www/app/tmp', '/var/www/app/generated']; // допустимые директории

    foreach ($allowedDirs as $dir) {
        if (strpos(realpath($meta['uri']), realpath($dir)) === 0) {
            fwrite($out, '// This software is released under the LGPL, v. 2.1 or an MIT-style license.' . PHP_EOL);
            break;
        }
    }
}
if (is_resource($out)) {
    $meta = stream_get_meta_data($out);
    $allowedDirs = ['/var/www/app/tmp', '/var/www/app/generated']; // допустимые директории

    foreach ($allowedDirs as $dir) {
        if (strpos(realpath($meta['uri']), realpath($dir)) === 0) {
            fwrite($out, '// http://opensource.org/licenses/lgpl-2.1.php');
            break;
        }
    }
}
if (is_resource($out)) {
    $meta = stream_get_meta_data($out);
    $allowedDirs = ['/var/www/app/tmp', '/var/www/app/generated']; // допустимые директории

    foreach ($allowedDirs as $dir) {
        if (strpos(realpath($meta['uri']), realpath($dir)) === 0) {
            fwrite($out, '// http://querypath.org.' . PHP_EOL);
            break;
        }
    }
}
foreach ($files as $f) {
  if ($f !== __FILE__) {
    $contents = file_get_contents($f);
    foreach (token_get_all($contents) as $token) {
      if (is_string($token)) {
          if (is_resource($out)) {
              $meta = stream_get_meta_data($out);
              $allowedDirs = ['/var/www/app/tmp', '/var/www/app/generated']; // допустимые директории

              foreach ($allowedDirs as $dir) {
                  if (strpos(realpath($meta['uri']), realpath($dir)) === 0) {
                      // Валидация содержимого переменной $token
                      if (is_string($token) && mb_check_encoding($token, 'UTF-8')) {
                          fwrite($out, $token);
                      }
                      break;
                  }
              }
          }
      }
      else {
          switch ($token[0]) {
              case T_REQUIRE:
              case T_REQUIRE_ONCE:
              case T_INCLUDE_ONCE:
              case T_COMMENT:
              case T_DOC_COMMENT:
              case T_OPEN_TAG:
              case T_CLOSE_TAG:
                  echo htmlspecialchars("?", ENT_QUOTES, 'UTF-8'); // безопасный вывод
                  break;
          case T_WHITESPACE:
              if (is_resource($out)) {
                  $meta = stream_get_meta_data($out);
                  $allowedDirs = ['/var/www/app/tmp', '/var/www/app/generated']; // допустимые директории

                  foreach ($allowedDirs as $dir) {
                      if (strpos(realpath($meta['uri']), realpath($dir)) === 0) {
                          fwrite($out, ' ');
                          break;
                      }
                  }
              }
            break;
          default:
              if (is_resource($out)) {
                  $meta = stream_get_meta_data($out);
                  $allowedDirs = ['/var/www/app/tmp', '/var/www/app/generated']; // допустимые директории

                  foreach ($allowedDirs as $dir) {
                      if (strpos(realpath($meta['uri']), realpath($dir)) === 0) {
                          // Валидация содержимого
                          if (isset($token[1]) && is_string($token[1]) && mb_check_encoding($token[1], 'UTF-8')) {
                              fwrite($out, $token[1]);
                          }
                          break;
                      }
                  }
              }
        }
        
      }
    }
  }
}
if (is_resource($out)) {
    fclose($out);
}
?>