<template>
    <main id="main" class="main">
        <!-- ===================== Hero (Parallax) ===================== -->
        <section
            class="hero-section text-center text-white position-relative overflow-hidden"
        >
            <!-- Parallax bg handled via CSS background -->
            <div
                class="overlay position-absolute top-0 start-0 w-100 h-100"
            ></div>

            <!-- Decorative bubbles -->
            <span class="orb orb-1"></span>
            <span class="orb orb-2"></span>
            <span class="orb orb-3"></span>

            <div class="container position-relative z-1">
                <div class="hero-content mx-auto">
                    <h1 class="display-4 fw-bold hero-title">
                        {{ translate("Jamia Darol Uloom Noumania Utmanzai") }}
                    </h1>
                    <h2 class="fs-5 opacity-90 mb-3">
                        {{ translate("Charsadda Khyber PakhtunKhwa Pakistan") }}
                    </h2>
                    <p class="lead opacity-95 mw-740 mx-auto">
                        {{
                            translate(
                                "Providing quality Islamic education with modern learning techniques"
                            )
                        }}
                    </p>
                    <div
                        class="mt-4 d-flex justify-content-center gap-3 flex-wrap"
                    >
                        <a
                            href="#courses"
                            class="btn btn-light btn-lg rounded-pill px-4 shadow hero-cta"
                        >
                            <i class="bi bi-journal-text me-2"></i
                            >{{ translate("Explore Courses") }}
                        </a>
                        <a
                            href="/student/enroll"
                            class="btn btn-outline-light btn-lg rounded-pill px-4"
                        >
                            <i class="bi bi-box-arrow-in-right me-2"></i
                            >{{ translate("Apply Now") }}
                        </a>
                    </div>
                </div>

                <!-- Quick stats -->
                <div class="row g-3 mt-5 justify-content-center">
                    <div class="col-6 col-md-3">
                        <div class="glass stat-card">
                            <div class="stat-icon">
                                <i class="bi bi-people"></i>
                            </div>
                            <div class="stat-value">5,000+</div>
                            <div class="stat-label">
                                {{ translate("Students Guided") }}
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="glass stat-card">
                            <div class="stat-icon">
                                <i class="bi bi-mortarboard"></i>
                            </div>
                            <div class="stat-value">12</div>
                            <div class="stat-label">
                                {{ translate("Active Programs") }}
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="glass stat-card">
                            <div class="stat-icon">
                                <i class="bi bi-camera-video"></i>
                            </div>
                            <div class="stat-value">300+</div>
                            <div class="stat-label">
                                {{ translate("Bayanaat Online") }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Wave divider -->
        </section>

        <!-- ===================== Courses ===================== -->
        <section id="courses" class="py-5 bg-light c-jameel-noori">
            <div class="container">
                <div
                    class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4"
                >
                    <h1 class="display-6 m-0 theme-text-color fw-bold">
                        {{ translate("Our Courses") }}
                    </h1>
                    <span class="small text-muted"
                        ><i class="bi bi-hand-index-thumb me-1"></i
                        >{{ translate("Tap a course to enroll") }}</span
                    >
                </div>

                <div class="row g-4">
                    <div
                        class="col-12 col-sm-6 col-lg-4 col-xl-3"
                        v-for="(course, index) in filterOptions"
                        :key="index"
                    >
                        <div
                            class="course-card h-100"
                            @click="goToEnroll(course)"
                            role="button"
                        >
                            <div
                                class="course-card__top d-flex align-items-center gap-3"
                            >
                                <div class="icon-pill flex-shrink-0">
                                    <i class="bi bi-mortarboard"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="mb-0 course-title">
                                        {{ course }}
                                    </h5>
                                    <div class="small opacity-75">
                                        {{ translate("Enroll now") }}
                                    </div>
                                </div>
                            </div>
                            <div
                                class="course-card__bottom d-flex align-items-center justify-content-between mt-3"
                            >
                                <span class="badge rounded-pill badge-soft">{{
                                    translate("Admissions")
                                }}</span>
                                <span class="arrow ms-2"
                                    ><i class="bi bi-arrow-right"></i
                                ></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===================== Features (Why Choose Us) ===================== -->
        <section class="features-section py-5">
            <div class="container">
                <h2 class="h1 fw-bold text-center theme-text-color mb-4">
                    {{ translate("Why Choose Noumania") }}
                </h2>
                <p class="text-center text-muted mw-740 mx-auto mb-5">
                    {{
                        translate(
                            "Faith-centered education blended with modern learning practices, a rich library of Bayanaat, and accessible guidance for every student."
                        )
                    }}
                </p>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="feature-card h-100">
                            <div class="feature-icon">
                                <i class="bi bi-book"></i>
                            </div>
                            <h5 class="mb-2">
                                {{ translate("Balanced Curriculum") }}
                            </h5>
                            <p class="text-muted mb-0">
                                {{
                                    translate(
                                        "Traditional Islamic sciences taught alongside essential contemporary skills."
                                    )
                                }}
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="feature-card h-100">
                            <div class="feature-icon">
                                <i class="bi bi-broadcast"></i>
                            </div>
                            <h5 class="mb-2">
                                {{ translate("Online Bayanaat") }}
                            </h5>
                            <p class="text-muted mb-0">
                                {{
                                    translate(
                                        "Regular recorded lectures and sermons available for students worldwide."
                                    )
                                }}
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="feature-card h-100">
                            <div class="feature-icon">
                                <i class="bi bi-emoji-smile"></i>
                            </div>
                            <h5 class="mb-2">
                                {{ translate("Student Support") }}
                            </h5>
                            <p class="text-muted mb-0">
                                {{
                                    translate(
                                        "Friendly guidance, mentorship, and admissions help whenever you need it."
                                    )
                                }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===================== Bayanaat ===================== -->
        <section class="bayanaat-section py-5">
            <div class="container">
                <h2 class="display-6 mb-4 theme-text-color fw-bold">
                    {{ translate("Latest Bayanaat") }}
                </h2>
                <div class="row g-4">
                    <div
                        class="col-md-6 col-lg-4 d-flex"
                        v-for="(video, index) in bayanaat"
                        :key="index"
                    >
                        <div
                            class="card content-card shadow-sm border-0 rounded-4 flex-fill"
                        >
                            <div class="video-wrapper ratio-16x9">
                                <iframe
                                    :src="video.url"
                                    title="YouTube video"
                                    allowfullscreen
                                    loading="lazy"
                                ></iframe>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title mb-2">
                                    {{ video.title }}
                                </h5>
                                <p class="card-text text-muted">
                                    {{ video.description }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===================== Admission CTA ===================== -->
        <section
            class="admission-section text-center text-white py-5 position-relative overflow-hidden"
        >
            <div class="admission-overlay"></div>
            <div class="container position-relative">
                <h2 class="display-6 fw-bold mb-2">
                    {{ translate("Admissions Open") }}
                </h2>
                <p class="lead opacity-90 mb-4">
                    {{
                        translate(
                            "Register now and start your journey towards Islamic knowledge"
                        )
                    }}
                </p>
                <a
                    href="/student/enroll"
                    class="btn btn-light btn-lg rounded-pill shadow px-4 py-2"
                >
                    <i class="bi bi-box-arrow-in-right me-2"></i
                    >{{ translate("Apply Now") }}
                </a>
            </div>
            <div class="pattern"></div>
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
                "تَخَصُّص فِی الفِقْہِ ایک سال",
                "تَخَصُّص فِی الفِقْہِ دو سال",
                "تحصُّص فِي اللُّغَاتِ",
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
                        "Molana Muhammad Idrees Sahib Pashto Bayan – Juma 20 06 2025"
                    ),
                    description: this.translate(
                        "Molana Muhammad Idrees Sahib’s Pashto Bayan delivered on Friday, 20 June 2025."
                    ),
                    url: "https://www.youtube.com/embed/KfVv1GGVFYU",
                },
                {
                    title: this.translate(
                        "Molana Muhammad Idrees Sahib New Pashto Bayan – 05 01 2025"
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
:root {
    --primary: #023f86;
    --primary-2: #035bb8;
    --hero-dark: rgba(0, 0, 0, 0.45);
}

.mw-740 {
    max-width: 740px;
}
.z-1 {
    z-index: 1;
}

/* ===================== HERO ===================== */
.hero-section {
    position: relative;
    min-height: 720px;
    padding: 100px 0 0;
    background: url("/images/hero-image.jpg") center center / cover no-repeat
        fixed;
}
.overlay {
    background: linear-gradient(
            120deg,
            rgb(134 2 91 / 0%),
            rgba(3, 91, 184, 0.55)
        ),
        rgb(0 0 0 / 29%);
    z-index: 1;
}
.hero-content {
    margin-top: 40px;
}
.hero-title {
    background: linear-gradient(90deg, #fff, #e8f1ff);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
}
.hero-cta {
    transform: translateY(0);
    transition: transform 0.2s ease, box-shadow 0.25s ease;
}
.hero-cta:hover {
    transform: translateY(-2px);
}

/* Orbs */
.orb {
    position: absolute;
    border-radius: 50%;
    filter: blur(16px);
    opacity: 0.5;
    z-index: 1;
}
.orb-1 {
    width: 200px;
    height: 200px;
    background: #ffcfcf30;
    top: 8%;
    left: 8%;
    animation: float 12s ease-in-out infinite;
}
.orb-2 {
    width: 240px;
    height: 240px;
    background: #ffcfcf30;
    bottom: 10%;
    right: 8%;
    animation: float 16s ease-in-out infinite reverse;
}
.orb-3 {
    width: 240px;
    height: 160px;
    background: #ffcfcf30;
    bottom: 32%;
    left: 40%;
    animation: float 18s ease-in-out infinite;
}
@keyframes float {
    0%,
    100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-14px);
    }
}

/* Hero stats */
.glass {
    background: rgba(255, 255, 255, 0.12);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 1rem;
    padding: 1.2rem 1rem;
    color: #fff;
}
.stat-card {
    text-align: center;
    transition: transform 0.2s ease, box-shadow 0.25s ease;
}
.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 16px 36px rgba(0, 0, 0, 0.12);
}
.stat-icon {
    font-size: 1.6rem;
    margin-bottom: 0.35rem;
}
.stat-value {
    font-weight: 800;
    font-size: 1.4rem;
    line-height: 1;
}
.stat-label {
    font-size: 0.9rem;
    opacity: 0.9;
}

/* ===================== COURSES ===================== */
.theme-text-color {
    color: var(--primary);
}
.course-card {
    background: #fff;
    border-radius: 1.25rem;
    padding: 1.1rem 1rem;
    box-shadow: 0 10px 24px rgba(2, 63, 134, 0.06);
    border: 1px solid rgba(2, 63, 134, 0.08);
    transition: transform 0.2s ease, box-shadow 0.25s ease,
        border-color 0.2s ease;
}
.course-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 18px 36px rgba(2, 63, 134, 0.12);
    border-color: rgba(2, 63, 134, 0.16);
}
.course-card__top {
    min-height: 64px;
}
.icon-pill {
    width: 52px;
    height: 52px;
    border-radius: 999px;
    display: grid;
    place-items: center;
    background: linear-gradient(135deg, var(--primary), var(--primary-2));
    color: #fff;
    box-shadow: 0 10px 20px rgba(2, 63, 134, 0.25);
}
.course-title {
    font-weight: 700;
    font-size: 1.05rem;
    letter-spacing: 0.2px;
    font-family: "Jameel Noori Nastaleeq", serif !important;
}
.badge-soft {
    background: rgba(3, 91, 184, 0.1);
    color: var(--primary-2);
}
.course-card__bottom .arrow {
    transition: transform 0.2s ease;
}
.course-card:hover .arrow {
    transform: translateX(4px);
}

