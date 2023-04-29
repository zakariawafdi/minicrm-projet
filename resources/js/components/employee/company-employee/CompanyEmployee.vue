<template>
  <div class="company">
    <div class="row">
      <div class="col-sm-3">
        <label class="font-weight-bold">Société:</label>
      </div>
      <div class="col-sm-9">
        <span>{{ company.name }}</span>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-3">
        <label class="font-weight-bold">Adresse:</label>
      </div>
      <div class="col-sm-9">
        <span>{{ company.address }}</span>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-3">
        <label class="font-weight-bold">Téléphone:</label>
      </div>
      <div class="col-sm-9">
        <span>{{ company.phone_number }}</span>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-3">
        <label class="font-weight-bold">Statut juridique:</label>
      </div>
      <div class="col-sm-9">
        <span>{{ company.legal_status }}</span>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-3">
        <label class="font-weight-bold">Capitale sociale:</label>
      </div>
      <div class="col-sm-9">
        <span>{{ company.capital }}</span>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-3">
        <label class="font-weight-bold">Employées:</label>
      </div>
      <div class="col-sm-9">
        <ul>
          <li v-for="employee in company.employees" :key="employee.id">
            {{ employee.name }} - {{ employee.email }} - {{ employee.phone_number }}
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
import api from '../../../http/axios.js';

export default {
  name: 'Company',
  data() {
    return {
      
      company: {
          name: '',
          capital: '',
          address: '',
          legal_status: '',
          phone_number: '',
          email: '',
      },
    };
  },
  methods: {
    fetchCompany() {

      api.get('/api/employee/company/')
        .then(response => {
          // Handle successful response
           if (response.data.company){
              this.company = response.data.company;
           } else {
            this.$router.push('/employee/');
           }
        })
        .catch(error => {
            this.$router.push('/employee/');
        });
    },
  }, mounted() {
    this.fetchCompany();
  }
};
</script>

<style>
.company {
  font-family: Arial, sans-serif;
  color: #333;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

.row {
  margin-bottom: 10px;
}

.col-sm-3 {
  font-weight: bold;
}

ul {
  list-style: none;
  margin: 0;
  padding: 0;
}

li {
  margin-bottom: 5px;
}
</style>