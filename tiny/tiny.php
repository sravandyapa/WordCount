<html>
<head>
<title>Online PHP Script Execution</title>

<style>
	hr
	{
		border-color:red;
	}
	h1
	{
		font-size:70px;text-shadow:15px 15px 10px grey;
	}
	.name
	{
		margin-top:7%;
		margin-left:5%;
		border-width:2px;
		width:25%;
		height:5%;
	}
	.ch
	{
		margin-top:2%;
		margin-left:4%;
		width:3%;
		height:3%;
	}
	.sub
	{
		margin-top:3%;
		margin-left:15%;
		border-width:2px;
		width:%;
		height:5%;
	}
	div
	{
		margin-top:3%;
		margin-left:15%;
	}
</style>
	

</head>
<body>
<h1 align="center">Terribly Tiny Tales Online Test</h1>
<hr>
    
    <form action="tiny.php" method="post">
        
        <b>Word Count </b><input class="name" name="pattern" type="number" value="enter"></br>
		<b>Case-Insensitive</b> <input class="ch" type="checkbox" name="case_sensitive"></br>
        <input class="sub" type="submit" value="Check">
        
    </form>
    
<?php

	error_reporting(0);

	function curl_get_contents($url)
	{
	  $ch = curl_init($url);
	  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	  $data = curl_exec($ch);
	  curl_close($ch);
	  return $data;
	}

	$pattern =$_POST["pattern"];
	$check = $_POST["case_sensitive"];
	if($pattern!="")
	{
	   $url = "https://terriblytinytales.com/test.txt";
	   $file = curl_get_contents($url);

		$arr = array();
		$special=" \n!\"#$%&'()*+,-./:;<=>?@[\]^_`{|}~";
		$word="";
		$i=0;
		$j=0;
		for($i=0;$i<strlen($file)-1;$i++)
		{
			$flag=0;
			$ch=$file[$i];
			for($j=0;$j<strlen($special)-1;$j++)
			{
				if($ch==$special[$j])
				{
					if($check)
					{
						$word=strtoupper($word);
					}
					if(array_key_exists($word,$arr))
					{
						$arr[$word]++;
					}
					else
					{
						$arr[$word]=1;
					}
					$word="";
					$flag=1;
					break;
				}
			}
			if($flag==0)
			{
				$word=$word.$ch;
			}
		}
		$keys = array_keys($arr,$pattern);
		echo "<h1>Result</h1><hr>";
		if(count($keys)>0)
		{
			echo "<table border='5px' align='center' width='25%'> <tr><th>Word</th> <th>Count</th></tr>";
			for($i=0;$i<count($keys);$i++)
			{
				$key=$keys[$i];
				echo "<tr><td>$key</td><td>$arr[$key]</td></tr>";
			}
		}
		else
		{
			echo"<p style='font-size:30px;background-color:tomato' align='center'>No words with $pattern Count</p>";
		}

	}

   
?>
</body>
</html>