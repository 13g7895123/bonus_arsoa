<!DOCTYPE html>
<html>
<head>
<meta content="width=device-width, initial-scale=1.0" name="viewport">
<meta charset="utf-8">
<title><?=$pdf_title?></title>
<style>
   h1 {
    color: black;
    font-family: Microsoft JhengHei;
    font-size: 1.75em;
	  text-align: center;
    text-decoration: underline;
  }
	
	h2 {
    color: black;
    font-family: Microsoft JhengHei;
    font-size: 1.25em;
	  text-align: left;
  }
	h2 > span {
		font-size: 0.75em;
		text-align: right;
	}
	
	p.centerlogo {
    text-align: center;
		margin-top: 30px;
  }
	.centerlogo img {
		width: 125px;
	}

  table {
    text-align: left;
  }
  
.tableb,.tableb th, .tableb td {
  border: 1px solid black;
  border-collapse: collapse;
}
	
  div.box1 {
    background-color: #cccccc;
    font-family: Microsoft JhengHei;
    font-size: 1em;
    border-top: 1px solid #333333;
		border-bottom: 1px solid #333333;
		text-align: center;
    }
	div.box2 {
    font-family: Microsoft JhengHei;
    font-size: 1em;
		border-top: 1px solid #333333;
		border-bottom: 1px solid #333333;
		text-align: center;
    }
</style>
<body>
<p></p>
<p class="centerlogo">
	<img src="<?=$logo?>">
</p>
<h1 class="title"><?=$pdf_name?></h1>
<?=$html?>
</body>
</html>