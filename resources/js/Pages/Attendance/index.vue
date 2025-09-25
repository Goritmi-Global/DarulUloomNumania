<template>
  <main id="main" class="main">
    <div class="pagetitle d-flex justify-content-between">
      <div>
        <h1 class="theme-text-color">{{ translate("Attendance Management") }}</h1>
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/dashboard">{{ translate("Darul Oloom") }}</a></li>
            <li class="breadcrumb-item">{{ translate("Attendance") }}</li>
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
                <p class="mb-0 text-muted fw-bold">{{ translate('students') }} : {{ c.students_count }} </p>
              </div>
              <div class="mt-3 text-end">
                <span class="badge bg-primary">{{ translate('Open') }}</span>
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
          // res.data example: [{id:1, class_name:'Test', students_count:5}, ...]
          this.classesData = res.data || [];
        })
        .catch((err) => {
          console.error("Failed to load class cards:", err);
          this.classesData = [];
        })
        .finally(() => (this.loading = false));
    },

    goToClass(classId) {
      // Option A: use Inertia (if you have an Inertia page for class students)
      // Inertia.get(route('attendance.class.show', classId));

      // Simpler: redirect to a route you will create
      window.location.href = `/attendance/class/${classId}`;
    },
  },
};
</script>

<style scoped>
.class-card {
  cursor: pointer;
  transition: transform 0.15s, box-shadow 0.15s;
  background: linear-gradient(135deg, #89f7fe 0%, #66a6ff 100%);

  border-radius: 10px;
  padding: 15px;
  color: #333;
}

.class-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 8px 18px rgba(0, 0, 0, 0.12);
}
</style>

