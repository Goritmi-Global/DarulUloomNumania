<template>
    <main id="main" class="main">
        <!-- Hero Section -->
        <section class="hero-section text-center py-5 text-white">
            <div class="container">
                <h1 class="display-4">Upcoming Events</h1>
                <p class="lead">
                    Stay updated with the latest events and programs at
                    Jamia Darol Uloom Noumania Utmanzai.
                </p>
            </div>
        </section>

        <!-- Events Section -->
        <section class="events-section py-2 bg-light">
            <div class="container">
                <h1 class="display-4 p-3 theme-text-color">Our Events</h1>
                <div class="row">
                    <div
                        class="col-md-4 d-flex align-items-stretch"
                        v-for="(event, index) in events"
                        :key="index"
                    >
                        <div class="card content-card">
                            <img
                                :src="event.image"
                                class="card-img-top"
                                alt="Event Image"
                            />
                            <div class="card-body">
                                <h5 class="card-title">{{ event.title }}</h5>
                                <p class="card-text"><strong>Date:</strong> {{ event.date }}</p>
                                <p class="card-text">{{ event.description }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Highlights Section -->
        <section class="highlights-section text-center py-5">
            <div class="container">
                <h2>Event Highlights</h2>
                <p>
                    Our events focus on Islamic education, spiritual growth, and
                    community engagement. Join us and be part of the learning and
                    enlightenment.
                </p>
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
            events: [
                {
                    title: "Annual Quran Recitation Competition",
                    date: "March 25, 2025",
                    description:
                        "Join us for a spiritually uplifting Quran recitation competition. Open to all ages.",
                    image: "https://images.unsplash.com/photo-1601191362988-ac6ebec629c8?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8N3x8aXNsYW1pYyUyMGFyY2hpdGVjdHVyZXxlbnwwfHwwfHx8MA%3D%3D",
                },
                {
                    title: "Ramadan Spiritual Retreat",
                    date: "April 10, 2025",
                    description:
                        "A special retreat to enhance your faith and understanding of Ramadan blessings.",
                    image: "https://sahlahacademy.net/wp-content/uploads/2023/10/islamic-stories-for-kids.jpg",
                },
                {
                    title: "Islamic Knowledge Conference",
                    date: "May 15, 2025",
                    description:
                        "Renowned scholars will discuss contemporary Islamic topics and knowledge.",
                    image: "https://www.worldatlas.com/r/w1200/upload/79/07/6d/masjid-al-haram.jpg",
                },
            ],
        };
    },
};
</script>

<style>
.hero-section {
    margin-top: 70px;
    background-color: var(--primary-color);
}

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
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}
.theme-text-color {
    color: var(--primary-color);
}
</style>