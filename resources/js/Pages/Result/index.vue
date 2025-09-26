<template>
  <main id="main" class="main">
    <div class="pagetitle d-flex justify-content-between">
      <div>
        <h1 class="theme-text-color">{{ translate("Result Management") }}</h1>
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/dashboard">{{ translate("Darul Oloom") }}</a></li>
            <li class="breadcrumb-item">{{ translate("Results") }}</li>
            <li class="breadcrumb-item active">{{ translate("Classes") }}</li>
          </ol>
        </nav>
      </div>
    </div>

    <section class="section">
      <div class="row">
        <div v-if="loading" class="col-12 text-center my-5">
          <div class="spinner-border" role="status"></div>
        </div>

        <div v-else-if="classesData.length === 0" class="col-12">
          <div class="alert alert-warning">{{ translate("No classes found.") }}</div>
        </div>

        <div v-else v-for="c in classesData" :key="c.id" class="col-6 col-md-3 mb-4">
          <div class="card shadow-sm class-card h-100 d-flex " @click="goToClass(c.id)" role="button">
            <div class="card-body d-flex flex-column justify-content-between">
              <div>
                <h5 class="card-title theme-text-color mb-2">{{ c.class_name }}</h5>
                <p class="mb-0 text-muted fw-bold">{{ translate('students') }} : {{ c.students_count }}</p>
              </div>
              <div class="mt-3 text-end">
                <span class="badge result">{{ translate('Enter Results') }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
</template>

<script>
import axios from "axios";
import Master from "../Layout/Master.vue";

export default {
  layout: Master,
  data() {
    return {
      classesData: [],
      loading: true,
    };
  },
  created() {
    this.fetchClassCards();
  },

  methods: {
    fetchClassCards() {
      this.loading = true;
      axios
        .get(route("api.classes.cards"))
        .then((res) => {
          this.classesData = res.data || [];
        })
        .catch((err) => {
          console.error("Failed to load class cards:", err);
          this.classesData = [];
        })
        .finally(() => (this.loading = false));
    },
    goToClass(classId) {
      window.location.href = `/results/class/${classId}`;
    },
  },
};
</script>
<style scoped>
.class-card {
  cursor: pointer;
  transition: transform 0.15s, box-shadow 0.15s;
  background: #ffffff; /* White background */
  border-radius: 10px;
  padding: 15px;
  color: #333;
  box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15); /* Deeper shadow */
}

.class-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 10px 24px rgba(0, 0, 0, 0.2); /* Stronger hover shadow */
}


.result {
  background-color: #1C0D82;
  padding: 10px;
}
</style>