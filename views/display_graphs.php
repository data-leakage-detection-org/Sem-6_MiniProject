<?php require_once("../server/connect.php"); ?>
<?php include_once("../session.php"); ?>
<?php require_once("hasAccessUser.php"); ?>
<?php include_once("library.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<?php include_once("bootstrap.php"); ?>
</head>
<body class="dashboard_background">
	<?php include_once("menubar.php"); ?>
    <div class="graph" style="height:90%;width:90%;margin:auto">
        <canvas id='chart'></canvas>
        <br>
        <div class="buttons text-center">
            <button class="btn btn-danger" id='sender'>View Sender</button>
            <button class="btn btn-danger" id='receiver'>View Receiver</button>
        </div>
    </div>
<?php
// SENDER ANALYTICS PHP
$senderquery = "SELECT email,COUNT(email) FROM users,data_files WHERE users.id = data_files.sender_id GROUP BY email;";
$senderresult = mysqli_query($conn,$senderquery);
$senderdata = [];
while($row = mysqli_fetch_assoc($senderresult)) {
    $senderdata[] = $row;
}
$senderdata = json_encode($senderdata);
echo "<script> const sendervalues = $senderdata </script>";

// RECEIVER ANALYTICS PHP
$receiverquery = "SELECT email,COUNT(email) FROM users,data_files WHERE users.id = data_files.receiver_id GROUP BY email;";
$receiverresult = mysqli_query($conn,$receiverquery);
$receiverdata = [];
while($row = mysqli_fetch_assoc($receiverresult)) {
    $receiverdata[] = $row;
}
$receiverdata = json_encode($receiverdata);
echo "<script> const receivervalues = $receiverdata </script>";
?>

<script>
// const barColors = ["#d9ba4c", "black","blue","orange","brown"];
// const barColors = ["#AACCFF", "#90EE90","#","#","#","#","#","#","#","#","#","#","#","#"];
const barColors = [
  "#AACCFF",  // Light blue
  "#90EE90",  // Light green
  "#388E3C",  // Teal
  "#FF7F00",  // Orange
  "#FFFF00",  // Yellow
  "#CCCCFF",  // Light purple
  "#A52A2A",  // Brown
  "#000000",  // Black
  "#404040",  // Dark gray
  "#FFFFFF",  // White
  "#FFA07A",  // Light red
  "#000080",  // Dark blue
  "#006400",  // Dark green
  "#FFC0CB",  // Pink
  "#F5F5DC",  // Beige
];

// SENDER ANALYTICS JS
console.log(JSON.stringify(sendervalues));
const senderemails = [];
const sendercount  = [];

sendervalues.forEach(entry => {
    senderemails.push(entry.email);
    sendercount.push(parseInt(entry['COUNT(email)']));
})

console.log(senderemails);
console.log(sendercount);

const senderdata = {
  labels: senderemails,
  datasets: [
    {
      label: 'Dataset 1',
      data: sendercount,
      backgroundColor: barColors,
    }
  ]
};

const senderconfig = {
  type: 'pie',
  data: senderdata,
  options: {
    responsive: true,
    plugins: {
      legend: {
        position: 'top',
      },
      title: {
        display: true,
        text: 'This is the title',
      }
    }
  },
};

// RECEIVER ANALYTICS JS
console.log(JSON.stringify(receivervalues));
const receiveremails = [];
const receivercount  = [];

receivervalues.forEach(entry => {
    receiveremails.push(entry.email);
    receivercount.push(parseInt(entry['COUNT(email)']));
})

console.log(receiveremails);
console.log(receivercount);

const receiverdata = {
  labels: receiveremails,
  datasets: [
    {
      label: 'Dataset 2',
      data: receivercount,
      backgroundColor: barColors,
    }
  ]
};

const receiverconfig = {
  type: 'pie',
  data: receiverdata,
  options: {
    responsive: true,
    plugins: {
      legend: {
        position: 'top',
      },
      title: {
        display: true,
        text: 'Chart.js Pie Chart'
      }
    }
  },
};

var graph = new Chart('chart',senderconfig);
document.getElementById('sender').addEventListener('click',()=>{
    graph.destroy();
        graph = new Chart('chart',senderconfig);
    })

document.getElementById('receiver').addEventListener('click',()=>{
    graph.destroy();
        graph = new Chart('chart',receiverconfig);
    })

</script>
</body>
</html>