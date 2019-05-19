<?php include_once 'connect.php'; ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<title>Perhitungan KNN</title>
</head>
<body>
	<form method="POST">
	  <fieldset class="form-group">
	    <div id="legend">
	      <legend class="">Perhitungan dengan KNN</legend>
	    </div>

	    <div class="form-group row">
			<label for="first_name" class="col-xs-3 ">Pelvic incidence</label>
			<div class="col-xs-9">
				<input type="text" class="form-control" id="first_name" name="first_name">
			</div>
		</div>
	 
	    <div class="control-group">
	      <label class="control-label">Pelvic Tilt</label>
	      <div class="controls">
	        <input type="number" name="pt" placeholder="" class="input-small" required="" step=".01">
	      </div>
	    </div>
	 
	    <div class="control-group">
	      <label class="control-label">Lumbar Lordosis Angle</label>
	      <div class="controls">
	        <input type="number" name="lla" placeholder="" class="input-small" required="" step=".01">
	      </div>
	    </div>
	 
	    <div class="control-group">
	      <label class="control-label">Sacral Slope</label>
	      <div class="controls">
	        <input type="number" name="sl" placeholder="" class="input-small" required="" step=".01">
	      </div>
	    </div>

	    <div class="control-group">
	      <label class="control-label">Pelvic Radius</label>
	      <div class="controls">
	        <input type="number" name="pr" placeholder="" class="input-small" required="" step=".01">
	      </div>
	    </div>

	    <div class="control-group">
	      <label class="control-label">Degree Spondylolisthesis</label>
	      <div class="controls">
	        <input type="number" name="ds" placeholder="" class="input-small" required="" step=".01">
	      </div>
	    </div>
	 
	    <div class="control-group">
	      <div class="controls">
	        <input type="submit" class="btn btn-success" name="submit" value="Hitung">
	      </div>
	    </div>
	  </fieldset>
	</form><br>

	<fieldset>
		<div id="legend">
			<legend class="">Hasil</legend>
	    </div>
	    <table>
	    	<thead>
	    		<th>Pelvic incidence</th>
	    		<th>Pelvic Tilt</th>
	    		<th>Lumbar Lordosis Angle</th>
	    		<th>Sacral Slope</th>
	    		<th>Pelvic Radius</th>
	    		<th>Degree Spondylolisthesis</th>
	    	</thead>
	    	<tbody>
	    		
	    	</tbody>
	    	<?php 
	    		$check = "SELECT * FROM hasil";
    			$result = mysqli_query($conn,$check);
	    		while ($data = mysqli_fetch_array($result)) {
	    			# code...
	    		}
	    	 ?>
	    </table>
	</fieldset>
</body>
</html>

<?php  
	if (isset($_POST['submit'])) {
		$a1 = $_POST['pi'];
		$a2 = $_POST['pt'];
		$a3 = $_POST['lla'];
		$a4 = $_POST['sl'];
		$a5 = $_POST['pr'];
		$a6 = $_POST['ds'];
		
		$k = 5;

		//Membaca jumlah baris data pada database
		$query ="SELECT * FROM `data`";
		$sql = mysqli_query($conn,$query);
		$numrows = mysqlI_num_rows($sql);
		// $id = 1;

		for ($i=1; $i <= $numrows; $i++) { 

			$query1 = "SELECT * FROM data WHERE id = $i";
			$sql1 = mysqli_query($conn,$query1);
			while($data = mysqli_fetch_array($sql1)) {

				//pengurangan
				$v1 = $a1 - $data['pelvic_incidence'];
				$v2 = $a2 - $data['pelvic_tilt'];
				$v3 = $a3 - $data['lumbar_lordosis_angle'];
				$v4 = $a4 - $data['sacral_slope'];
				$v5 = $a5 - $data['pelvic_radius'];
				$v6 = $a6 - $data['degree_spondylolisthesis'];

				//dikuadratkan dan dikali dengan persen korelasi
				$pow = (pow($v1,2))*0.04 + (pow($v2,2))*0.28 + (pow($v3,2))*0.05 + (pow($v4,2))*0.16 + (pow($v5,2))*0.31 + (pow($v6,2))*0.16;

				//diakar
				$sqr = sqrt($pow);

				//masukin hasil perhitungan ke database
				$query ="UPDATE hasil SET jarak = '$sqr' WHERE id_hasil = '$i'";
				$sql = mysqli_query($conn,$query);
				// $id++;

			}
		}
		
	}
	

?>