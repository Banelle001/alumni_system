<?php
session_start();
include 'conn.php'; 

if (!isset($_SESSION['user_id'])) {
    header("Location: ../Alumni_dash.php"); 
    exit();
}

$userId = $_SESSION['user_id']; 

// Handle search functionality
if (isset($_POST['search'])) {
    $searchTerm = mysqli_real_escape_string($conn, $_POST['search']);
    $searchQuery = "SELECT id, name, surname, status, photo FROM users WHERE name LIKE '%$searchTerm%' OR surname LIKE '%$searchTerm%'";
    $searchResult = mysqli_query($conn, $searchQuery);

    $baseUrl = '../../uploads/';
    $defaultPhoto = '../../img/pic2.png'; // Default image path

    while ($row = mysqli_fetch_assoc($searchResult)) {
        $photoFilename = htmlspecialchars($row['photo']);
        $photoPath = $baseUrl . $photoFilename;

        // Check if the profile picture file exists, otherwise use the default image
        if (!empty($photoFilename) && file_exists($photoPath)) {
            $photoUrl = $photoPath; // Image exists, use the uploaded one
        } else {
            $photoUrl = $defaultPhoto; // Use the default image
        }

        echo "<div onclick='startChat(" . $row['id'] . ")' class='user-profile'>";
        echo "<img src='" . htmlspecialchars($photoUrl) . "' class='profile-img' alt='" . htmlspecialchars($row['name']) . " " . htmlspecialchars($row['surname']) . "' />";
        echo "<span>" . htmlspecialchars($row['name']) . " " . htmlspecialchars($row['surname']) . " - " . htmlspecialchars($row['status']) . "</span>";
        echo "</div>";
    }
    exit(); 
}


