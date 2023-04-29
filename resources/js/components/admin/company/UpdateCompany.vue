<template>
  <div class="container mt-4">
    <div class="card">
      <div class="card-header">
        <h4>Modifier Société</h4>
      </div>
      <div class="card-body">
        <form @submit.prevent="updateCompany">
          <div class="form-group">
            <label for="name">Nom</label>
            <input type="text" class="form-control" id="name" v-model="company.name" required>
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" v-model="company.email" required>
          </div>
          <!-- <div class="form-group">
            <label for="website">Site web</label>
            <input type="text" class="form-control" id="website" v-model="company.website">
          </div> -->
          <div class="form-group">
            <label for="legal_status">Statut juridique</label>
            <select class="form-control" id="legal_status" v-model="company.legal_status" required>
            <option value="">-- Séléctionnez un statut --</option>
            <option value="SARL">SARL</option>
            <option value="SA">SA</option>
            <option value="SAS">SAS</option>
            <option value="GIE">GIE</option>
            </select>
        </div>
        <div class="form-group">
            <label for="address">Adresse</label>
            <textarea class="form-control" id="address" v-model="company.address" required></textarea>
        </div>
        <div class="form-group">
            <label for="phone">Numéro de téléphone</label>
            <input type="text" class="form-control" id="phone" v-model="company.phone_number" required>
        </div>
        <div class="form-group">
            <label for="phone">Capital sociale</label>
            <input type="number" class="form-control" id="capital" v-model="company.capital" required>
        </div>
          <button type="submit" class="btn btn-primary mt-2">Enregister</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import api from '../../../http/axios.js';
export default {
  data() {
    return {
      company: {
        name: '',
        capital: '',
        address: '',
        legal_status: '',
        phone_number: '',
        email: '',
      }
    }
  },
  methods: {
  updateCompany() {
  
    // Send POST request to API endpoint
    api.put('/api/admin/companies/'+ this.id, this.company)
      .then(response => {
        // Redirect to company list page on success
        this.$router.push('/admin/companies');
      })
      .catch(error => {
        // Handle error response
        console.log(error);
      });
  }, 
  getCompany() {
      // Submit form logic
      api.get('/api/admin/companies/'+ this.id)
        .then(response => {
          // Handle successful response
           if (response.data.company){
              this.company.name = response.data.company.name;
              this.company.capital = response.data.company.capital;
              this.company.legal_status = response.data.company.legal_status;
              this.company.phone_number = response.data.company.phone_number;
              this.company.address = response.data.company.address;
              this.company.email = response.data.company.email;
           }
        })
        .catch(error => {
            console.log(error);
        });
    },
}, mounted() {
    this.id = this.$route.params.id;
    this.getCompany();
  }

}
</script>
