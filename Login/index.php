<?php

$conn = mysqli_connect('localhost', 'root', '', 'contact_db') or die('connection failed');

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $number = $_POST['number'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $doctor = $_POST['doctor'];

    // Check if the selected date and time are in the future
    $appointmentDateTime = strtotime("$date $time");
    $currentDateTime = time();

    if ($appointmentDateTime >= $currentDateTime) {
        // Check if the selected doctor is available at the given date and time
        $checkAvailability = mysqli_query($conn, "SELECT * FROM `contact_form` WHERE doctor = '$doctor' AND date = '$date' AND time = '$time'");

        // Check if the selected doctor has any appointments within 2 hours of the specified time
        $twoHoursLater = strtotime('+2 hours', $appointmentDateTime);
        $twoHoursEarlier = strtotime('-2 hours', $appointmentDateTime);

        $checkOverlap = mysqli_query($conn, "SELECT * FROM `contact_form` WHERE doctor = '$doctor' AND date = '$date' AND time BETWEEN '$twoHoursEarlier' AND '$twoHoursLater'");

        if (mysqli_num_rows($checkAvailability) == 0 && mysqli_num_rows($checkOverlap) == 0) {
            // The selected doctor is available, proceed with the appointment
            $insert = mysqli_query($conn, "INSERT INTO `contact_form`(name, email, number, date, time, doctor) VALUES('$name','$email','$number','$date','$time','$doctor')") or die('query failed');

            if ($insert) {
                $message[] = 'Appointment made successfully!';
            } else {
                $message[] = 'Appointment failed';
            }
        } else {
            // The selected doctor is not available at the given date and time or has an appointment within 2 hours
            $message[] = 'Appointment failed. The selected doctor is not available at the given date and time or has another appointment within 2 hours. Please choose another date, time, or doctor.';
        }
    } else {
        // The selected date and time are in the past, indicate failure
        $message[] = 'Appointment failed. Please choose a future date and time.';
    }
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CliniQuickAid</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="style/style1.css">
    <link rel="stylesheet" href="style/botstyle.css">

</head>
<body>
    
<!-- header section starts  -->

<header class="header">

    <a href="#" class="logo"> <i class="fas fa-heartbeat"></i> <strong>Clini</strong>QuickAid </a>

    <nav class="navbar">
        <a href="#home">home</a>
        <a href="#about">about</a>
        <a href="#services">services</a>
        <a href="#doctors">doctors</a>
        <a href="#appointment">appointment</a>
        <a href="#blogs">blogs</a>
        <a href="login.php"> <button class="btn"> Login </button> </a>
    </nav>

    <div id="menu-btn" class="fas fa-bars"></div>       

</header>

<!-- header section ends -->



<!-- home section starts  -->

<section class="home" id="home">

    <div class="image">
        <img src="image/home.png" alt="">
    </div>

    <div class="content">
        <h3>Welcome to a healthier future</h3>
        <p> Our commitment to compassionate care, cutting-edge technology, and a patient-centric approach ensures your well-being is our top priority.</p>
        <a href="#appointment" class="btn"> Set an Appointment Schedule <span class="fas fa-chevron-right"></span> </a>
    </div>

    <!-- chatbot section -->

    <div class="wrapper">
            <div class="title">CliniQuickAid Chatbot</div>
            <div class="form">
                <div class="bot-inbox inbox">
                    <div class="icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="msg-header">
                        <p>Welcome to CliniQuickAid Chatbot, How may can I help you?</p>
                    </div>
                </div>
            </div>
            <div class="typing-field">
                <div class="input-data">
                    <input id="data" type="text" placeholder="Type something here.." required>
                    <button id="send-btn">Send</button>
                </div>
            </div>
        </div>

        <!-- chatbot section ends -->


</section>

<!-- home section ends -->



<!-- about section starts  -->

<section class="about" id="about">

    <h1 class="heading"> <span>about</span> us </h1>

    <div class="row">

        <div class="image">
            <img src="image/heart.png" alt="">
        </div>

        <div class="content">
            <h3>Discover a Healthier Tomorrow</h3>
            <p>Welcome to Clinic Quick Aid, where your health is our priority. At the forefront of medical excellence, we combine cutting-edge technology with compassionate care. Our dedicated team of healthcare professionals is committed to providing you with personalized, high-quality services. Trust us to be your partner in health, ensuring your well-being every step of the way.</p>
            <p>Our hospital is more than a medical facility; it's a center for excellence where expertise, empathy, and innovation converge. From our comprehensive range of medical specialties to our commitment to patient-centered care, we are here to guide you on your journey to optimal health.</p>
            <a href="#" class="btn"> learn more <span class="fas fa-chevron-right"></span> </a>
        </div>

    </div>

</section>

<!-- about section ends -->

<!-- services section starts  -->

<section class="services" id="services">

    <h1 class="heading"> our <span>services</span> </h1>

    <div class="box-container">

        <div class="box">
            <i class="fas fa-comment-dots"></i>
            <h3>User-FreUser Friendly A.I/Chatbot</h3>
            <p>Effortlessly book and manage your appointments with instant, intuitive assistance. Experience the future of scheduling today!</p>
            <a href="#" class="btn"> learn more <span class="fas fa-chevron-right"></span> </a>
        </div>

        <div class="box">
            <i class="fas fa-ambulance"></i>
            <h3>Effortless One-Click Clinic Appointments</h3>
            <p>Introducing our Effortless One-Click Clinic Appointments service! Say goodbye to scheduling headaches. With just one click, access seamless appointment booking. Experience convenience like never before!</p>
            <a href="#" class="btn"> learn more <span class="fas fa-chevron-right"></span> </a>
        </div>

        <div class="box">
            <i class="fas fa-calendar-alt"></i>
            <h3>Real-Time Calendar </h3>
            <p>Stay ahead of your schedule with live updates and instant availability. Effortlessly manage your appointments with precision and ease.</p>
            <a href="#" class="btn"> learn more <span class="fas fa-chevron-right"></span> </a>
        </div>

        <div class="box">
            <i class="fas fa-user-md"></i>
            <h3>Telemedicine Support</h3>
            <p>Access quality healthcare from the comfort of your home. With our seamless integration, connect with medical professionals remotely for consultations and appointments. Experience convenience and peace of mind with Telemedicine Support.</p>
            <a href="#" class="btn"> learn more <span class="fas fa-chevron-right"></span> </a>
        </div>

        <div class="box">
            <i class="fas fa-laptop"></i>
            <h3>Multi-Platform Accessibility</h3>
            <p>EEffortlessly manage appointments from any device, anywhere. Our service ensures seamless scheduling across all platforms, providing convenience at your fingertips. Experience the freedom of managing appointments with ease, anytime, anywhere!</p>
            <a href="#" class="btn"> learn more <span class="fas fa-chevron-right"></span> </a>
        </div>

    </div>

</section>

<!-- services section ends -->



<!-- doctors section starts  -->

<section class="doctors" id="doctors">

    <h1 class="heading"> our <span>doctors</span> </h1>

    <div class="box-container">

        <div class="box">
            <img src="image/img3.png" alt="">       
            <h3>Dr. Gian Carlo R. Europa</h3>
            <span>PHYSICIAN</span>
            <div class="share">
            <a href="#" class="fab fa-facebook-f"></a>
                <a href="#" class="fab fa-twitter"></a>
                <a href="#" class="fab fa-instagram"></a>
                <a href="#" class="fab fa-linkedin"></a>
            </div>
        </div>

        <div class="box">
            <img src="image/img4.png" alt="">  
            <h3>Dr. Marisa Jorgina M. Reyes</h3>
            <span>SCHOOL DENTIST</span>
            <div class="share">
            <a href="#" class="fab fa-facebook-f"></a>
                <a href="#" class="fab fa-twitter"></a>
                <a href="#" class="fab fa-instagram"></a>
                <a href="#" class="fab fa-linkedin"></a>
            </div>
        </div>

        <div class="box">
            <img src="image/img5.png" alt=""> 
            <h3>Mr.Aromin Melvin</h3>
            <span>SCHOOL NURSE</span>
            <div class="share">
            <a href="#" class="fab fa-facebook-f"></a>
                <a href="#" class="fab fa-twitter"></a>
                <a href="#" class="fab fa-instagram"></a>
                <a href="#" class="fab fa-linkedin"></a>
            </div>
        </div>

        <div class="box">
            <img src="image/img6.png" alt=""> 
            <h3>Ms. Imelda V. Castillo</h3>
            <span>SCHOOL NURSE</span>
            <div class="share">
            <a href="#" class="fab fa-facebook-f"></a>
                <a href="#" class="fab fa-twitter"></a>
                <a href="#" class="fab fa-instagram"></a>
                <a href="#" class="fab fa-linkedin"></a>
            
            </div>
        </div>
        <div class="box">
            <img src="image/img7.png" alt=""> 
            <h3>Ms. Annalee Jovelyn Reyes</h3>
            <span>ASSISTANT NURSE</span>
            <div class="share">
            <a href="#" class="fab fa-facebook-f"></a>
                <a href="#" class="fab fa-twitter"></a>
                <a href="#" class="fab fa-instagram"></a>
                <a href="#" class="fab fa-linkedin"></a>
            </div>
        </div>
       
    </div>

</section>

<!-- doctors section ends -->

<!-- appointmenting section starts   -->

<section class="appointment" id="appointment">

    <h1 class="heading"> <span>appointment</span> now </h1>    

    <div class="row">

        <div class="image">
            <img src="image/home-3.png" alt="">
        </div>

        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
            <?php
            if(isset($message)) {
                foreach($message as $message) {
                    echo'<p class ="message">'.$message.'</p>';
                }
            }
            ?>

            <h3>make appointment</h3>
            <input type="text" name="name" placeholder="your name" class="box">
            <input type="number" name="number" placeholder="your number" class="box">
            <input type="email" name="email" placeholder="your email" class="box">
            <input type="date" name="date" class="box">
            <input type="time" name="time" class="box">

            <!-- Add a select dropdown for the doctor -->
            <select name="doctor" class="box">
                <option value="" disabled selected>Select Doctor</option>
                <option value="Dr. Gian Carlo R. Europa">Dr. Gian Carlo R. Europa - Physicians</option>
                <option value="Dr. Marisa Jorgina M. Reyes">Dr. Marisa Jorgina M. Reyes - Dentist</option>
                <option value="Mr.Aromin Melvin">Mr.Aromin Melvin - Nurse</option>
                <option value="Ms. Imelda V. Castillo">Ms. Imelda V. Castillo - Nurse</option>
                <option value="Ms. Annalee Jovelyn Reyes ">Ms. Annalee Jovelyn Reyes - Assistant Nurse</option>
                <!-- Add more options for other doctors -->
            </select>

            <input type="submit" name="submit" value="appointment now" class="btn">
        </form>

    </div>

</section>

<!-- appointmenting section ends -->



<!-- blogs section starts  -->

<section class="blogs" id="blogs">

    <h1 class="heading"> our <span>blogs</span> </h1>

    <div class="box-container">

        <div class="box">
            <div class="image">
                <img src="image/blog-1.jpg" alt="">
            </div>
            <div class="content">
                <div class="icon">
                    <a href="#"> <i class="fas fa-user"></i> by Cristina Coronel </a>
                </div>
                <h3>Preventive Care Guides</h3>
                <p>Educate readers on the importance of preventive care, with articles on screenings, vaccinations, and health checkups.</p>
                <a href="#" class="btn"> learn more <span class="fas fa-chevron-right"></span> </a>
            </div>
        </div>

        <div class="box">
            <div class="image">
                <img src="image/blog-2.jpg" alt="">
            </div>
            <div class="content">
                <div class="icon">
                    <a href="#"> <i class="fas fa-user"></i> by Cristina Coronel </a>
                </div>
                <h3>Health and Wellness Tips</h3>
                <p>Share articles on maintaining a healthy lifestyle, covering topics like nutrition, exercise, mental health, and stress management.</p>
                <a href="#" class="btn"> learn more <span class="fas fa-chevron-right"></span> </a>
            </div>
        </div>

        <div class="box">
            <div class="image">
                <img src="image/blog-3.jpg" alt="">
            </div>
            <div class="content">
                <div class="icon">
                    <a href="#"> <i class="fas fa-user"></i> by Cristina Coronel </a>
                </div>
                <h3>Doctor Spotlights</h3>
                <p>Introduce your medical staff through personal and professional profiles, sharing their expertise and contributions to the community.</p>
                <a href="#" class="btn"> learn more <span class="fas fa-chevron-right"></span> </a>
            </div>
        </div>
        <div class="box">
            <div class="image">
                <img src="image/blog-4.jpg" alt="">
            </div>
            <div class="content">
                <div class="icon">
                    <a href="#"> <i class="fas fa-user"></i> by Cristina Coronel </a>
                </div>
                <h3>Technology in Healthcare</h3>
                <p>Explore the impact of technology on healthcare, discussing telemedicine, health apps, and other digital health solutions.</p>
                <a href="#" class="btn"> learn more <span class="fas fa-chevron-right"></span> </a>
            </div>
        </div>
        <div class="box">
            <div class="image">
                <img src="image/blog-5.jpg" alt="">
            </div>
            <div class="content">
                <div class="icon">
                    <a href="#"> <i class="fas fa-user"></i> by Cristina Coronel </a>
                </div>
                <h3>Hospital Events and Achievements</h3>
                <p>Share updates on hospital achievements, awards, and special events to keep the community informed and engaged.</p>
                <a href="#" class="btn"> learn more <span class="fas fa-chevron-right"></span> </a>
            </div>
        </div>
        <div class="box">
            <div class="image">
                <img src="image/blog-6.jpg" alt="">
            </div>
            <div class="content">
                <div class="icon">
                    <a href="#"> <i class="fas fa-user"></i> by Cristina Coronel </a>
                </div>
                <h3>Patient Success Stories</h3>
                <p>Feature inspiring stories of patients who have overcome health challenges with the help of your hospital's care.</p>
                <a href="#" class="btn"> learn more <span class="fas fa-chevron-right"></span> </a>
            </div>
        </div>

    </div>

</section>

<!-- blogs section ends -->

<!-- footer section starts  -->

<section class="footer">

    <div class="box-container">

        <div class="box">
            <h3>quick links</h3>
            <a href="#home"> <i class="fas fa-chevron-right"></i> home </a>
            <a href="#about"> <i class="fas fa-chevron-right"></i> about </a>
            <a href="#services"> <i class="fas fa-chevron-right"></i> services </a>
            <a href="#doctors"> <i class="fas fa-chevron-right"></i> doctors </a>
            <a href="#appointment"> <i class="fas fa-chevron-right"></i> appointment </a>
            <a href="#review"> <i class="fas fa-chevron-right"></i> review </a>
            <a href="#blogs"> <i class="fas fa-chevron-right"></i> blogs </a>
        </div>

        <div class="box">
            <h3>our services</h3>
            <a href="#"> <i class="fas fa-chevron-right"></i> Diagnostic Imaging </a>
            <a href="#"> <i class="fas fa-chevron-right"></i> Primary Care Services </a>
            <a href="#"> <i class="fas fa-chevron-right"></i> Maternity and Pediatric Care </a>
            <a href="#"> <i class="fas fa-chevron-right"></i> Rehabilitation and Mental Therapy </a>
            <a href="#"> <i class="fas fa-chevron-right"></i> Senior Care Services </a>
        </div>

        <div class="box">
            <h3>appointment info</h3>
            <a href="#"> <i class="fas fa-phone"></i> +639975780122 </a>
            <a href="#"> <i class="fas fa-phone"></i> +639864671211 </a>
            <a href="#"> <i class="fas fa-envelope"></i> CAChospital@gmail.com </a>
            <a href="#"> <i class="fas fa-envelope"></i> CristinaAlcansareCoronel@gmail.com </a>
            <a href="#"> <i class="fas fa-map-marker-alt"></i> North Caloocan, Philippines </a>
        </div>

        <div class="box">
            <h3>follow us</h3>
            <a href="https://web.facebook.com/clinicquickaid"> <i class="fab fa-facebook"></i> facebook </a>
            <a href="#"> <i class="fab fa-twitter"></i> twitter </a>
            <a href="#"> <i class="fab fa-instagram"></i> instagram </a>
            <a href="#"> <i class="fab fa-linkedin"></i> linkedin </a>
            <a href="#"> <i class="fab fa-pinterest"></i> pinterest </a>
        </div>

    </div>

    <div class="credit"> | all rights reserved </div>

</section>

<!-- footer section ends -->


<!-- js file link  -->
<script src="js/script.js"></script>

</body>
</html>

