<?php
session_start();
require("config.php");
if (!isset($_COOKIE["id"])) {
    header("Location: signUp_logIn_Form.php");
    exit();
} else
    $Uid = intval($_COOKIE['id']); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title>Home</title>
</head>

<body>
    <header>
        <h2 style="margin: 1em;color: white;font-family: cursive;">MedLeb</h2>
        <div>
            <div class="navbar">
                <button class="nav-button active" onclick="toggleMainContent('home', this)">Home</button>
                <!-- <button class="nav-button" onclick="toggleMainContent('sos', this)">SOS</button> -->
                <button class="nav-button" onclick="toggleMainContent('appointments', this)">Appointments</button>
                <button class="nav-button" onclick="toggleMainContent('bookAppointment', this)">Book Appointment</button>
                <!-- <button class="nav-button" onclick="toggleMainContent('community', this)">Community Hub</button> -->
                <button class="nav-button" onclick="toggleMainContent('records', this)">Records</button>
            </div>
            <div class="selector">
                <div class="left"></div>
                <div class="right"></div>
            </div>
        </div>
        <div class="profile">
            <div class="signIn">
                <?php

                $sql = "SELECT name FROM patient where id=$Uid";
                $result = mysqli_query($con, $sql);
                $row = mysqli_fetch_array($result);

                if (isset($_COOKIE["uname"])) {
                    echo '<span class="profile" style="cursor:pointer;align-self: center;font-size: x-large;color:white;">' . $row["name"] . '</span>';
                    echo '<form action="logOut.php" method="post" style="display:flex;">
                              <button type="submit" style="cursor:pointer;border:none;background:none;color:inherit;padding:0;width: 6em;text-decoration: underline;font-size: large;align-self: center;margin:0;">Log Out</button>
                          </form>';
                } else {
                    echo '<a href="signUp_logIn_Form.php">Sign In</a>';
                }
                ?>
            </div>
        </div>
    </header>

    <main id="home">
        <!-- Home Content -->
        <style>
            #blog {
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
                padding: 40px;
                border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            }

            .blog-heading {
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
            }

            .blog-heading span {
                color: #ccab99;
            }

            .blog-heading h3 {
                font-size: 2.4rem;
                color: #2b2b2b;
                font-weight: 600;

            }

            .blog-container {
                display: flex;
                justify-content: center;
                align-items: center;
                margin: 20px 0px;
                flex-wrap: wrap;
            }

            .blog-box {
                width: 350px;
                background-color: #ffffff;
                border: 1px solid #ececec;
                margin: 20px;
            }

            .blog-img {
                width: auto;
                height: 250px;

            }

            .blog-img img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                object-position: center;

            }

            .blog-text {
                padding: 30px;
                display: flex;
                flex-direction: column;
            }

            .blog-text span {
                color: #ccab99;
                font-size: 0.9rem;
                margin-left: -30px;
                margin-top: -30px;
            }

            .blog-text .blog-title {
                padding-top: 30px;
                font-size: 1.3rem;
                font-weight: 500;
                color: #272727;
            }

            .blog-text .blog-title:hover {
                color: #ccab99;
                transition: all ease 0.3s;
            }

            .blog-text p {
                color: #9b9b9b;
                font-size: 0.9rem;
                display: -webkit-box;
                -webkit-line-clamp: 3;
                -webkit-box-orient: vertical;
                overflow: hidden;
                text-overflow: ellipsis;
                margin: 20px 0px;

            }

            .blog-text a {
                color: #0f0f0f;
            }

            .blog-text a:hover {
                color: #ccab99;
                transition: all ease 0.3s;

            }


            @media(max-width:1250px) {
                .blog-box {
                    width: 300px;
                }
            }



            #testimonials {
                display: flex;
                width: 100%;
                height: 100%;

                flex-direction: column;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
            }

            .testimonials-container {
                max-width: 1120px;
                width: 90%;
                padding: 50px 0px;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
            }

            .testimonials-heading-main h3 {
                font-size: 2.4rem;
                color: #2b2b2b;
                font-weight: 600;
                text-align: center;
            }

            .t-heading-slider span {
                color: #ccab99;
                font-size: 0.9rem;
            }

            .t-heading-slider {
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
            }

            .testimonials-slider {
                width: 100%;
                margin: 50px;
                height: 100%;
                position: relative;
            }

            .t-slider-box {
                display: grid;
                grid-template-columns: 343px 1fr;
                width: 100%;
                height: 100%;
            }

            .t-slider-box-img {
                display: flex;
                width: 100%;
                height: 100%;
            }

            .t-slider-box-img img {
                width: 100%;
                height: 411px;
                object-fit: cover;
                object-position: center;
            }

            .t-slider-box-text {
                padding: 0px;
                display: flex;
                flex-direction: column;
                justify-content: center;
                background-color: #ffffff;
                height: 100%;
                overflow: hidden;
                max-width: 0px;
            }

            .mySwiper .swiper-slide-active .t-slider-box-text {
                max-width: 100%;
                padding: 0px 2em;
                animation: animation 1s;
            }

            .mySwiper .swiper-slide-active .t-slider-box {
                width: 90%;
                margin-right: auto;
            }

            @keyframes animation {
                0% {
                    max-width: 0%;
                    padding: 0px;

                }

                30% {
                    max-width: 0%;
                    padding: 0px;
                }

                100% {
                    max-width: 100%;
                    padding: 0em 2em;
                }
            }

            .t-slider-box-text h6 {
                font-size: 27px;
                color: #1f1f1f;
                font-weight: 500;
                overflow: hidden;
                text-overflow: ellipsis;
                display: -webkit-box;
                -webkit-line-clamp: 1;
                -webkit-box-orient: vertical;
            }

            .t-slider-box-text strong {
                color: #ccab99;
                font-size: 20px;
                font-weight: 500;
            }

            .t-slider-box-text-container {
                display: none;
                flex-direction: column;
                align-items: flex-start;
                justify-content: flex-start;
                width: 100%;
                height: 230px;
                margin-top: 20px;
                padding-right: 15px;
                overflow: scroll;
                animation: fade 2s;
            }

            .mySwiper .swiper-slide-active .t-slider-box-text-container {
                display: flex;
            }

            @keyframes fade {
                0% {
                    opacity: 0;
                }

                100% {
                    opacity: 1;
                }
            }

            .t-slider-box-text-container span {
                font-size: 16px;
                font-style: italic;
                color: #000000;
                margin-bottom: 10px;
            }

            .t-slider-box-text-flow {
                display: flex;
                flex-direction: column;
            }

            .t-slider-box-text-container p {
                color: #313131;
                font-size: 16px;
                margin-bottom: 20px;
                letter-spacing: 0.2px;
            }

            .t-slider-box-text-container p:nth-child(2) {
                margin-top: 10px;
            }

            .t-slider-box-text-container p:last-child {
                margin-top: 0px;
            }

            .t-slider-box-text-container::-webkit-scrollbar {
                width: 10px;
            }

            .t-slider-box-text-container::-webkit-scrollbar-track {
                background-color: #f1f1f1;
            }

            .t-slider-box-text-container::-webkit-scrollbar-thumb {
                background: #888;
            }

            .t-slider-box-text-container::-webkit-scrollbar-thumb:hover {
                background-color: #555;
            }

            .slider-btns {
                max-width: 1200px;
                display: flex;
                justify-content: space-between;
                position: absolute;
                z-index: 110;
                left: 50%;
                top: 50%;
                transform: translate(-50%, -50%);
                width: 100%;
            }

            .swiper-button-next,
            .swiper-button-prev {
                position: static !important;
            }

            .swiper-button-next {
                margin-right: -50px;
            }

            .swiper-button-prev {
                margin-left: -50px;
            }

            .swiper-button-next::after,
            .swiper-button-prev::after {
                color: #2b2b2b;
                text-shadow: 2px 2px 16px rgba(16, 92, 179, 0.22);
                font-size: 32px !important;
            }






            #contact {
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
                padding: 0px;
                border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            }

            .contact-heading {
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
            }

            .contact-heading span {
                color: #ccab99;
            }

            .contact-heading h3 {
                font-size: 2.4rem;
                color: #2b2b2b;
                font-weight: 600;
            }

            .container {
                width: 80%;
                background-color: #fff;
                border-radius: 6px;
                padding: 30px 60px 40px 40px;
                box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
                margin: 50px;
            }

            .content {
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .container.content {
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .left-side {
                width: 25%;
                height: 100%;
                position: relative;
                margin-top: 15px;


            }

            .content .left-side::before {
                content: '';
                position: absolute;
                height: 70%;
                width: 2px;
                background: #afafb6;
                right: -15px;
                top: 50%;
                transform: translateY(-50%);

            }

            .right-side {
                width: 75%;
                margin-left: 75px;
            }

            .left-side.details {
                margin: 14px;
                text-align: center;
            }

            .details i {
                font-size: 30px;
                color: #ccab99;
                margin-bottom: 10px;
            }

            .topic {
                font-size: 18px;
                font-weight: 500;
            }

            .text-one,
            .text-two {
                font-size: 14px;
                color: #afafb6;
            }

            .topic-text {
                font-size: 23px;
                font-weight: 600;
                color: #ccab99;
            }

            .input-box {
                height: 50px;
                width: 100%;
                margin: 12px 0;
            }

            .input-box input,
            textarea {
                height: 100%;
                width: 100%;
                border: none;
                background: #F0F1F8;
                border-radius: 6px;
                font-size: 16px;
                padding: 0 15px;
                resize: none;

            }

            .message-box {
                min-height: 110px;


            }

            .button {
                margin-top: 6px;
                display: inline-block;

            }

            .button input[type="button"] {
                color: #fff;
                font-size: 18px;
                outline: none;
                border: none;
                padding: 8px 16px;
                border-radius: 6px;
                background: #ccab99;
                cursor: pointer;
                transition: all 0.3s ease;
            }

            .button input[type="button"]:hover {
                background: #ca9275;

            }
        </style>
        <section id="blog">
            <div class="blog-heading">

                <h3>health blog</h3>
                <span>about health</span>
            </div>

            <div class="blog-container">
                <div class="blog-box">
                    <div class="blog-img">
                        <img src="imgs/diet1.png" alt="blog">
                    </div>

                    <div class="blog-text">
                        <a href="https://pubmed.ncbi.nlm.nih.gov/31940634/" class="blog-title">Nutrition and Diet: </a>
                        <p>Diet and nutrition are fundamental in maintaining the general and oral health of populations. Diet refers to the total amount of food consumed by individuals; whereas nutrition is the process of utilising food for growth, </p>
                        <a href="https://pubmed.ncbi.nlm.nih.gov/31940634/">Read more...</a>


                    </div>
                </div>

                <div class="blog-box">
                    <div class="blog-img">
                        <img src="imgs/fitness.jpg" alt="blog">
                    </div>

                    <div class="blog-text">
                        <a href="https://www.health.harvard.edu/topics/exercise-and-fitness" class="blog-title">Exercise and Fitness:</a>
                        <p>Exercising regularly, every day if possible, is the single most important thing you can do for your health. In the short term, exercise helps to control appetite, boost mood, and improve sleep. In the long term, it reduces the risk of heart disease, stroke, diabetes, dementia, depression, and many cancers.</p>
                        <a href="https://www.health.harvard.edu/topics/exercise-and-fitness">Read more...</a>

                    </div>
                </div>


                <div class="blog-box">
                    <div class="blog-img">
                        <img src="imgs/sleep.jpg" alt="blog">
                    </div>

                    <div class="blog-text">
                        <a href="https://www.betterhealth.vic.gov.au/health/conditionsandtreatments/sleep-hygiene#:~:text='Sleep%20hygiene'%20refers%20to%20healthy,soon%20as%20changes%20are%20made." class="blog-title">Sleep Hygiene:</a>
                        <p>'Sleep hygiene' refers to healthy habits, behaviours and environmental factors that can be adjusted to help you have a good night's sleep. Some sleeping</p>
                        <a href="https://www.betterhealth.vic.gov.au/health/conditionsandtreatments/sleep-hygiene#:~:text='Sleep%20hygiene'%20refers%20to%20healthy,soon%20as%20changes%20are%20made.">Read more...</a>

                    </div>
                </div>


                <div class="blog-box">
                    <div class="blog-img">
                        <img src="imgs/water.jpg" alt="blog">
                    </div>

                    <div class="blog-text">
                        <a href="https://www.healthline.com/nutrition/7-health-benefits-of-water#1.-Helps-maximize-physical-performance" class="blog-title">Hydration and Water:</a>
                        <p>If you don’t stay hydrated, your physical performance can suffer.

                            This is particularly important during intense exercise or high heat.

                            Dehydration can have a noticeable effect if you lose as little as 2% of your body’s water content. However, it isn’t uncommon for athletes to lose as much as 6–10% of their water weight via sweat (1, 2).</p>
                        <a href="https://www.healthline.com/nutrition/7-health-benefits-of-water#1.-Helps-maximize-physical-performance">Read more...</a>
                    </div>
                </div>

                <div class="blog-box">
                    <div class="blog-img">
                        <img src="imgs/R.jpg" alt="blog">
                    </div>

                    <div class="blog-text">
                        <a href="https://en.wikipedia.org/wiki/Health_care" class="blog-title">Health Care</a>
                        <p>Health care, or healthcare, is the improvement of health via the prevention, diagnosis, treatment, amelioration or cure of disease, illness, injury, and other physical and mental impairments in people. Health care is delivered by health professionals and allied health fields. Medicine, dentistry, pharmacy, midwifery,</p>
                        <a href="https://en.wikipedia.org/wiki/Health_care">Read more...</a>
                    </div>
                </div>

                <div class="blog-box">
                    <div class="blog-img">
                        <img src="imgs/mental.webp" alt="blog">
                    </div>

                    <div class="blog-text">
                        <a href="https://www.cdc.gov/mentalhealth/learn/index.htm#:~:text=What%20is%20mental%20health%3F,1" class="blog-title">Mental Health:</a>
                        <p>What is mental health? Mental health includes our emotional, psychological, and social well-being. It affects how we think, feel, and act. It also helps determine how we handle stress, relate to others, and make healthy choices</p>
                        <a href="https://www.cdc.gov/mentalhealth/learn/index.htm#:~:text=What%20is%20mental%20health%3F,1">Read more...</a>
                    </div>
                </div>
            </div>
        </section>
        <section id="testimonials">
            <div class="testimonials-container">
                <div class="testimonials-heading-main">
                    <h3>Virus Protection</h3>
                </div>
                <div class="t-heading-slider">
                    <span>avoid infection</span>
                </div>

                <div class="testimonials-slider">
                    <div class="swiper mySwiper">
                        <div class="swiper-wrapper">

                            <div class="swiper-slide">
                                <div class="t-slider-box">
                                    <div class="t-slider-box-img">
                                        <img src="imgs/vacc.png" alt="">

                                    </div>
                                    <div class="t-slider-box-text">
                                        <h6>Vaccination</h6>
                                        <strong>Vaccine Vitality</strong>
                                        <div class="t-slider-box-text-container">
                                            <div class="t-slider-box-text-flow">
                                                <span>Empowering Health Through Vaccination Innovation</span>
                                                <p><b>Vaccine Vanguard:</b>In the realm of modern medicine, vaccines stand as the vanguard of defense against infectious diseases. </p>
                                                <p><b>Protective Shots:</b>Amidst the myriad challenges posed by infectious diseases, protective shots emerge as beacons of hope, fortifying individuals and communities against the relentless tide of contagion. Through a delicate dance of science and compassion, vaccines offer a shield of immunity, safeguarding lives and futures against the ravages of preventable illnesses. Join us as we unravel the intricate web of vaccine development, distribution, and deployment, shedding light on the profound role these protective shots play in shaping a healthier, more resilient world. Together, let us celebrate the triumphs, confront the challenges, and champion the lifesaving potential of vaccination.</p>
                                            </div>
                                        </div>

                                    </div>


                                </div>
                            </div>



                            <div class="swiper-slide">
                                <div class="t-slider-box">
                                    <div class="t-slider-box-img">
                                        <img src="imgs/hygine.jpg" alt="">

                                    </div>
                                    <div class="t-slider-box-text">
                                        <h6>Personal Hygiene</h6>
                                        <strong>Clean Living</strong>
                                        <div class="t-slider-box-text-container">
                                            <div class="t-slider-box-text-flow">
                                                <span>Empowering Health Through Daily Practices</span>
                                                <p><b>Hygiene Heroes:</b>Discover the unsung champions of health—simple yet powerful habits that form the cornerstone of personal hygiene. From handwashing to dental care, explore how these everyday practices safeguard against illness and promote overall well-being.</p>
                                                <p><b>Clean Routine:</b>Unlock the secrets to a cleaner, healthier lifestyle with our guide to establishing and maintaining effective personal hygiene routines. Learn how small actions can make a big difference in protecting yourself and those around you from harmful pathogens.</p>
                                            </div>
                                        </div>

                                    </div>


                                </div>
                            </div>

                            <div class="swiper-slide">
                                <div class="t-slider-box">
                                    <div class="t-slider-box-img">
                                        <img src="imgs/dis3.jpg" alt="">

                                    </div>
                                    <div class="t-slider-box-text">
                                        <h6>Physical Distancing</h6>
                                        <strong>Safe Gaps</strong>
                                        <div class="t-slider-box-text-container">
                                            <div class="t-slider-box-text-flow">
                                                <span>Creating Space, Saving Lives</span>
                                                <p><b>Distance Defenders:</b>Step into the world of distance defenders, where the act of physical distancing emerges as a powerful tool in the fight against contagious diseases. Explore the science behind social distancing measures and the profound impact they have on slowing the spread of infections and safeguarding public health.</p>
                                                <p><b>Safe Separation:</b>Delve into the concept of safe separation and its critical role in protecting individuals and communities from the transmission of infectious diseases. From understanding the principles of physical distancing to implementing practical strategies in daily life, learn how this simple yet effective practice can make a significant difference in curbing the spread of illness.</p>
                                            </div>
                                        </div>

                                    </div>


                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="t-slider-box">
                                    <div class="t-slider-box-img">
                                        <img src="imgs/mask.webp" alt="">

                                    </div>
                                    <div class="t-slider-box-text">
                                        <h6>Wearing Masks</h6>
                                        <strong>Mask Protection</strong>
                                        <div class="t-slider-box-text-container">
                                            <div class="t-slider-box-text-flow">
                                                <span>Embracing Protection with Masks</span>
                                                <p><b>Masked Vigilance:</b>Explore the pivotal role of face masks in our collective defense against airborne threats. From their humble origins to modern adaptations, discover how these simple yet indispensable accessories have become emblematic of vigilance and resilience in the face of adversity</p>
                                                <p><b>Mask Magic:</b>Uncover the transformative power of masks as both practical tools and symbols of unity. Journey through the artistry, innovation, and cultural significance of mask-wearing, and witness firsthand the magic of protecting oneself and others through this timeless tradition</p>
                                            </div>
                                        </div>

                                    </div>


                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="t-slider-box">
                                    <div class="t-slider-box-img">
                                        <img src="imgs/clean.jpg" alt="">

                                    </div>
                                    <div class="t-slider-box-text">
                                        <h6>Environmental Cleaning and Disinfection</h6>
                                        <strong>Cleanliness Crusade</strong>
                                        <div class="t-slider-box-text-container">
                                            <div class="t-slider-box-text-flow">
                                                <span>Championing Health Through Spotless Spaces</span>
                                                <p><b>Clean Sweep Solutions:</b>Embark on a journey of cleanliness with our comprehensive guide to environmental cleaning and disinfection. From effective techniques to eco-friendly products, discover the keys to maintaining pristine spaces and promoting optimal health for all</p>
                                                <p><b>Sanitize Smartly:</b>Empower yourself with the knowledge and tools to create hygienic environments through strategic cleaning and disinfection practices. Learn how to navigate the complexities of sanitation effectively, ensuring safety and well-being in every space you inhabit.</p>
                                            </div>
                                        </div>

                                    </div>


                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="slider-btns">
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div>

                    </div>


                </div>
        </section>
        <br>
        <hr>
        <br>
        <div style="display: flex;flex-direction: column;align-items: center;">
            <h1>Feeling Sick?</h1>
            <h2>Try our Newest Feature</h2>
            <a href="http://127.0.0.1:5000/rundiagnostics">press here</a>
        </div>
        <br>
        <hr>
        <br>
        <br>
        <br>

        <section id="contact">

            <div class="contact-heading">

                <h3>Contact us</h3>
                <span>Ask a question</span>
            </div>
            <div class="container">
                <div class="content">
                    <div class="left-side">
                        <div class="details">
                            <i class="fas fa-map-marker-alt"></i>
                            <div class="topic">address</div>
                            <div class="text-one">Lebanon</div>
                            <div class="text-two">Beirut-Road69</div>

                        </div>
                        <div class="details">
                            <i class="fas fa-phone-alt"></i>
                            <div class="topic">phone</div>
                            <div class="text-one">+961 70 000 000</div>
                            <div class="text-two">+961 80 000 000</div>

                        </div>
                        <div class="details">
                            <i class="fas fa-envelope"></i>
                            <div class="topic">email</div>
                            <div class="text-one">MedLeb@gmail.com</div>
                            <div class="text-two">HosLeb@gmail.com</div>

                        </div>

                    </div>
                    <div class="right-side">
                        <div class="topic-text">
                            send us a message
                        </div>
                        <p>Welcome to our health blog! Have a question about your health or wellness? Our contact form is your direct line to answers. Whether you're seeking advice on a specific condition, need clarification on a medical topic, or simply want reliable information, we're here to help.</p>

                        <form action="#">
                            <div class="input-box">
                                <input type="text" placeholder="enter your name">
                            </div>
                            <div class="input-box">
                                <input type="text" placeholder="enter your email">
                            </div>
                            <div class="message-box">
                                <textarea></textarea>
                            </div>
                            <div class="button">
                                <input type="button" value="send">
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </section>



        <!-- Swiper JS -->
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

        <!-- Initialize Swiper -->
        <script>
            var swiper = new Swiper(".mySwiper", {
                effect: "coverflow",
                grabCursor: true,
                centeredSlides: true,
                slidesPerView: "auto",
                loop: true,
                coverflowEffect: {
                    rotate: 0,
                    stretch: 70,
                    depth: 40,
                    modifier: 4,
                    slideShadows: false,
                },
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
            });
        </script>
    </main>

    <!-- <main id="sos" style="display: none;">
        SOS Content
        <p id="demo1">
            <input id="location" onclick="getLocation()" placeholder="Your location" required>
        </p>

        <script>
            function getLocation() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(showPosition);
                } else {
                    var x = document.getElementById("location");
                    x.value = "Geolocation is not supported by this browser.";
                }
            }

            function showPosition(position) {
                var x = document.getElementById("demo1");
                x.innerHTML = position.coords.latitude + ", " + position.coords.longitude;
            }
        </script>

    </main> -->



    <main id="appointments" style="display: none;">
        <?php
        // Assuming $con is your established database connection and $Uid is properly sanitized
        $sql = "SELECT doctor.name, doctor.phone, doctor.email, doctor.spec, appointment.day, appointment.time FROM appointment INNER JOIN doctor ON appointment.d_id = doctor.id WHERE appointment.p_id = ? ORDER BY doctor.email";

        if ($stmt = $con->prepare($sql)) {
            $stmt->bind_param("i", $Uid);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo "<table style='width: -webkit-fill-available; text-align: center; border-collapse: collapse;'>
                    <thead>
                        <tr style='background:#e9edf2;'>
                            <th style='padding: 1rem 0rem; color: #444; font-size: .9rem;'>Doctor</th>
                            <th style='padding: 1rem 0rem; color: #444; font-size: .9rem;'>Spec</th>
                            <th style='padding: 1rem 0rem; color: #444; font-size: .9rem;'>Day</th>
                            <th style='padding: 1rem 0rem; color: #444; font-size: .9rem;'>Time</th>
                            <th style='padding: 1rem 0rem; color: #444; font-size: .9rem;'>Action</th>
                        </tr>
                    </thead>
                    <tbody>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr style='border-bottom: 1px solid #dee2e8;'>
                        <td style='padding: 1rem 0rem; color: #444;'>" . htmlspecialchars($row["name"]) . "</td>
                        <td style='padding: 1rem 0rem; color: #444;'>" . htmlspecialchars($row["spec"]) . "</td>
                        <td style='padding: 1rem 0rem; color: #444;'>" . htmlspecialchars($row["day"]) . "</td>
                        <td style='padding: 1rem 0rem; color: #444;'>" . htmlspecialchars($row["time"]) . "</td>
                        <td style='padding: 1rem 0rem; color: #444;'><a href='tel:+961" . htmlspecialchars($row["phone"]) . "'>cancel</a></td>
                      </tr>";
                }
                echo "</tbody></table>";
            } else {
                echo "No results";
            }

            $stmt->close();
        } else {
            echo "Error preparing the statement: " . $con->error;
        }
        ?>
    </main>





    <main id="bookAppointment" style="display: none;">
        <form action="bookAppointment.php" method="post">
            <table style='width: -webkit-fill-available; text-align: center; border-collapse: collapse;'>
                <thead>
                    <tr style='background:#e9edf2;'>
                        <th style='padding: 1rem 0rem; color: #444; font-size: .9rem;'>Profession</th>
                        <th style='padding: 1rem 0rem; color: #444; font-size: .9rem;'>Doctor</th>
                        <th style='padding: 1rem 0rem; color: #444; font-size: .9rem;'>Day</th>
                        <th style='padding: 1rem 0rem; color: #444; font-size: .9rem;'>Time</th>
                        <th style='padding: 1rem 0rem; color: #444; font-size: .9rem;'>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style='border-bottom: 1px solid #dee2e8;'>
                        <td style='padding: 1rem 0rem; color: #444;'> <select name="spec" id="specSelect" required>
                                <?php
                                // Include your database connection
                                require("config.php");

                                // Fetch distinct specialties
                                $sql = "SELECT DISTINCT spec FROM doctor";
                                if ($result = mysqli_query($con, $sql)) {
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_array($result)) {
                                            echo '<option value="' . $row['spec'] . '">' . $row['spec'] . '</option>';
                                        }
                                    }
                                }
                                ?>
                            </select></td>
                        <td style='padding: 1rem 0rem; color: #444;'><select name="name" id="nameSelect" required>
                                <!-- Options will be dynamically populated based on the selection in the first select -->
                            </select></td>

                        <td style='padding: 1rem 0rem; color: #444;'><input type="date" id="daySelect" required name="day">
                        </td>
                        <td style='padding: 1rem 0rem; color: #444;'> <select name="time" id="timeSelect" required>
                                <!-- Options will be dynamically populated based on the selected date -->
                            </select></td>
                        <td style='padding: 1rem 0rem; color: #444;'><input type="submit" value="submit"></td>
                    </tr>
                </tbody>
            </table>
        </form>

        <script>
            document.getElementById('specSelect').addEventListener('change', function() {
                var selectedSpec = this.value;

                fetch('getDoctorNames.php?spec=' + selectedSpec)
                    .then(response => response.text())
                    .then(data => {
                        document.getElementById('nameSelect').innerHTML = data;
                    });
            });

            document.getElementById('daySelect').addEventListener('change', function() {
                var selectedDoctor = document.getElementById('nameSelect').value;
                var selectedDay = this.value;

                if (selectedDoctor && selectedDay) {
                    fetch('getAvailableTimes.php?doctor=' + selectedDoctor + '&day=' + selectedDay)
                        .then(response => response.json())
                        .then(data => {
                            var timeSelect = document.getElementById('timeSelect');
                            timeSelect.innerHTML = '';

                            data.forEach(function(time) {
                                var option = document.createElement('option');
                                option.value = time;
                                option.textContent = time;
                                timeSelect.appendChild(option);
                            });
                        });
                }
            });

            document.addEventListener("DOMContentLoaded", function() {
                var input = document.getElementById("daySelect");
                var today = new Date();
                var minDate = today.toISOString().split('T')[0];
                input.min = minDate;
            });
        </script>

    </main>

    <!-- <main id="community" style="display: none;">
        <h1>Future Plans</h1>
    </main> -->

    <main id="records" style="display: none;">
        <h2>Medical Records</h2>
        <br>
        <?php
        $query = "SELECT r.prescription, r.file, d.name AS doctor_name, d.email, d.spec FROM records r JOIN doctor d ON r.d_id = d.id WHERE r.p_id = ? ORDER BY d.email";
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $Uid);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<table style='width: -webkit-fill-available;text-align: center;border-collapse: collapse;'><thead><tr style='background:#e9edf2;'><th style='padding: 1rem 0rem;color: #444;font-size: .9rem;'>Doctor</th><th style='padding: 1rem 0rem;color: #444;font-size: .9rem;'>Spec</th><th style='padding: 1rem 0rem;color: #444;font-size: .9rem;'>Prescription</th><th style='padding: 1rem 0rem;color: #444;font-size: .9rem;'>file</th></tr></thead><tbody>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr style='border-bottom: 1px solid #dee2e8;'>
                <td style='padding: 1rem 0rem;color: #444;'>" . htmlspecialchars($row["doctor_name"]) . "</td>
                <td style='padding: 1rem 0rem;color: #444;'>" . htmlspecialchars($row["spec"]) . "</td>
                <td style='padding: 1rem 0rem;color: #444;'>" . htmlspecialchars($row["prescription"]) . "</td>
                <td style='padding: 1rem 0rem;color: #444;'>";
                if (!empty($row['file'])) {
                    echo "<a href='records/" . htmlspecialchars($row['file']) . "' download>Download File</a>
                  <a href='records/" . htmlspecialchars($row['file']) . "' target='_blank'>View File</a>";
                }
                echo "</td></tr>";
            }
            echo "</tbody></table>";
        } else {
            echo '<p>No records found.</p>';
        }
        ?>
    </main>


    <script src="script.js"></script>
</body>

</html>