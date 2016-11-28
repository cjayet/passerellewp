#Ajaxloader 1.5.1

Ajaxloader jquery plugin for show preload image on dynamic loading content

Ajaxloader plugin for jquery.

#Usage

Easy using for show preload image.

Link javascript and stylesheet file:

    <link href="ajaxloader/ajaxloader.css" type="text/css" rel="stylesheet" />
    <script src="jquery.ajaxloader.js" type="text/javascript"></script>
    
And just call method for some content:

    $('#some-content').ajaxloader()
    
If you need other preload image, you can generated on site [http://preloaders.net or others](http://preloaders.net or others).

Example code:
```
<script type="text/javascript"> $(function(){
 $('#some-button').click(function(){
  $('#some-content').ajaxloader();
  $.load('load.html');
 });
 $('#show-button').click(function(){
  $('#some-content').ajaxloader();
 });
 $('#hide-button').click(function(){
  $('#some-content').ajaxloader('hide');
 });
});
</script>

<button id='show-button'>Show preload images</button>
<button id='hide-button'>Hide preload images</button>
<button id='some-button'>Load content</button>

<div id='some-content'>
  This place some content for reloading<br/>
  Ajaxloader can work with any tag: p,div e.t.c
  All content disabled if show preload images
  <button>Button for test</button>
</div>
```

#License

Copyright (c) 2010 Blokhin Yuriy (ds@inbox.ru) Dual licensed under the MIT and GPL licenses: http://www.opensource.org/licenses/mit-license.php http://www.gnu.org/licenses/gpl.html
