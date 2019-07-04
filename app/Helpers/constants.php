<?php 
function getDevice()
{
    if(Browser::isMobile()) {
        return MOBILE;
    } else if(Browser::isTablet()) {
        return TABLET;
    } else if(Browser::isDesktop()) {
        return DESKTOP;
    } else {
        return BOTS;
    }
}
// function trimRequest($request)
// {
//     $input = $request->all();
//     // use a closure here because array_walk_recursive passes
//     // two params to the callback, the item + the key. If you were to just
//     // call trim directly, you could end up inadvertently trimming things off
//     // your array values, and pulling your hair out to figure out why.
//     array_walk_recursive($input, function(&$in) {
//         $in = trim($in);
//     });
//     $request->merge($input);
// }
// device
define('MOBILE', 1);
define('DESKTOP', 2);
define('TABLET', 3);
define('BOTS', 4);
// cache: 1: cache, 2: non cache
define('CACHE', 1);
// cookie name
define('COOKIE_NAME', 'clients');
// lang
define('LANG1', 'vi');
define('LANG2', 'en');
// pagination
define('PAGINATION', 50);
define('PAGINATE', 20);
define('PAGINATEBOX', 10);
// replace string
define('CONTACTFORM', '/%ContactForm%/');
// responsive filemanager
define('AKEY', 'db0ac2431a2e87c54852dbb0e7b9ed3d');
// watermark base64 code
define('WATERMARK_BASE64', 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAALAAAAAcCAYAAADBaTXLAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyJpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6MzdFREIxODc3N0FDMTFFN0FBREU5MjVDOTc5QkJCRDgiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6MzdFREIxODY3N0FDMTFFN0FBREU5MjVDOTc5QkJCRDgiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoV2luZG93cykiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDpBRkQwNTFEMzVFMjgxMUU3QTRBRkE0OUFFQjYxQTVBRCIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDpBRkQwNTFENDVFMjgxMUU3QTRBRkE0OUFFQjYxQTVBRCIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/Psz+T3IAAABRSURBVHja7NIBDQAACMMwwL/nowPSSljWSQquGgkwMBgYDIyBwcBgYDAwBgYDg4HBwBgYDAwGxsBgYDAwGBgDg4HBwGBgDAwGBgODgfliBRgAMN8DNVVEe+EAAAAASUVORK5CYII=');
// size
define('DIMENSIONS', '360x360 / 250x250 / 80x80');
define('SIZE_WIDTH', 360);
define('SIZE_HEIGHT', 360);
define('SIZE_WIDTH_2', 250);
define('SIZE_HEIGHT_2', 250);
define('SIZE_WIDTH_3', 80);
define('SIZE_HEIGHT_3', 80);
// DEFAULT IMAGE
define('DEFAULT_AVATAR', '/images/logo/apple-touch-icon.png');
