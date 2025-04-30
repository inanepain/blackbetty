/**
 * ImageStripper
 *
 * This version uses the image page to gather the image links.
 *
 * @version 0.2.0
 *
 * copy the output and write to file:
 * `cb > config/autoload/image-stripper-data.local.php`
 */
links = [];
for (let name of Array.from(document.querySelectorAll('img'))) {
    if (name.src.includes('large')) {
        links.push(name.src);
    }
}
console.log("<?php\nreturn ['imagestripper'=>['images'=>['" + links.join("', '") + "']]];");

/**
 * ImageStripper
 *
 * This version uses the thumbnails gallary page to gather the image links.
 *
 * @version 0.3.0
 */
links = [];
document.querySelectorAll('a[data-fancybox="images"]').forEach(l => links.push(l.href));
console.log("<?php\nreturn ['imagestripper'=>['images'=>['" + links.join("', '") + "']]];");
