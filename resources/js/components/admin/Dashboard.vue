<template>
  <div class="dashboard">
    <div class="row">
      <div class="col-md-3">
        <div class="card card-stats">
          <div class="card-header">
            <h3 class="card-title">Totale Employées</h3>
          </div>
          <div class="card-body">
            <div class="stat-value">{{ totalEmployees }}</div>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card card-stats">
          <div class="card-header">
            <h3 class="card-title">Totale Société</h3>
          </div>
          <div class="card-body">
            <div class="stat-value">{{ totalCompanies }}</div>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card card-stats">
          <div class="card-header">
            <h3 class="card-title">Totale Admins</h3>
          </div>
          <div class="card-body">
            <div class="stat-value">{{ totalAdmins }}</div>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card card-stats">
          <div class="card-header">
            <h3 class="card-title">Totale Invitations</h3>
          </div>
          <div class="card-body">
            <div class="stat-value">{{ totalInvitations }}</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import api from '../../http/axios.js';
export default {
  data() {
    return {
      totalEmployees: 0,
      totalCompanies: 0,
      totalAdmins: 0,
      totalInvitations: 0,
    };
  },
  created() {
    this.fetchDashboardData();
  },
  methods: {
    fetchDashboardData() {
      // Make an API call to fetch the dashboard data
      api.get('/api/admin/dashboard').then((response) => {
        this.totalEmployees = response.data.employees;
        this.totalCompanies = response.data.companies;
        this.totalAdmins = response.data.admins;
        this.totalInvitations = response.data.invitations;
      });
    },
  },
};
</script>

<style scoped>
.dashboard {
  padding: 20px;
}

.card {
  margin-bottom: 30px;
  box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.05);
  border-radius: 10px;
}

.card-header {
  background-color: #f5f5f5;
  padding: 20px;
  border-top-left-radius: 10px;
  border-top-right-radius: 10px;
}

.card-title {
  margin-bottom: 0;
}

.card-body {
  padding: 20px;
  font-size: 24px;
}

.stat-value {
  font-weight: bold;
}
</style>
