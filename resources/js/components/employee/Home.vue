<template>
    <div class="col-md-9">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Bonjour, {{name}}</h5>
          <p class="card-text">Bienvenue dans votre espace employée.</p>
        </div>
      </div>
    </div>
</template>
<script>
import api from '../../http/axios.js';

export default {
  name: 'home employee area',
  data() {
    return {
      name: ''
    };
  },
  methods: {
    getEmployee() {
      // Submit form logic
      api.get('/api/employee/')
        .then(response => {
          // Handle successful response
           if (response.data.employee.name){
              this.name = response.data.employee.name;
           }
        })
        .catch(error => {
            console.log(error);
        });
    },
  },
  mounted() {
    this.getEmployee();
  }
};
</script>