/* ===================== FEATURES ===================== */
.features-section {
    background: #fff;
}
.feature-card {
    background: #fff;
    border-radius: 1.25rem;
    padding: 1.3rem 1.1rem;
    height: 100%;
    border: 1px solid rgba(2, 63, 134, 0.08);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.04);
    transition: transform 0.2s ease, box-shadow 0.25s ease;
}
.feature-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 18px 36px rgba(0, 0, 0, 0.08);
}
.feature-icon {
    width: 54px;
    height: 54px;
    border-radius: 14px;
    display: grid;
    place-items: center;
    background: linear-gradient(135deg, var(--primary), var(--primary-2));
    color: #fff;
    margin-bottom: 0.6rem;
}

/* ===================== BAYANAAT ===================== */
.content-card {
    transition: transform 0.2s ease, box-shadow 0.25s ease;
}
.content-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 16px 36px rgba(0, 0, 0, 0.08);
}
.ratio-16x9 {
    position: relative;
    width: 100%;
    padding-top: 56.25%;
    overflow: hidden;
    border-top-left-radius: 1rem;
    border-top-right-radius: 1rem;
}
.ratio-16x9 iframe {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    border: 0;
}

/* ===================== FAQ ===================== */
.accordion-button {
    padding: 1rem 1.25rem;
}
.accordion-button:focus {
    box-shadow: none;
}
.accordion-item {
    border: 0;
}
.accordion-button:not(.collapsed) {
    background: rgba(2, 63, 134, 0.06);
    color: #0b2850;
}

