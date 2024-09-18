<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Freeze Tabs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<a href="#tab1" class="nav-link">Tab 1</a>
<a href="#tab2" class="nav-link">Tab 2</a>
<a href="#tab3" class="nav-link">Tab 3</a>

<button type="button" class="btn btn-danger" id="stop">Stop Planning</button>

<script>
$(document).on('mousemove', function(event) {
    var mouseX = event.pageX; // Get the mouse X position
    var mouseY = event.pageY; // Get the mouse Y position
    var windowHeight = $(window).height(); // Get window height
    var windowWidth = $(window).width();   // Get window width

    // Detect when the mouse moves to the top edge of the window
    if (mouseY < 5) {
        alert('Are you sure you want to leave this page?');
    }
    
    // Optionally, you can also check for other edges (like the left or right edges)
    /*
    if (mouseX < 5 || mouseX > windowWidth - 5 || mouseY > windowHeight - 5) {
        alert('Are you sure you want to leave this page?');
    }
    */
});

</script>

</body>
</html>
