<!DOCTYPE html>
<html>
<head>
  <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
  <script>tinymce.init({ selector:'textarea' });</script>
  <link rel="stylesheet" type="text/css" href="/admin/dropzone.css">

</head>
<body>
	{% for item in l3 %}
		{{item.content}}
	{% endfor %}
<div class="image_upload_div">
  <form action="/root/image" class="dropzone">
    </form>
</div>
  <textarea>Easy! You should check out MoxieManager!</textarea>
  <a class="saveAjax btn btn-primary">Save</a>
  <script   src="https://code.jquery.com/jquery-3.1.1.min.js"   integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="   crossorigin="anonymous"></script>
  <script src="/admin/ajax.js"></script>
  <script type="text/javascript" src="/admin/dropzone.js"></script>
</body>
</html>