/* ===================== ADMISSION CTA ===================== */
.admission-section {
    background: linear-gradient(120deg, var(--primary), var(--primary-2));
}
.admission-overlay {
    position: absolute;
    inset: 0;
    background: radial-gradient(
            circle at 30% -10%,
            rgba(255, 255, 255, 0.18),
            transparent 45%
        ),
        radial-gradient(
            circle at 80% 120%,
            rgba(255, 255, 255, 0.12),
            transparent 45%
        );
}
.pattern {
    position: absolute;
    inset: auto 0 -50px 0;
    height: 120px;
    background: radial-gradient(
                circle at 20% 50%,
                rgba(255, 255, 255, 0.2) 2px,
                transparent 3px
            )
            0 0/40px 40px,
        radial-gradient(
                circle at 60% 50%,
                rgba(255, 255, 255, 0.15) 2px,
                transparent 3px
            )
            20px 20px/50px 50px;
    opacity: 0.25;
}

/* ===================== FOOTER ===================== */

/* ===================== RESPONSIVE ===================== */
@media (max-width: 992px) {
    .hero-section {
        min-height: 620px;
        padding: 80px 0 0;
    }
}
@media (max-width: 576px) {
    .hero-section {
        min-height: 560px;
        padding: 60px 0 0;
    }
    .hero-title {
        font-size: 2rem;
    }
}

/* ===================== DARK MODE (pref) ===================== */
@media (prefers-color-scheme: dark) {
    .features-section {
        background: #0f1420;
    }
    .feature-card {
        background: #0f1420;
        border-color: #1d2740;
    }
    .course-card {
        background: #10182a;
        border-color: #1b2942;
    }
    .bayanaat-section {
        background: #0f1420;
    }
    .accordion-button:not(.collapsed) {
        background: #10182a;
        color: #dbe4ff;
    }
}
</style>
