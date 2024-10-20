<?php 
// Start PHP session if not already started
session_start(); 

// Include navigation
include '../includes/nav.php'; 

// Connect to database
$db = mysqli_connect("localhost", "root", "", "gradalumni_db");
// Check if connection was successful
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

// Close database connection
mysqli_close($db);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumni Chapters</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/49d89f7fa2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/home2.css">
    <link rel="stylesheet" href="../css/events.css"> 
    <style>
.container {
    padding: 20px;
}

.grid-container {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
}

.grid-item {
    border: 1px solid #ddd;
    padding: 15px;
    box-shadow: 2px 2px 8px rgba(0,0,0,0.1);
    border-radius: 8px;
    background-color: #f9f9f9;
    text-align: center;
}

.event-banner {
    width: 100%;
    height: auto;
    border-radius: 8px;
    margin-bottom: 10px;
}

.grid-item h3 {
    margin-bottom: 10px;
    font-size: 1.5em;
    color: #333;
}

.rsvp-button {
    background-color: #007bff;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.rsvp-button:hover {
    background-color: #0056b3;
}

/* Modal styles */
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    padding-top: 60px;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgb(0,0,0);
    background-color: rgba(0,0,0,0.4);
}

.modal-content {
    background-color: #fefefe;
    margin: 5% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 500px;
    border-radius: 8px;
    text-align: left;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
}

input[type="text"],
input[type="email"],
input[type="number"],
textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ddd;
    border-radius: 4px;
}
</style>
</head>
<body>
    <div>
        <h1 style="text-align: center;">Alumni Chapters</h1>
    </div>
    <div class="container mt-5">
    <div class="provincial-chatter">
        <h1>Provincial Alumni Chapter</h1>
        <p>Welcome to the Provincial Alumni Chatter! Connect, Share, and Engage with Fellow Alumni from Your Province.</p>
		<br><br>
		
		<div class="cta">
            <h3><strong>Join the Conversation!</strong> Select your province and start connecting with fellow alumni.</h3>
        </div>
		<br><br>

        <div class="province-list">

            <div class="province">
                <h2>View All UMP Chapters</h2>
                <p>Connect with alumni and discuss provincial initiatives, job opportunities, and experiences.</p>
                <a href="https://chat.whatsapp.com/LXMmzbPFTuu4ndJyJ1yAep">View all Alumni group Chats via WhatsApp</a><br>
                
            </div>
            <br><br><br>		
		
		

            <div class="province">
                <h2>KwaZulu-Natal Alumni</h2>
                <p>Connect with KZN alumni and discuss provincial initiatives, job opportunities, and experiences.</p>
                <a href="#">Join KZN Alumni Chat via WhatsApp</a><br>
                <a href="#">Join KZN Alumni Chat via Telegram</a><br>
                <a href="#">Join KZN Alumni Chat via LinkedIn</a><br>
            </div>
            <br><br><br>

            <div class="province">
                <h2>Gauteng Alumni</h2>
                <p>Engage with fellow alumni based in Gauteng, share local events, opportunities, and news.</p>
                <a href="#">Join Gauteng Alumni Chat via WhatsApp</a><br>
                <a href="#">Join Gauteng Alumni Chat via Telegram</a><br>
                <a href="#">Join Gauteng Alumni Chat via LinkedIn</a><br>
            </div>
            <br><br><br>

            <div class="province">
                <h2>Western Cape Alumni</h2>
                <p>Stay updated on news and events relevant to alumni in the Western Cape.</p>
                <a href="#">Join Western Cape Alumni Chat via WhatsApp</a><br>
                <a href="#">Join Western Cape Alumni Chat via Telegram</a><br>
                <a href="#">Join Western Cape Alumni Chat via LinkedIn</a><br>
            </div>
            <br><br><br>

            <div class="province">
                <h2>Mpumalanga Alumni</h2>
                <p>Engage with fellow alumni based in Mpumalanga, share local events, opportunities, and news.</p>
                <a href="#">Join Mpumalanga Alumni Chat via WhatsApp</a><br>
                <a href="#">Join Mpumalanga Alumni Chat via Telegram</a><br>
                <a href="#">Join Mpumalanga Alumni Chat via LinkedIn</a><br>
            </div>
            <br><br><br>

            <div class="province">
                <h2>North West Alumni</h2>
                <p>Connect with North West alumni and discuss provincial initiatives, job opportunities, and experiences.</p>
                <a href="#">Join North West Alumni Chat via WhatsApp</a><br>
                <a href="#">Join North West Alumni Chat via Telegram</a><br>
                <a href="#">Join North West Alumni Chat via LinkedIn</a><br>
            </div>
            <br><br><br>

            <div class="province">
                <h2>Eastern Cape Alumni</h2>
                <p>Stay updated on news and events relevant to alumni in the Eastern Cape.</p>
                <a href="#">Join Eastern Cape Alumni Chat via WhatsApp</a><br>
                <a href="#">Join Eastern Cape Alumni Chat via Telegram</a><br>
                <a href="#">Join Eastern Cape Alumni Chat via LinkedIn</a><br>
            </div>
            <br><br><br>

            <div class="province">
                <h2>Limpopo Alumni</h2>
                <p>Engage with fellow alumni based in Limpopo, share local events, opportunities, and news.</p>
                <a href="#">Join Limpopo Alumni Chat via WhatsApp</a><br>
                <a href="#">Join Limpopo Alumni Chat via Telegram</a><br>
                <a href="#">Join Limpopo Alumni Chat via LinkedIn</a><br>
            </div>
            <br><br><br>

            <div class="province">
                <h2>Free State Alumni</h2>
                <p>Stay connected with Free State alumni, share provincial news, and discuss opportunities.</p>
                <a href="#">Join Free State Alumni Chat via WhatsApp</a><br>
                <a href="#">Join Free State Alumni Chat via Telegram</a><br>
                <a href="#">Join Free State Alumni Chat via LinkedIn</a><br>
            </div>
            <br><br><br>

            <div class="province">
                <h2>Northern Cape Alumni</h2>
                <p>Engage with fellow alumni based in Northern Cape, share local events, opportunities, and news.</p>
                <a href="#">Join Northern Cape Alumni Chat via WhatsApp</a><br>
                <a href="#">Join Northern Cape Alumni Chat via Telegram</a><br>
                <a href="#">Join Northern Cape Alumni Chat via LinkedIn</a><br>
            </div>
            <br><br><br>

        </div>

    </div>     
</div>

</body>
<?php include '../includes/footer.php'; ?>
</html>
