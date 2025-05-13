<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js">
    <link rel="stylesheet" href="../../css/hero-section.css">
    <title>Main Page</title>
</head>
<body style="color: #F3F5FA;">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid ms-5 ps-5">
        <img src="../../assets/hacker.png" alt="Logo" width="30" height="30">
        <a class="navbar-brand" href="#"><h3>PEasy</h3></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="#">Link</a>
            </li>
        </ul>
        <div class="d-flex">
        <button class="btn btn-outline-success" type="button">FAQ</button>
        <a href="#" class="ms-2"><img src="../../assets/user.png" alt="user-icon" width="30" height="30"></a>
        </div>
        </div>
    </div>
    </nav>

    <!-- Hero Header section -->
     <div class="hero">
        <div class="container">
        <h1>Welcome to PEasy!</h1>
        <p>This is a simple hero header using Bootstrap</p>
        <a href="#learn-more" class="btn btn-primary btn-lg mt-3">Learn More</a>
        </div>
    </div>

    <br><br>

    <!-- About section -->
    <div class="container">
        <h1 class="ms-5 text-black">About</h1>
        <div class="card mb-3" style="max-width: 1300px;">
        <div class="row g-0">
            <div class="col-md-4">
                <img src="../../assets/comp1.jpg" class="img-fluid rounded-start" alt="about-image">
            </div>
            <div class="col-md-8">
            <div class="container"> 
            <div class="card-body">
                <h1 class="card-title">Unleash your computing!</h1>
                <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                <a href="#" class="btn btn-outline-primary">Explore now</a>
            </div>
            </div>
            </div>
        </div>
        </div>
    </div>

    <!-- Featured section -->
    <div class="container my-5">
        <center><h1 class="text-black">Featured Products</h1></center><br><br> 
    <div class="row justify-content-center">
        <div class="card mx-5 mb-5" style="width: 30rem;">
        <img src="../../assets/comp1.jpg" class="card-img-top" alt="...">
        <div class="card-body">
            <h1>Laptop</h1>
            <p class="text-secondary">Experience the perfect laptops and ...</p>
            <a href="#"><h5>Learn more</h5></a>
        </div>
        </div>
        <div class="card mx-5 mb-5" style="width: 30rem;">
        <img src="../../assets/comp2.jpg" class="card-img-top" alt="...">
        <div class="card-body">
            <h1>Desktop</h1>
            <p class="text-secondary">Experience the perfect laptops and ...</p>
            <a href="#"><h5>Learn more</h5></a>
        </div>
        </div>
    </div>
    </div>

    <!-- advertisement section -->
    <br><br>
    <div class="card text-bg-dark" style="height: 400px;">
    <img src="../../assets/comp3.jpg" class="card-img" alt="..." style="height: 100%; object-fit: cover;">
    <div class="card-img-overlay">
        <div class="ms-5">
            <h1 class="card-title mt-5">Computer Parts</h1>
            <p class="card-text">Enhance your computing Experience</p>
            <p class="card-text">with our curated selection of</p>
            <button class="btn btn-outline-primary">Computer Shop</button>
        </div>
    </div>
    </div>
    <br><br>

    <!-- moving advertisement -->
     <div class="ad-marki bg-dark mt-5">
        <marquee behavior="scroll" direction="left" scrollamount="5" class="mt-1">
        <img src="../../assets/comp1.jpg" class="marquee-img me-5 pe-5" alt="Image 1" style="height: 60px;">
        <img src="../../assets/comp2.jpg" class="marquee-img me-5 pe-5" alt="Image 2" style="height: 60px;">
        <img src="../../assets/comp3.jpg" class="marquee-img me-5 pe-5" alt="Image 3" style="height: 60px;">

        <img src="../../assets/hacker.png" class="marquee-img me-5 pe-5" alt="Image 4" style="height: 60px;">
        <img src="../../assets/user.png" class="marquee-img me-5 pe-5" alt="Image 5" style="height: 60px;">
        <img src="../../assets/comp3.jpg" class="marquee-img me-5 pe-5" alt="Image 6" style="height: 60px;">
        </marquee>
     </div>
    
    <div class="container">
        <h1 class="ms-5 mb-4 text-black">Our</h1>
        <div class="row">
            <div class="col-6">
                <div class="card">
                <div class="card-body">
                    <img src="../../assets/comp3.jpg" class="card-img-bottom" alt="...">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                    <p class="card-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p>
                </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                <div class="card-body">
                    <img src="../../assets/comp2.jpg" class="card-img-bottom" alt="...">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                    <p class="card-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p>
                </div>
                </div>
            </div>
        </div>
    </div><br><br><br>

    <!-- footer section -->
    <div class="card bg-dark text-white">
    <div class="card-body">
        <h5 class="card-title text-center mt-4 mb-5">PEasy Shop Footer</h5>
        <div class="container">
        <div class="row text-center mb-5">
            <div class="col-4">Expert Advice</div>
            <div class="col-4">Follow our team</div>
            <div class="col-4">Customer Support</div>

            <div class="col-4"><p class="text-secondary">Our knowledge team <br>is here to provide</p></div>
            <div class="col-4"><p class="text-secondary">Connect with team <br>to learn more</p></div>
            <div class="col-4"><p class="text-secondary">Our dedicated <br>support team</p></div>
            </div>
        </div>
    </div>
    </div>
    
</body>
</html>