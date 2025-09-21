<template>
  <main id="main" class="main">
    <!-- Contact Hero Section -->
    <section class="hero-section text-white d-flex align-items-center">
      <div class="container py-5">
        <div class="row justify-content-center text-center">
          <div class="col-xl-8 col-lg-9">
            <span class="badge bg-white-10 rounded-pill px-3 py-2 mb-3">
              <i class="bi bi-chat-dots me-2"></i>{{ translate("We'd love to hear from you") }}
            </span>
            <h1 class="display-5 fw-bold mb-3 lh-sm">
              {{ translate("Contact Us") }}
            </h1>
            <p class="lead text-white-75 mb-0">
              {{ translate("We are here to assist you. Feel free to reach out to us") }}
            </p>
          </div>
        </div>
      </div>
      <!-- Decorative -->
      <div class="hero-blur-1"></div>
      <div class="hero-blur-2"></div>
    </section>

    <!-- Contact Info Section -->
    <section class="contact-section py-5 bg-light">
      <div class="container">
        <div class="row g-4">
          <!-- Full Width Info Card -->
          <div class="col-12">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden h-100">
              <div class="card-body p-4 p-md-5">
                <h2 class="text-center fw-bold mb-4 theme-text-color">
                  {{ translate("Jamia Darol Uloom Noumania Utmanzai") }}
                </h2>

                <div class="row g-4 justify-content-center">
                  <!-- Phone -->
                  <div class="col-md-4 col-sm-6">
                    <div class="contact-item d-flex flex-column align-items-center text-center h-100">
                      <div class="icon-wrap rounded-circle d-inline-flex align-items-center justify-content-center mb-3">
                        <i class="bi bi-telephone-fill"></i>
                      </div>
                      <h6 class="fw-semibold mb-1">{{ translate("Phone") }}</h6>
                      <p class="mb-0 fs-6 text-muted">091650861</p>
                    </div>
                  </div>

                  <!-- Email -->
                  <div class="col-md-4 col-sm-6">
                    <div class="contact-item d-flex flex-column align-items-center text-center h-100">
                      <div class="icon-wrap rounded-circle d-inline-flex align-items-center justify-content-center mb-3">
                        <i class="bi bi-envelope-fill"></i>
                      </div>
                      <h6 class="fw-semibold mb-1">{{ translate("Email") }}</h6>
                      <p class="mb-0 fs-6">
                        <a href="mailto:info@jamianoumania.com" class="link-dark text-decoration-none">
                          info@jamianoumania.com
                        </a>
                      </p>
                    </div>
                  </div>

                  <!-- Address -->
                  <div class="col-md-4 col-sm-6">
                    <div class="contact-item d-flex flex-column align-items-center text-center h-100">
                      <div class="icon-wrap rounded-circle d-inline-flex align-items-center justify-content-center mb-3">
                        <i class="bi bi-geo-alt-fill"></i>
                      </div>
                      <h6 class="fw-semibold mb-1">{{ translate("Address") }}</h6>
                      <p class="mb-0 fs-6 text-muted">
                        {{ translate("Utmanzai, Charsadda, Pakistan") }}
                      </p>
                    </div>
                  </div>
                </div>
              </div>

              <!-- subtle divider line -->
              <div class="border-top border-light-subtle"></div>

              <!-- Helpful note (kept inside the card for a premium look) -->
              <div class="px-4 px-md-5 py-3 bg-lightest">
                <div class="d-flex align-items-center gap-2 small text-muted justify-content-center">
                  <i class="bi bi-info-circle"></i>
                  <span>{{ translate("Our team typically responds within 24 hours.") }}</span>
                </div>
              </div>
            </div>
          </div>

          <!-- Full Width Map -->
          <div class="col-12">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
              <div class="map-header px-4 py-3 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                  <i class="bi bi-map theme-text-color"></i>
                  <span class="fw-semibold">{{ translate("Find Us on the Map") }}</span>
                </div>
                <span class="badge rounded-pill bg-primary-subtle text-primary-emphasis">
                  {{ translate("Open Hours") }}: 9:00–17:00
                </span>
              </div>
              <div class="ratio ratio-21x9">
                <iframe
                  src="https://www.google.com/maps?q=34.17684698606916,71.76090259806283&hl=es;z=14&output=embed"
                  style="border:0;" allowfullscreen="" loading="lazy">
                </iframe>
              </div>
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
:root {
  --brand-primary: #023F86;
  --brand-primary-2: #035bb8;
}

/* ---------- HERO ---------- */
.hero-section {
  position: relative;
  background: radial-gradient(1200px 800px at 10% 10%, rgba(255,255,255,0.08), transparent 60%),
              linear-gradient(120deg, var(--brand-primary), var(--brand-primary-2));
  margin-top: 60px;
  overflow: hidden;
  border-bottom-left-radius: 1.25rem;
  border-bottom-right-radius: 1.25rem;
}

.hero-section .badge.bg-white-10 {
  background: rgba(255,255,255,0.12) !important;
  color: #fff !important;
  border: 1px solid rgba(255,255,255,0.18);
}

.text-white-75 { color: rgba(255,255,255,0.85) !important; }

/* decorative blur orbs */
.hero-blur-1, .hero-blur-2 {
  position: absolute;
  filter: blur(70px);
  opacity: 0.25;
  pointer-events: none;
}
.hero-blur-1 {
  width: 220px; height: 220px;
  right: -40px; top: -20px;
  background: #fff;
}
.hero-blur-2 {
  width: 260px; height: 260px;
  left: -60px; bottom: -40px;
  background: #a2d2ff;
}

/* ---------- THEME UTILITIES ---------- */
.theme-text-color { color: var(--brand-primary); }
.bg-lightest { background-color: #f8fafc; }

/* ---------- CONTACT CARD ---------- */
.icon-wrap {
  width: 64px;
  height: 64px;
  background: linear-gradient(135deg, rgba(2,63,134,0.08), rgba(3,91,184,0.08));
  color: var(--brand-primary);
  font-size: 1.35rem;
  box-shadow: 0 6px 20px rgba(2,63,134,0.08);
  transition: transform .2s ease, box-shadow .2s ease;
}
.contact-item:hover .icon-wrap {
  transform: translateY(-2px);
  box-shadow: 0 10px 26px rgba(2,63,134,0.12);
}

/* ---------- MAP CARD ---------- */
.map-header {
  background: linear-gradient(180deg, #ffffff, #fbfbfd);
  border-bottom: 1px solid #eef0f4;
}
.ratio-21x9 {
  --bs-aspect-ratio: calc(9 / 21 * 100%);
}

/* ---------- TYPOGRAPHY TWEAKS ---------- */
.card-body p, .card-body .fs-5, .fs-6 {
  font-size: 1rem;
}

@media (min-width: 992px) {
  .card-body p, .card-body .fs-5 { font-size: 1.05rem; }
  .fs-6 { font-size: .98rem; }
}
</style>