// Handle sending messages
if (isset($_POST['message']) && isset($_POST['receiver_id'])) {
    $receiverId = mysqli_real_escape_string($conn, $_POST['receiver_id']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    $sendQuery = "INSERT INTO messages (sender_id, receiver_id, message) VALUES ('$userId', '$receiverId', '$message')";
    
    if (mysqli_query($conn, $sendQuery)) {
        echo "<div class='sent-message'>" . htmlspecialchars($message) . "</div>";
    } else {
        echo "Error sending message: " . mysqli_error($conn);
    }
    exit();
}

// Handle fetching messages
if (isset($_GET['receiver_id'])) {
    $receiverId = mysqli_real_escape_string($conn, $_GET['receiver_id']);
    $fetchQuery = "SELECT * FROM messages WHERE (sender_id = '$userId' AND receiver_id = '$receiverId') OR (sender_id = '$receiverId' AND receiver_id = '$userId') ORDER BY timestamp ASC";
    $fetchResult = mysqli_query($conn, $fetchQuery);
    
    while ($row = mysqli_fetch_assoc($fetchResult)) {
        echo "<div class='" . ($row['sender_id'] == $userId ? "sent" : "received") . "-message'>" . htmlspecialchars($row['message']) . "</div>";
    }
    exit();
}

// Fetch recent contacts for the sidebar
if (isset($_GET['recent_contacts'])) {
    $recentContactsQuery = "
        SELECT u.id, u.name, u.surname, u.photo, u.status 
        FROM users u
        JOIN (
            SELECT sender_id AS user_id FROM messages WHERE receiver_id = '$userId'
            UNION
            SELECT receiver_id AS user_id FROM messages WHERE sender_id = '$userId'
        ) m ON u.id = m.user_id
        GROUP BY u.id
        ORDER BY MAX(m.user_id) DESC"; 

    $recentContactsResult = mysqli_query($conn, $recentContactsQuery);

    $baseUrl = '../../uploads/';
    $defaultPhoto = '../../img/pic2.png'; // Default image path

    while ($row = mysqli_fetch_assoc($recentContactsResult)) {
        $photoFilename = htmlspecialchars($row['photo']);
        $photoPath = $baseUrl . $photoFilename;

        // Check if the profile picture file exists, otherwise use the default image
        if (!empty($photoFilename) && file_exists($photoPath)) {
            $photoUrl = $photoPath; // Image exists, use the uploaded one
        } else {
            $photoUrl = $defaultPhoto; // Use the default image
        }

        echo "<div onclick='startChat(" . $row['id'] . ")' class='user-profile'>";
        echo "<img src='" . htmlspecialchars($photoUrl) . "' class='profile-img' alt='" . htmlspecialchars($row['name']) . " " . htmlspecialchars($row['surname']) . "' />";
        echo "<span>" . htmlspecialchars($row['name']) . " " . htmlspecialchars($row['surname']) . " - " . htmlspecialchars($row['status']) . "</span>";
        echo "</div>";
    }
    exit(); 
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="users.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <title>GradChat</title>
    <style>
    /* Basic styles for the messaging interface */
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .container {
        width: 100%;
        max-width: 800px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
        display: flex;
        flex-direction: column;
        height: 80vh;
    }

    #search {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 16px;
    }

    #search-results {
        max-height: 150px;
        overflow-y: auto;
        margin-bottom: 20px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    #search-results div {
        padding: 10px;
        border-bottom: 1px solid #eee;
        cursor: pointer;
    }

    #search-results div:last-child {
        border-bottom: none;
    }

    #chat-box {
        height: max-content 2px;
        flex: 1;
        display: flex;
        flex-direction: column;
        border: 1px solid #ddd;
        border-radius: 4px;
        background: #fff;
        padding: 10px;
    }

    #messages {
        height: max-content 20px;
        flex: 1;
        overflow-y: auto;
        padding: 10px;
        margin-bottom: 10px;
        border-bottom: 1px solid #ddd;
    }

    .sent-message,
    .received-message {
        max-width: 100%;
        padding: 10px;
        border-radius: 8px;
        margin-bottom: 10px;
        word-wrap: break-word;
    }

    .sent-message {
        align-self: flex-start;
        background-color: #0084ff;
        color: #333;
    }

    .received-message {
        align-self: flex-end;
        background-color: #e4e6eb;
        color: #333;
    }

    .message-input {
        display: flex;
        align-items: center;
    }

    #message {
        flex: 1;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 20px;
        font-size: 16px;
        margin-right: 10px;
    }

    button {
        padding: 10px 20px;
        background: #007bff;
        color: #fff;
        border: none;
        border-radius: 20px;
        cursor: pointer;
        font-size: 16px;
    }

    button:hover {
        background: #0056b3;
    }

    /* Custom scrollbar styling (optional) */
    #messages::-webkit-scrollbar {
        width: 8px;
    }

    #messages::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }

    #messages::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 4px;
    }

    #messages::-webkit-scrollbar-thumb:hover {
        background: #a1a1a1;
    }
</style>

    <script>
        var receiverId = null;

        function searchUsers() {
            var searchTerm = document.getElementById('search').value;
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'users.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                document.getElementById('search-results').innerHTML = this.responseText;
            };
            xhr.send('search=' + encodeURIComponent(searchTerm));
        }

        function startChat(userId) {
            receiverId = userId;
            fetchMessages();
        }

        function sendMessage() {
            var message = document.getElementById('message').value;
            if (!message.trim()) return;  // Prevent sending empty messages
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'users.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                document.getElementById('messages').innerHTML += this.responseText;
                document.getElementById('message').value = '';
                document.getElementById('messages').scrollTop = document.getElementById('messages').scrollHeight;
            };
            xhr.send('message=' + encodeURIComponent(message) + '&receiver_id=' + receiverId);
        }

        function fetchMessages() {
            if (!receiverId) return;  // Only fetch messages if a chat is active
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'users.php?receiver_id=' + receiverId, true);
            xhr.onload = function() {
                document.getElementById('messages').innerHTML = this.responseText;
                document.getElementById('messages').scrollTop = document.getElementById('messages').scrollHeight;
            };
            xhr.send();
        }

        function fetchRecentContacts() {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'users.php?recent_contacts=true', true);
            xhr.onload = function() {
                document.getElementById('recent-messages').innerHTML = this.responseText;
            };
            xhr.send();
        }

        document.addEventListener("DOMContentLoaded", function() {
            fetchRecentContacts(); // Fetch recent contacts when the page loads
            setInterval(fetchMessages, 2000); // Fetch messages every 2 seconds
        });
    </script>
