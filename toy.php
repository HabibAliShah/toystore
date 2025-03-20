<?php   										// Opening PHP tag
	
	// Include the database connection script
	require 'includes/database-connection.php';

	// Retrieve the value of the 'toynum' parameter from the URL query string
	//		i.e., ../toy.php?toynum=0001
	$toy_id = $_GET['toynum'];


	/*
	 * TO-DO: Define a function that retrieves ALL toy and manufacturer info from the database based on the toynum parameter from the URL query string.
	 		  - Write SQL query to retrieve ALL toy and manufacturer info based on toynum
	 		  - Execute the SQL query using the pdo function and fetch the result
	 		  - Return the toy info

	 		  Retrieve info about toy from the db using provided PDO connection
	 */

	 function get_toy_and_manufacturer_info(PDO $pdo, string $toynum) {
        // SQL query to retrieve ALL toy and manufacturer info based on toynum
        $sql = "SELECT t.*, m.name AS manuf_name, m.Street, m.City, m.State, m.ZipCode, m.phone, m.contact 
                FROM toy t
                JOIN manuf m ON t.manid = m.manid
                WHERE t.toynum = :toynum;";

        // Execute the SQL query using the pdo function and fetch the result
        $toy_info = pdo($pdo, $sql, ['toynum' => $toynum])->fetch();

        // Return the toy info
        return $toy_info;
    }

    // Retrieve toy and manufacturer info from the database
    $toy_info = get_toy_and_manufacturer_info($pdo, $toy_id);

	//check
	if (!$toy_info) {
        die("Toy not found. Please check the toy number and try again.");
    }

// Closing PHP tag  ?> 

<!DOCTYPE>
<html>

	<head>
		<meta charset="UTF-8">
  		<meta name="viewport" content="width=device-width, initial-scale=1.0">
  		<title>Toys R URI</title>
  		<link rel="stylesheet" href="css/style.css">
  		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Lilita+One&display=swap" rel="stylesheet">
	</head>

	<body>

		<header>
			<div class="header-left">
				<div class="logo">
					<img src="imgs/logo.png" alt="Toy R URI Logo">
      			</div>

	      		<nav>
	      			<ul>
	      				<li><a href="index.php">Toy Catalog</a></li>
	      				<li><a href="about.php">About</a></li>
			        </ul>
			    </nav>
		   	</div>

		    <div class="header-right">
		    	<ul>
		    		<li><a href="order.php">Check Order</a></li>
		    	</ul>
		    </div>
		</header>

		<main>
			<!-- 
			  -- TO DO: Fill in ALL the placeholders for this toy from the db
  			  -->
			
			<div class="toy-details-container">
				<div class="toy-image">
					<!-- Display image of toy with its name as alt text -->
					<img src="<?= $toy_info['imgSrc'] ?>" alt="<?= $toy_info['name'] ?>">
				</div>

				<div class="toy-details">

					<!-- Display name of toy -->
			        <h1><?= $toy_info['name'] ?></h1>

			        <hr />

			        <h3>Toy Information</h3>

			        <!-- Display description of toy -->
			        <p><strong>Description:</strong> <?= $toy_info['description'] ?></p>

			        <!-- Display price of toy -->
			        <p><strong>Price:</strong> $ <?= $toy_info['price'] ?></p>

			        <!-- Display age range of toy -->
			        <p><strong>Age Range:</strong> <?= $toy_info['agerange'] ?></p>

			        <!-- Display stock of toy -->
			        <p><strong>Number In Stock:</strong> <?= $toy_info['numinstock'] ?></p>

			        <br />

			        <h3>Manufacturer Information</h3>

			        <!-- Display name of manufacturer -->
			        <p><strong>Name:</strong> <?= $toy_info['manuf_name'] ?> </p>

			        <!-- Display address of manufacturer -->
			        <p><strong>Address:</strong> <?= $toy_info['Street'] ?>,
					<?= $toy_info['City'] ?>,
					<?= $toy_info['State'] ?>,
					<?= $toy_info['ZipCode'] ?>
					</p>

			        <!-- Display phone of manufacturer -->
			        <p><strong>Phone:</strong> <?= $toy_info['phone'] ?></p>

			        <!-- Display contact of manufacturer -->
			        <p><strong>Contact:</strong> <?= $toy_info['contact'] ?></p>
			    </div>
			</div>
		</main>

	</body>
</html>
