<template>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>{{ translate('Class Students') }}</h1>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-body">
                    <form @submit.prevent="markAttendance">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>CNIC</th>
                                    <th>Phone</th>
                                    <th>Present</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(s, idx) in students" :key="s.id">
                                    <td>{{ idx + 1 }}</td>
                                    <td>{{ s.name }}</td>
                                    <td>{{ s.cnic }}</td>
                                    <td>{{ s.phone_number }}</td>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" v-model="attendances[s.id]"
                                                :true-value="1" :false-value="0"
                                                style="transform: scale(1.5); cursor: pointer;" />
                                        </div>
                                    </td>

                                </tr>
                            </tbody>
                        </table>

                        <button type="submit" class="btn btn-primary mt-3">
                            Mark Attendance
                        </button>
                    </form>
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
    props: {
        classData: Object,
        students: Array
    },
    data() {
        return {
            attendances: {}
        };
    },
    mounted() {
        // Default: all checked (present = 1)
        this.students.forEach(s => {
            this.attendances[s.id] = 1;
        });
    },
    methods: {
        async markAttendance() {
            try {
                const response = await axios.post("/api/attendance/mark", {
                    class_id: this.classData.id,
                    attendances: this.students.map(s => ({
                        student_id: s.id,
                        status: this.attendances[s.id] ? 1 : 0
                    }))
                });

                alert(response.data.message);
            } catch (error) {
                console.error(error);
                alert("Something went wrong while marking attendance.");
            }
        }
    }
};
</script>