</head>
<body>
    <div style="width: 100%; height: 100%; background-color: white;">
            <div >
            <?php include 'nav.php'; ?>
            </div>
        <div class="container" >
        
            <input type="text" id="search" placeholder="Search users..." onkeyup="searchUsers()">
            <div id="search-results" style="height: 90px;"></div>

            <div id="chat-box" style="display: flex; flex-direction: row;">
                <!-- Left Container for Recent Messages History -->
                <div id="recent-messages" style="flex: 1; border-right: 1px solid #ccc; padding: 10px;">
                    <!-- Recent contacts will be displayed here -->
                </div>

                <!-- Right Container for Message Box and Text Field -->
                <div id="message-box" style="flex: 0 0 auto; display: flex; flex-direction: column; padding: 10px; width: 410px; height: 200px;">
                    <div id="messages" style="flex: 0 0 auto; overflow-y: auto; width: 100%; height: 290px; border: 1px solid #ddd;">
                        <!-- Messages will be displayed here -->
                    </div>
                    <div class="chat-input" style="flex: 0 0 auto; display: flex; padding:0px;">
                        <input id="message" style="flex: 1; padding: 10px;" placeholder="Type your message..." onkeydown="checkEnter(event)">
                        <button style="padding: 10px; margin-left: 10px;" onclick="sendMessage()">Send</button>
                    </div>
                </div>

            </div>
        </div>
        
    </div>

    <script>
        function checkEnter(event) {
            if (event.key === 'Enter' && !event.shiftKey) {
                event.preventDefault(); // Prevent default Enter key behavior (new line)
                sendMessage();
            }
        }
    </script>

    <script>
        var receiverId = null;

        function searchUsers() {
            var searchTerm = document.getElementById('search').value;
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'users.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                document.getElementById('search-results').innerHTML = this.responseText;
            };
            xhr.send('search=' + encodeURIComponent(searchTerm));
        }

        function startChat(userId) {
            receiverId = userId;
            fetchMessages();
        }

        function sendMessage() {
            var message = document.getElementById('message').value;
            if (!message.trim()) return;  // Prevent sending empty messages
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'users.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                document.getElementById('messages').innerHTML += this.responseText;
                document.getElementById('message').value = '';
                document.getElementById('messages').scrollTop = document.getElementById('messages').scrollHeight;
            };
            xhr.send('message=' + encodeURIComponent(message) + '&receiver_id=' + receiverId);
        }

        function fetchMessages() {
            if (!receiverId) return;  // Only fetch messages if a chat is active
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'users.php?receiver_id=' + receiverId, true);
            xhr.onload = function() {
                document.getElementById('messages').innerHTML = this.responseText;
                document.getElementById('messages').scrollTop = document.getElementById('messages').scrollHeight;
            };
            xhr.send();
        }

        function fetchRecentContacts() {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'users.php?recent_contacts=true', true);
            xhr.onload = function() {
                document.getElementById('recent-messages').innerHTML = this.responseText;
            };
            xhr.send();
        }

        document.addEventListener("DOMContentLoaded", function() {
            fetchRecentContacts(); // Fetch recent contacts when the page loads
            setInterval(fetchMessages, 2000); // Fetch messages every 2 seconds
        });
    </script>
</body>

</html>