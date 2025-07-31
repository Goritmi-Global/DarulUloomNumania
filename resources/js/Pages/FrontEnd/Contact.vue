<template>
  <main id="main" class="main">
    <!-- Contact Hero Section -->
    <section class="hero-section text-center text-white py-5">
      <div class="container">
        <h1 class="display-4 fw-bold">{{ translate("Contact Us") }}</h1>
        <p class="lead">{{ translate("We are here to assist you. Feel free to reach out to us") }}</p>
      </div>
    </section>

    <!-- Contact Info Section -->
    <section class="contact-section py-5 bg-light">
      <div class="container">
        <div class="row g-4">
          <!-- Full Width Info Card -->
          <div class="col-12">
            <div class="card shadow-sm border-0 rounded-4 p-4 h-100">
              <div class="card-body">
                <h2 class="theme-text-color mb-4 text-center">
                  {{ translate("Jamia Darol Uloom Noumania Utmanzai") }}
                </h2>
                <div class="row text-center fs-5">
                  <div class="col-md-4 mb-3">
                    <i class="bi bi-telephone-fill me-2 ms-2 theme-text-color"></i><br />
                    <strong>{{ translate("Phone") }}</strong><br />
                    091650861
                  </div>
                  <div class="col-md-4 mb-3">
                    <i class="bi bi-envelope-fill me-2 ms-2 theme-text-color"></i><br />
                    <strong>{{ translate("Email") }}</strong><br />
                    info@jamianoumania.com
                  </div>
                  <div class="col-md-4 mb-3">
                    <i class="bi bi-geo-alt-fill me-2 ms-2 theme-text-color"></i><br />
                    <strong>{{ translate("Address") }}</strong><br />
                    {{ translate("Utmanzai, Charsadda, Pakistan") }}
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Full Width Map -->
          <div class="col-12">
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
              <iframe
                src="https://www.google.com/maps?q=34.17684698606916,71.76090259806283&hl=es;z=14&output=embed"
                width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy">
              </iframe>
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
  background: linear-gradient(120deg, #023F86, #035bb8);
  color: white;
  margin-top: 60px;
}
.theme-text-color {
  color: #023F86;
}
.card-body p,
.card-body .fs-5 {
  font-size: 1.1rem;
}
</style>
