<template>
    <main id="main" class="main">
        <!-- Hero Section Carousel -->
        <section class="hero-section text-white position-relative">
            <div
                id="aboutCarousel"
                class="carousel slide carousel-fade"
                data-bs-ride="carousel"
            >
                <!-- Indicators -->
                <div class="carousel-indicators">
                    <button
                        type="button"
                        data-bs-target="#aboutCarousel"
                        data-bs-slide-to="0"
                        class="active"
                    ></button>
                    <button
                        type="button"
                        data-bs-target="#aboutCarousel"
                        data-bs-slide-to="1"
                    ></button>
                    <button
                        type="button"
                        data-bs-target="#aboutCarousel"
                        data-bs-slide-to="2"
                    ></button>
                    <button
                        type="button"
                        data-bs-target="#aboutCarousel"
                        data-bs-slide-to="3"
                    ></button>
                    <button
                        type="button"
                        data-bs-target="#aboutCarousel"
                        data-bs-slide-to="4"
                    ></button>
                </div>

                <!-- Carousel Items -->
                <div class="carousel-inner">
                    <div class="carousel-item active position-relative">
                        <img
                            :src="'/images/about-image.jpg'"
                            class="d-block w-100 hero-carousel-img"
                            alt="Image 1"
                        />
                        <div class="carousel-overlay"></div>
                        <div
                            class="carousel-caption d-block text-center px-2 px-md-5"
                        >
                            <h1 class="h3 h1-md fw-bold">
                                {{ translate("Jamia Introduction") }}
                            </h1>
                            <p class="lead">
                                {{
                                    translate(
                                        "Jamia Darul Uloom Noumania is a trusted Islamic institution offering faith-based education, character development, and scholarly guidance to students from all backgrounds."
                                    )
                                }}
                            </p>
                        </div>
                    </div>

                    <div class="carousel-item position-relative">
                        <img
                            :src="'/images/about-image3.jpg'"
                            class="d-block w-100 hero-carousel-img"
                            alt="Image 2"
                        />
                        <div class="carousel-overlay"></div>
                        <div
                            class="carousel-caption d-block text-center px-2 px-md-5"
                        >
                            <h1 class="h3 h1-md fw-bold">
                                {{ translate("Educational Objectives") }}
                            </h1>
                            <p class="lead">
                                {{
                                    translate(
                                        "Our primary goal is to connect the new generation with authentic Islamic teachings, instill moral values, and equip them to face modern challenges with a firm foundation in Deen."
                                    )
                                }}
                            </p>
                        </div>
                    </div>

                    <div class="carousel-item position-relative">
                        <img
                            :src="'/images/about-image2.jpg'"
                            class="d-block w-100 hero-carousel-img"
                            alt="Image 3"
                        />
                        <div class="carousel-overlay"></div>
                        <div
                            class="carousel-caption d-block text-center px-2 px-md-5"
                        >
                            <h1 class="h3 h1-md fw-bold">
                                {{ translate("Environment & System") }}
                            </h1>
                            <p class="lead">
                                {{
                                    translate(
                                        "We offer a peaceful and spiritually uplifting environment, where students benefit from structured learning, personal mentorship, and the guidance of highly qualified scholars and educators."
                                    )
                                }}
                            </p>
                        </div>
                    </div>

                    <div class="carousel-item position-relative">
                        <img
                            :src="'/images/about-image4.jpg'"
                            class="d-block w-100 hero-carousel-img"
                            alt="Image 4"
                        />
                        <div class="carousel-overlay"></div>
                        <div
                            class="carousel-caption d-block text-center px-2 px-md-5"
                        >
                            <h1 class="h3 h1-md fw-bold">
                                {{ translate("Modern Facilities") }}
                            </h1>
                            <p class="lead">
                                {{
                                    translate(
                                        "Jamia is equipped with a well-stocked library, digital resources, clean dormitories, and well-maintained classrooms that support both traditional and contemporary Islamic education."
                                    )
                                }}
                            </p>
                        </div>
                    </div>

                    <div class="carousel-item position-relative">
                        <img
                            :src="'/images/about-image5.jpg'"
                            class="d-block w-100 hero-carousel-img"
                            alt="Image 5"
                        />
                        <div class="carousel-overlay"></div>
                        <div
                            class="carousel-caption d-block text-center px-2 px-md-5"
                        >
                            <h1 class="h3 h1-md fw-bold">
                                {{ translate("Our Leadership") }}
                            </h1>
                            <p class="lead">
                                {{
                                    translate(
                                        "Guided by esteemed scholars and educational leaders, Jamia Darul Uloom Noumania maintains excellence in Islamic education, combining tradition with visionary leadership and care."
                                    )
                                }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Carousel Caption -->

                <!-- Controls -->
                <button
                    class="carousel-control-prev"
                    type="button"
                    data-bs-target="#aboutCarousel"
                    data-bs-slide="prev"
                >
                    <span
                        class="carousel-control-prev-icon"
                        aria-hidden="true"
                    ></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button
                    class="carousel-control-next"
                    type="button"
                    data-bs-target="#aboutCarousel"
                    data-bs-slide="next"
                >
                    <span
                        class="carousel-control-next-icon"
                        aria-hidden="true"
                    ></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </section>

        <!-- About Us Section -->
<section class="about-section py-5 bg-light">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="info-card shadow-sm bg-white p-4 rounded-4">
          <h2 class="display-5 fw-bold theme-text-color mb-3 text-center border-bottom pb-2">
            {{ translate("Who We Are") }}
          </h2>
          <p class="fs-5 text-muted text-center">
            {{
              translate(
                "Jamia Darol Uloom Noumania Utmanzai is dedicated to providing quality Islamic education integrated with modern learning techniques. Our mission is to spread the light of knowledge and help students develop a strong connection with their faith."
              )
            }}
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Our Vision & Mission -->
<section class="vision-mission-section py-5 bg-gradient-light">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="info-card shadow-sm bg-white p-4 rounded-4">
          <h2 class="display-5 fw-bold theme-text-color mb-3 text-center border-bottom pb-2">
            {{ translate("Our Vision & Mission") }}
          </h2>
          <p class="fs-5 text-muted text-center">
            {{
              translate(
                "Our vision is to create a generation of scholars who embody the true spirit of Islam, practicing and preaching with sincerity. We aim to provide an educational environment that nurtures both academic and spiritual growth."
              )
            }}
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Leadership Section -->
<section class="leadership-section py-5 bg-light">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="info-card shadow-sm bg-white p-4 rounded-4">
          <h2 class="display-5 fw-bold theme-text-color mb-3 text-center border-bottom pb-2">
            {{ translate("Our Leadership") }}
          </h2>
          <p class="fs-5 text-muted text-center">
            {{
              translate(
                "Under the guidance of esteemed scholars and educators, Jamia Darul Uloom Noumania continues to uphold the highest standards of Islamic education."
              )
            }}
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

    </main>
</template>

<script>
import Master from "./Layout/MasterFront.vue";

export default {
    layout: Master,
};
</script>

<style>
.hero-section {
    margin-top: 60px;
    height: 500px;
    position: relative;
    background-color: #000;
}

.hero-carousel-img {
    height: 500px;
    object-fit: cover;
    filter: brightness(0.65);
}

.carousel-caption {
    position: absolute;
    bottom: 30%;
    z-index: 10;
}

.carousel-indicators [data-bs-target] {
    background-color: white;
    width: 10px;
    height: 10px;
    border-radius: 100%;
}
.carousel-item {
    position: relative;
}

.carousel-overlay {
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
    background: rgba(0, 0, 0, 0.4); /* Adjust opacity as needed */
    z-index: 1;
}

.carousel-caption {
    z-index: 2;
}
.bg-gradient-light {
  background: linear-gradient(120deg, #f8f9fa, #ffffff);
}

.info-card {
  transition: all 0.3s ease;
}
.info-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 6px 24px rgba(0, 0, 0, 0.08);
}

</style>
