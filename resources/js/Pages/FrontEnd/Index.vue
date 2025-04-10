<template>
    <main id="main" class="main">
        <!-- Hero Section -->
        <section class="hero-section text-center py-5 text-white">
            <div class="container">
                <h1 class="display-4">{{ translate("Welcome to Jamia Darol Uloom Noumania Utmanzai") }}</h1>
                <h2>{{ translate("Charsadda Khyber PakhtunKhwa Pakistan") }}</h2>
<!--                 
                <p class="lead">
                    {{ translate("Providing quality Islamic education with modern learning techniques") }}.
                </p> -->
            </div>
        </section>

        <section class="courses-section py-2 bg-light">
            <div class="container">
                <h1 class="display-4 p-3 theme-text-color">{{ translate("Our Courses") }}</h1>
                <div class="row g-2">
                    <div
                        class="col-md-4 d-flex align-items-stretch"
                        v-for="(course, index) in courses"
                        :key="index"
                    >
                        <div class="card content-card">
                            <img
                                :src="course.image"
                                class="card-img-top"
                                alt="Course Image"
                            />
                            <div class="card-body">
                                <h5 class="card-title">{{ course.title }}</h5>
                                <p class="card-text">
                                    {{ course.description }}
                                </p>
                                <a href="#" class="btn btn-primary"
                                    >{{ translate("Enroll Now") }}</a
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="bayanaat-section py-2">
            <div class="container">
                <h1 class="display-4 p-3 theme-text-color">{{ translate("Latest Bayanaat") }}</h1>
                <div class="row g-2">
                    <div
                        class="col-md-4 d-flex align-items-stretch"
                        v-for="(video, index) in bayanaat"
                        :key="index"
                    >
                        <div class="card content-card">
                            <div class="video-wrapper">
                                <iframe
                                    :src="video.url"
                                    allowfullscreen
                                ></iframe>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">{{ video.title }}</h5>
                                <p class="card-text">{{ video.description }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Admission Open Section -->
        <section class="admission-section text-center py-5 text-white">
            <div class="container">
                <h2>{{ translate("Admissions Open") }}</h2>
                <p>
                    {{ translate("Register now and start your journey towards Islamic knowledge") }}.
                </p>
                <a href="/student/enroll" class="btn btn-light btn-lg"
                    >{{ translate("Apply Now") }}</a
                >
            </div>
        </section>
    </main>
</template>

<script>
import Master from "./Layout/MasterFront.vue";

export default {
    layout: Master,
    data() {
        return {
            courses: [
                {
                    title: "Quran Memorization",
                    description:
                        "Learn and memorize the Holy Quran with proper Tajweed.",
                    image: "https://images.squarespace-cdn.com/content/v1/5d016c1ba9f2e7000120c08c/1560579210527-7LDCZH62S91OLOJIKAE9/AdobeStock_87517185.jpeg",
                },
                {
                    title: "Islamic Studies",
                    description:
                        "Deep dive into Islamic history, Fiqh, and Hadith.",
                    image: "https://img.freepik.com/free-photo/top-view-islamic-new-year-concept_23-2148611689.jpg",
                },
                {
                    title: "Arabic Language",
                    description:
                        "Master the Arabic language and understand the Quran better.",
                    image: "https://images.squarespace-cdn.com/content/v1/61782ecbf6567d12f08ba3b9/72a3bc52-cdf5-49a8-8289-4454f6c00534/image-from-rawpixel-id-418053-jpeg.jpg",
                },
            ],
            bayanaat: [
                {
                    title: "The Importance of Salah",
                    description:
                        "Learn why Salah is the foundation of faith and how to perform it correctly.",
                    url: "https://www.youtube.com/embed/9eeeVTUJL9Q",
                },
                {
                    title: "Ramadan & Its Blessings",
                    description:
                        "Discover the spiritual significance of Ramadan and fasting.",
                    url: "https://www.youtube.com/embed/Li7ajCdomkk",
                },
                {
                    title: "Stories from the Quran",
                    description:
                        "A journey through the inspiring stories in the Quran.",
                    url: "https://www.youtube.com/embed/ckDDp9xaGW8",
                },
            ],
        };
    },
};
</script>

<style>


/* General Styles */
.hero-section,
.admission-section {
    margin-top: 70px;
    background-color: var(--primary-color);
}

/* Course & Video Cards */
.card {
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease-in-out;
}
.card:hover {
    transform: translateY(-5px);
}
.card-img-top {
    height: 200px;
    object-fit: cover;
}
.card-body {
    padding: 20px;
}
.btn-primary {
    background-color: var(--primary-color);
    border: none;
}
.btn-primary:hover {
    background-color: #011a4d;
}
/* Equal Height for All Cards */
.content-card {
    display: flex;
    flex-direction: column;
    height: 100%;
}

/* Ensure All Cards in a Row Have the Same Height */
.row {
    display: flex;
    flex-wrap: wrap;
}

/* Video Section Adjustments */
.video-wrapper {
    width: 100%;
    height: 250px; /* Adjust as needed */
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.video-wrapper iframe {
    width: 100%;
    height: 100%;
    object-fit: cover; /* Ensures the video covers the area */
}

/* Ensure Text & Buttons Align Properly */
.card-body {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

</style>
