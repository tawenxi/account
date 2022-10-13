<!DOCTYPE html>
<html>
<head>
	<title>ss</title>
</head>
<body>

    <div>
        <h1>Hello World</h1>
    </div>

</body>

<script>
    xmlhttp = new XMLHttpRequest();
xmlhttp.open("HEAD", document.URL ,true);
xmlhttp.onreadystatechange=function() {
if (xmlhttp.readyState==4) {
  console.log(xmlhttp.getResponseHeader('connection'));
  }
}
xmlhttp.send();



</script>
</html>