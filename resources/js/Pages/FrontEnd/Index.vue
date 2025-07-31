<template>
    <main id="main" class="main">
        <!-- Hero Section -->
        <section class="hero-section text-center text-white position-relative">
            <img 
                :src="'/images/hero-image.jpg'"
                alt="background"
                class="hero-bg-image"
            />
            <div
                class="overlay position-absolute top-0 start-0 w-100 h-100"
            ></div>
            <div
                class="container py-5 position-relative z-1 c-hero-textual-contents"
            >
                <h1 class="display-4 fw-bold">
                    {{ translate("Jamia Darol Uloom Noumania Utmanzai") }}
                </h1>
                <h2 class="fs-4">
                    {{ translate("Charsadda Khyber PakhtunKhwa Pakistan") }}
                </h2>
                <p class="lead mt-3">
                    {{
                        translate(
                            "Providing quality Islamic education with modern learning techniques"
                        )
                    }}
                </p>
                <a
                    href="#courses"
                    class="btn btn-light btn-lg mt-3 shadow rounded-pill"
                >
                    {{ translate("Explore Courses") }}
                </a>
            </div>
        </section>

        <!-- Courses Section -->
        <section
            class="courses-section py-5 bg-light c-jameel-noori"
            id="courses"
        >
            <div class="container">
               <h1 class="display-5 mb-4 theme-text-color fw-bold">
                    {{ translate("Our Courses") }}
                </h1>
                <div class="row g-4">
                    <div
                        class="col-md-3"
                        v-for="(course, index) in filterOptions"
                        :key="index"
                    >
                        <div class="course-box" @click="goToEnroll(course)">
                            <h5 >{{ course }}</h5>

                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Bayanaat Section -->
        <section class="bayanaat-section py-5">
            <div class="container">
                <h1 class="display-5 mb-4 theme-text-color fw-bold">
                    {{ translate("Latest Bayanaat") }}
                </h1>
                <div class="row g-4">
                    <div
                        class="col-md-4 d-flex align-items-stretch"
                        v-for="(video, index) in bayanaat"
                        :key="index"
                    >
                        <div class="card content-card shadow">
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
        <section class="admission-section text-center text-white py-5">
            <div class="container">
                <h2 class="display-5 fw-bold">
                    {{ translate("Admissions Open") }}
                </h2>
                <p class="lead">
                    {{
                        translate(
                            "Register now and start your journey towards Islamic knowledge"
                        )
                    }}
                </p>

                <a
                    href="/student/enroll"
                    class="btn btn-light btn-lg rounded-pill shadow"
                >
                    {{ translate("Apply Now") }}
                </a>
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
            filterOptions: [
                "تحصّص بالفقہ ایک سال",
                "تحصّص بالفقہ دو سال",
                "تحصّص باللغات",
                "دورہ حدیث",
                "درجہ سابعہ",
                "درجہ سادسہ",
                "درجہ خامسہ",
                "درجہ رابعہ",
                "درجہ ثالثہ",
                "درجہ ثانیہ",
                "درجہ اولیٰ",
                "متوسطا",
            ],
            bayanaat: [
                {
                    title: this.translate(
                        "Molana Muhammad Idrees Sahib Pashto Bayan – Juma 20 06 2025"
                    ),
                    description: this.translate(
                        "Molana Muhammad Idrees Sahib’s Pashto Bayan delivered on Friday, 20 June 2025."
                    ),
                    url: "https://www.youtube.com/embed/KfVv1GGVFYU",
                },
                {
                    title: this.translate(
                        "Molana Muhammad Idrees Sahib New Pashto Bayan – 05 01 2025"
                    ),
                    description: this.translate(
                        "New Pashto bayan by Molana Muhammad Idrees Sahib (January 5, 2025)."
                    ),
                    url: "https://www.youtube.com/embed/c4RyVepLm40",
                },
                {
                    title: this.translate(
                        "Molana Muhammad Idrees Sahib Bayan – July 2025"
                    ),
                    description: this.translate(
                        "Powerful new bayan by Molana Muhammad Idrees Sahib uploaded in July 2025."
                    ),
                    url: "https://www.youtube.com/embed/TEJywc1RpPQ",
                },
            ],
        };
    },
    methods: {
        goToEnroll(courseName) {
            const encoded = encodeURIComponent(courseName);
            window.location.href = `/student/enroll?course=${encoded}`;
        },
    },
};
</script>

<style>
.hero-section {
    background-color: #023f86;
    position: relative;
    overflow: hidden;
    padding: 0;
}

.hero-section {
    position: relative;
    height: 600px; /* or 600px if you want it taller */
    overflow: hidden;
}

.hero-bg-image {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    z-index: 0;
}

.overlay {
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1;
}
.c-hero-textual-contents {
    margin-top: 140px;
}
.course-box {
    background-color: #023f86;
    color: white;
    text-align: center;
    padding: 2rem;
    border-radius: 1.25rem;
    height: 100%;
    font-weight: 600;
    font-size: 1.15rem;
    transition: background-color 0.3s ease, transform 0.3s ease;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    font-family: "Jameel Noori Nastaleeq", serif !important;
}

.course-box:hover {
    background-color: #035bb8;
    transform: scale(1.05);
    cursor: pointer;
}

.video-wrapper {
    width: 100%;
    height: 250px;
    overflow: hidden;
}

.video-wrapper iframe {
    width: 100%;
    height: 100%;
    border: 0;
}

.card.content-card {
    border-radius: 1rem;
    overflow: hidden;
    transition: transform 0.3s ease;
}

.card.content-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
}

.card-body {
    padding: 20px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.admission-section {
    background: linear-gradient(120deg, #023f86, #035bb8);
}
</style>
