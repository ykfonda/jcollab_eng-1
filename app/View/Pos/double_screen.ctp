<!DOCTYPE html>
            
<html>
<head>
    <meta name="viewport" content="width=device-width" />
	<script type="text/javascript" 
            src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js">
    </script>
	<script type="text/javascript">
        $(document).ready(function () {
			
			$('#dataAfficheur').load('http://localhost:81/projets/JCOLLAB/dev/JCOLLAB-2.X/pos/index/117 #getData',
					{ name: 'getData' },    // data 
					function(data, status, jqXGR) {  // callback function 
							//alert('data loaded	');
					});

    });
    </script>





    <script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
<script>
$(document).ready(function(){
	
setInterval(function(){
$("#screen").load('banners.php')}, 2000);
});
</script>





</head>
<body>	
	<div id="dataAfficheur"></div>
</body>
</html>