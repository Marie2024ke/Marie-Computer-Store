<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dash.css">
    <title>Dashboard</title>
    <style>
        body {
            height: 100vh;
            width: 100%;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .main-container {
            height: 95%;
            width: 95%;
            /* border: 1px solid red; */
            display: flex;
            justify-content: space-between;
        }

        .left-container {
            /* border: 1px solid red; */
            width: 49.5%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .right-container {
            /* border: 1px solid red; */
            width: 49.5%;
            height: 100%;
        }

        .leftTop,
        .leftBottom {
            height: 49%;
            width: 100%;
            /* border: 1px solid red; */
        }
    </style>
</head>

<body>
    <div class="main-container">
        <div class="left-container">
            <div class="leftTop">
                <h2>Users</h2>
                <?php include 'fetch_clients.php'; ?>
            </div>
            <div class="leftBottom">
                <h2>Orders</h2>
            <?php include 'fetch_orders.php'; ?>
            </div>
        </div>
        <div class="right-container">
            <h2>Messages</h2>
        <?php include 'fetch_messages.php'; ?>
        </div>
    </div>
</body>

</html>