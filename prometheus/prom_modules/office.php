<style>
#office-background, .left-side {
	height: 400px;
}

#office-background {
	margin-top: 70px;
	background-color: #fff;
	width: 100%;
	clear: both;
	background-image: linear-gradient(left, #0050a1, #0050a1 50%, transparent 50%, transparent
		100%);
	background-image: -webkit-linear-gradient(left, #0050a1, #0050a1 50%, transparent 50%,
		transparent 100%);
}

.bottom-banner {
	clear: both;
	width: 100%;
	height: 200px;
	line-height: 50px;
	background-color: #fff;
	border-top: 10px solid #0a3470;
}

.left-side {
	height: 400px;
	float: left;
	width: 60%;
	color: #fff;
	position: relative;
}

.right-side {
	height: 400px;
	float: right;
	width: 35%;
	font-size: 16pt;
	position: relative;
}

#overText {
	z-index: 2;
	text-align: justify;
}

img.spongeImage {
	height: 100%;
	margin-top: 70px;
	position: absolute;
	left: 30px;
	bottom: 0;
	z-index: 1;
}

.banner-text {
	width: 100%;
	text-align: center;
	color: red;
	font-size: 18pt;
	padding: 40px;
}
</style>

<?php
class office {
	protected $dbConnection;
	const ModuleDescription = 'Office. <br> Office Screen, left and right sides left is Image, right is Database of Services that are included.';
	const ModuleAuthor = 'Sunsetcoders Development Team.';
	const ModuleVersion = '0.1';
	function __construct($dbConnection) {
		$this->dbConnection = $dbConnection;
	}
	public function office() {
	}
	public function callToFunction() {
		?>
<div id="office-background">
	<div class="body-content">
		<div class="left-side">
			<img class="spongeImage"
				src="<?php echo IMAGE_PATH; ?>/bigsponge.jpg">
		</div>
		<div class="right-side">
			<br>
			<br>This allows 2 Wog Girls to tailor an expert team and service for
			your unique cleaning needs.<br>
			<br> <font color="ff0000">NO MATTER HOW COMPLEX, MESSY, BIG OR SMALL
				YOUR PREMISES ARE.</font><br><br>
			<button id="book-now">Book A Consultation</button>
		</div>
	</div>
</div>
<div class="bottom-banner">
	<div class="banner-text">
		WE HAVE STRONG FAMILY VALUES AND WE CLEAN <br>
		"JUST-A-LIKE-MUMMA-TAUGHT-US!"
	</div>
</div>
<?php
	}
}

