<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice System</title>
    <!-- Favicon link -->
    <link rel="shortcut icon" href="img/invoice.png" type="image/x-icon">
    <!-- CSS link -->
    <link rel="stylesheet" href="style.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <!-- Navbar section -->
    <header class="header_wrapper">
        <nav class="navbar shadow">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">
                    <img src="img/invoice.png" alt="logo">
                    Invoice System
                </a>
            </div>
        </nav>
    </header>
    <!-- Main Section -->
    <section class="main_wrapper">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card mt-5 shadow">
                        <div class="card-body">
                            <div id="show_alert"></div>
                            <form action="index.php" method="POST" id="add_form">
                                <div id="show_item">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <input type="text" name="product_name[]" class="form-control" placeholder="Product Name" required>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <input type="number" name="product_price[]" class="form-control" placeholder="Product Price" required>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <input type="number" name="product_quantity[]" class="form-control" placeholder="Product Quantity" required>
                                        </div>
                                        <div class="col-md-2 mb-3 d-grid">
                                            <button class="btn btn-success add_item_btn">Add More</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-grid gap-2 d-md-block">
                                    <input type="submit" value="Submit" class="btn btn-primary" id="add_btn">
                                    <a href="pdf.php" class="btn btn-danger" target="_blank">Invoice PDF</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Jquery CDN link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $(".add_item_btn").click(function(e) {
                e.preventDefault();
                $("#show_item").prepend(`<div class="row append_item">
                                        <div class="col-md-4 mb-3">
                                            <input type="text" name="product_name[]" class="form-control" placeholder="Product Name" required>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <input type="number" name="product_price[]" class="form-control" placeholder="Product Price" required>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <input type="number" name="product_quantity[]" class="form-control" placeholder="Product Quantity" required>
                                        </div>
                                        <div class="col-md-2 mb-3 d-grid">
                                           <button class="btn btn-danger remove_item_btn">Remove</button>
                                        </div>
                                    </div>`)
            });
            $(document).on('click', '.remove_item_btn', function(e) {
                e.preventDefault();
                let row_item = $(this).parent().parent();
                $(row_item).remove();
            });

        });

        //ajax request to insert all form data//
        $("#add_form").submit(function(e) {
            e.preventDefault();
            $("#add_btn").val('Adding....');
            $.ajax({
                url: 'action.php',
                method: 'post',
                data: $(this).serialize(),
                success: function(response) {
                    $("#add_btn").val('Submit');
                    $("#add_form")[0].reset();
                    $(".append_item").remove();
                    $("#show_alert").html(`<div class="alert alert-success alert-dismissible fade show" role="alert">
  ${response}
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>`);
                }
            })
        });
    </script>
</body>

</html>